<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $lowStockProducts = Product::where('stock', '<', 5)->get();
        return view('admin.dashboard', compact('lowStockProducts'));
    }
}
