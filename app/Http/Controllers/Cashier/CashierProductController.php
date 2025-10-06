<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CashierProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('cashier.products.index', compact('products'));
    }

    public function create()
    {
        return view('cashier.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create($request->all());

        return redirect()->route('cashier.products.index')->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        return view('cashier.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update($request->all());

        return redirect()->route('cashier.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('cashier.products.index')->with('success', 'Product deleted successfully.');
    }
}
