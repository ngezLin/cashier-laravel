<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function showProducts()
    {
        $products = \App\Models\Product::where('stock', '>', 0)->get();
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

}
