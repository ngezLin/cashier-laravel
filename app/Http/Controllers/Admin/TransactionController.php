<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // 🛒 Tampilkan produk + mini cart
    public function showProducts(Request $request)
    {
        $query = Product::where('stock', '>', 0);

        if ($request->has('search') && !empty($request->search)) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(9)->withQueryString();
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $cartTotal = $cartItems->sum(fn($item) => $item->product->sell_price * $item->quantity);

        return view('admin.transactions.list', compact('products', 'cartItems', 'cartTotal'));
    }

    // ➕ Tambah ke cart
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();
        $product = Product::findOrFail($request->product_id);

        // Check stock availability
        $existingCart = Cart::where('product_id', $request->product_id)
            ->where('user_id', $userId)
            ->first();

        $newTotalQty = $request->quantity + ($existingCart ? $existingCart->quantity : 0);

        if ($newTotalQty > $product->stock) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available!'
                ], 400);
            }
            return redirect()->back()->with('error', 'Not enough stock available!');
        }

        $cartItem = Cart::updateOrCreate(
            ['product_id' => $request->product_id, 'user_id' => $userId],
            ['quantity' => DB::raw('quantity + ' . $request->quantity), 'user_id' => $userId]
        );

        if ($request->ajax()) {
            $cartItems = Cart::with('product')->where('user_id', $userId)->get();
            $cartTotal = $cartItems->sum(fn($i) => $i->product->sell_price * $i->quantity);

            // Generate cart HTML
            $cartHtml = view('admin.transactions.partials.cart-items', compact('cartItems', 'cartTotal'))->render();

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart!',
                'cartTotal' => $cartTotal,
                'cartCount' => $cartItems->count(),
                'cartHtml' => $cartHtml,
                'formattedTotal' => 'Rp' . number_format($cartTotal, 0, ',', '.')
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart!');
    }

    // 🧾 Lihat cart
    public function viewCart()
    {
        $cartItems = Cart::with('product')->get();
        $cartTotal = $cartItems->sum(fn($i) => $i->product->sell_price * $i->quantity);
        return view('admin.transactions.viewCart', compact('cartItems', 'cartTotal'));
    }

    // ❌ Hapus item cart
    public function removeItem($id)
    {
        $item = Cart::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Item removed.');
    }

    // 🔄 Update quantity
    public function updateQuantity(Request $request, $id)
    {
        $request->validate(['action' => 'required|in:increase,decrease']);
        $cartItem = Cart::findOrFail($id);
        $product = $cartItem->product;

        if ($request->action === 'increase') {
            if ($product->stock <= $cartItem->quantity) {
                return redirect()->back()->with('error', 'Stock limit reached.');
            }
            $cartItem->increment('quantity');
        } elseif ($request->action === 'decrease') {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            } else {
                $cartItem->delete();
            }
        }

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    // 💾 Simpan draft
    public function saveDraft()
    {
        $user = auth()->user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) return back()->with('error', 'Cart is empty.');

        DB::transaction(function () use ($user, $cartItems) {
            $total = $cartItems->sum(fn($i) => $i->product->sell_price * $i->quantity);

            $trx = Transaction::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'draft',
                'customer_amount' => 0,
                'change' => 0,
            ]);

            foreach ($cartItems as $item) {
                TransactionItem::create([
                    'transaction_id' => $trx->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->sell_price,
                ]);
            }

            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('admin.drafts')->with('success', 'Draft saved.');
    }

    // 📂 Lihat draft
    public function drafts()
    {
        $drafts = Transaction::with('items.product')
            ->where('status', 'draft')
            ->latest()
            ->get();

        return view('admin.transactions.drafts', compact('drafts'));
    }

    // 📤 Load draft ke cart
    public function loadDraft($id)
    {
        $draft = Transaction::with('items.product')
            ->where('status', 'draft')
            ->findOrFail($id);

        foreach ($draft->items as $item) {
            Cart::updateOrCreate(
                ['user_id' => auth()->id(), 'product_id' => $item->product_id],
                ['quantity' => $item->quantity]
            );
        }

        $draft->delete();

        return redirect()->route('admin.cart')->with('success', 'Draft loaded into cart!');
    }

    // ✅ Checkout
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) return back()->with('error', 'Cart is empty.');

        $total = $cartItems->sum(fn($i) => $i->product->sell_price * $i->quantity);
        $customer = $request->input('customer_amount');

        if ($customer < $total) return back()->with('error', 'Insufficient amount.');

        $change = $customer - $total;

        DB::transaction(function () use ($user, $cartItems, $total, $customer, $change, $request, &$trx) {
            $trx = Transaction::create([
                'user_id' => $user->id,
                'total' => $total,
                'customer_amount' => $customer,
                'change' => $change,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'status' => 'completed',
            ]);

            foreach ($cartItems as $item) {
                $product = $item->product;
                if ($product->stock < $item->quantity)
                    throw new \Exception("Stock not enough for {$product->product_name}");

                $product->decrement('stock', $item->quantity);

                TransactionItem::create([
                    'transaction_id' => $trx->id,
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'price' => $product->sell_price,
                    'status' => 'completed',
                ]);
            }

            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('admin.transactions.success', $trx->id);
    }

    // 🧾 Invoice sukses
    public function success(Transaction $transaction)
    {
        $transaction->load('items.product', 'user');
        return view('admin.transactions.transactionSuccess', compact('transaction'));
    }

    // 📜 Riwayat transaksi
    public function index()
    {
        $transactions = Transaction::with(['user', 'items.product'])
            ->latest()
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    // 🔍 Detail transaksi
    public function show(Transaction $transaction)
    {
        $transaction->load('items.product', 'user');
        return view('admin.transactions.show', compact('transaction'));
    }

    // 🔁 Refund
    public function refund(Transaction $transaction)
    {
        if ($transaction->is_refunded)
            return back()->with('error', 'Already refunded.');

        DB::transaction(function () use ($transaction) {
            $transaction->update(['is_refunded' => true]);
            foreach ($transaction->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        });

        return back()->with('success', 'Refund processed.');
    }

    public function clearCart()
    {
        $userId = auth()->id();
        Cart::where('user_id', $userId)->delete();
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
}
