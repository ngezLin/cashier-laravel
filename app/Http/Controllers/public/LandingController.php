<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('stock', '>', 0);

        if ($request->has('search') && !empty($request->search)) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('updated_at', 'desc')->get();

        return view('welcome', compact('products'));
    }
}
