<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class CartController extends Controller
{

    public function showProducts(Request $request)
    {
        $query = Product::where('stock', '>', 0);

        if ($request->has('search') && !empty($request->search)) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(9)->withQueryString();

        // Tambahkan mini cart data
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $cartTotal = $cartItems->sum(fn($item) => $item->product->sell_price * $item->quantity);

        return view('cashier.products.list', compact('products', 'cartItems', 'cartTotal'));
    }


    public function remove($id)
    {
        $cartItem = Cart::where('user_id', auth()->id())->findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $request->product_id
            ],
            [
                'quantity' => DB::raw('quantity + ' . $request->quantity)
            ]
        );

        return redirect()->back()->with('success', 'Item added to cart!');
    }

    public function index(Request $request)
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $cartTotal = $cartItems->sum(fn($item) => $item->product->sell_price * $item->quantity);

        if ($request->ajax()) {
            return view('cashier.partials.miniCart', compact('cartItems', 'cartTotal'))->render();
        }

        return view('cashier.carts.viewCart', compact('cartItems', 'cartTotal'));
    }


    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(fn($item) => $item->product->sell_price * $item->quantity);
        $customerAmount = $request->input('customer_amount');

        if ($customerAmount < $total) {
            return redirect()->back()->with('error', 'The amount given is less than the total.');
        }

        $change = $customerAmount - $total;

        DB::beginTransaction();
        try {
            // Hapus draft lama milik user (kalau ada)
            Transaction::where('user_id', $user->id)
                ->where('status', 'draft')
                ->delete();

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'total' => $total,
                'customer_amount' => $customerAmount,
                'change' => $change,
                'payment_method' => $request->input('payment_method'), // ✅ baru
                'note' => $request->input('note'), // ✅ baru
                'status' => 'completed',
            ]);

            foreach ($cartItems as $item) {
                $product = $item->product;

                if ($product->stock < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$product->product_name}.");
                }

                $product->decrement('stock', $item->quantity);

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'price' => $product->sell_price,
                    'status' => 'completed',
                ]);
            }

            Cart::where('user_id', $user->id)->delete();
            DB::commit();

            return redirect()->route('cashier.transactions.success', ['transaction' => $transaction->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }




    public function transactionSuccess(Transaction $transaction)
    {
        $transaction->load('items.product');
        return view('cashier.carts.transactionSuccess', compact('transaction'));
    }

    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:increase,decrease',
        ]);

        $cartItem = Cart::where('user_id', auth()->id())->findOrFail($id);
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
                return redirect()->back()->with('success', 'Item removed from cart.');
            }
        }

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function saveDraft(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $total = $cartItems->sum(fn($item) => $item->product->sell_price * $item->quantity);

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'draft',
                'customer_amount' => 0,
                'change' => 0,
                'payment_method' => $request->input('payment_method'), // optional
                'note' => $request->input('note'), // optional
            ]);

            foreach ($cartItems as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->sell_price,
                ]);
            }

            Cart::where('user_id', $user->id)->delete();

            DB::commit();
            return redirect()->route('cashier.transactions.drafts')->with('success', 'Draft saved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to save draft.');
        }
    }


    public function showDrafts()
    {
        $drafts = Transaction::with('items.product')
            ->where('user_id', auth()->id())
            ->where('status', 'draft')
            ->latest()
            ->get();

        return view('cashier.carts.drafts', compact('drafts'));
    }

    public function loadDraft($id)
    {
        $draft = Transaction::with('items.product')
            ->where('user_id', auth()->id())
            ->where('status', 'draft')
            ->findOrFail($id);

        foreach ($draft->items as $item) {
            Cart::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'product_id' => $item->product_id,
                ],
                [
                    'quantity' => $item->quantity,
                ]
            );
        }

        $draft->delete(); // hapus draft setelah diload (opsional)

        return redirect()->route('cashier.cart.index')->with('success', 'Draft loaded into cart!');
    }

    public function viewDraft()
    {
        $drafts = Transaction::with('items.product')
            ->where('user_id', auth()->id())
            ->where('status', 'draft')
            ->latest()
            ->get();

        return view('cashier.carts.drafts', compact('drafts'));
    }

}
