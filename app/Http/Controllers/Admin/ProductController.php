<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        //search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('product_name', 'like', "%{$search}%");
        }

        $products = $query->get();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'sell_price' => 'required',
            'buy_price' => 'required',
            'stock' => 'required',
        ]);

        Product::create($validated);
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'sell_price' => 'required',
            'buy_price' => 'required',
            'stock' => 'required',
        ]);

        $product->update($validated);
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map(function($line) {
            return str_getcsv($line, ","); // delimiter comma
        }, file($path));

        // dd($data);

        $header = array_map('trim', $data[0]);
        // unset($data[0]);

        foreach ($data as $row) {
            $row = array_combine($header, $row);

            $validator = Validator::make($row, [
                'product_name' => 'required',
                'sell_price' => 'required|numeric',
                'buy_price' => 'required|numeric',
                'stock' => 'required|integer',
            ]);

            if ($validator->fails()) continue;

            Product::create($row);
        }


        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diimport!');
    }
}
