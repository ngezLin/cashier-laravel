<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /** 🧾 List Produk */
    public function index(Request $request)
    {
        $query = Product::query();

        // 🔍 Filter pencarian
        if ($request->filled('search')) {
            $query->where('product_name', 'like', "%{$request->search}%");
        }

        $products = $query->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    /** ➕ Form Tambah */
    public function create()
    {
        return view('admin.products.create');
    }

    /** 💾 Simpan Produk Baru */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'sku' => 'required|unique:products,sku',
            'sell_price' => 'required|numeric',
            'buy_price' => 'required|numeric',
            'stock' => 'required|integer',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image_file')) {
            // Simpan file ke storage/public/products
            $imagePath = $request->file('image_file')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            // Pakai URL langsung
            $imagePath = $request->image_url;
        }

        Product::create([
            'product_name' => $validated['product_name'],
            'sku' => $validated['sku'],
            'sell_price' => $validated['sell_price'],
            'buy_price' => $validated['buy_price'],
            'stock' => $validated['stock'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }


    /** ✏️ Edit Produk */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /** 🔄 Update Produk */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'sell_price' => 'required|numeric',
            'buy_price' => 'required|numeric',
            'stock' => 'required|integer',
            'image_url' => 'nullable|url',
            'image_file' => 'nullable|image|max:2048',
        ]);

        $imagePath = $product->image; // default ke yang lama

        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $product->update([
            'product_name' => $validated['product_name'],
            'sku' => $validated['sku'],
            'sell_price' => $validated['sell_price'],
            'buy_price' => $validated['buy_price'],
            'stock' => $validated['stock'],
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /** 📥 Import CSV */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        $header = array_map('trim', $data[0]);
        unset($data[0]);

        $imported = 0;

        foreach ($data as $row) {
            $row = @array_combine($header, $row);
            if (!$row) continue;

            $validator = Validator::make($row, [
                'product_name' => 'required',
                'sell_price' => 'required|numeric',
                'buy_price' => 'required|numeric',
                'stock' => 'required|integer',
                'sku' => 'nullable|unique:products,sku',
                'image' => 'nullable|string',
            ]);

            if ($validator->fails()) continue;

            if (empty($row['sku'])) {
                $row['sku'] = strtoupper(Str::random(8));
            }

            Product::create($row);
            $imported++;
        }

        return redirect()->route('admin.products.index')
            ->with('success', "Produk berhasil diimport! Total: {$imported}");
    }
}
