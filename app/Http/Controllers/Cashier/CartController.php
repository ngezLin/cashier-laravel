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

        return view('cashier.products.index', compact('products'));
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

    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        return view('cashier.carts.viewCart', compact('cartItems'));
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

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total' => $total,
            'customer_amount' => $customerAmount,
            'change' => $change,
        ]);

        foreach ($cartItems as $item) {
            $product = $item->product;

            if ($product->stock < $item->quantity) {
                return redirect()->back()->with('error', "Insufficient stock for {$product->product_name}.");
            }

            $product->decrement('stock', $item->quantity);

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'quantity' => $item->quantity,
                'price' => $product->sell_price,
            ]);
        }

        Cart::where('user_id', $user->id)->delete();

        // Redirect to success page
        return redirect()->route('cashier.transactions.success', ['transaction' => $transaction->id]);
    }


    public function transactionSuccess(Transaction $transaction)
    {
        $transaction->load('items.product');
        return view('cashier.carts.transactionSuccess', compact('transaction'));
    }

}
