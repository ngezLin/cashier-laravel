<?php

namespace App\Http\Controllers\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $lowStockProducts = Product::where('stock', '<', 5)->get();
        $productCount = Product::count();
        $transactionCount = Transaction::count();
        $totalRevenue = Transaction::sum('total');
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'lowStockProducts',
            'productCount',
            'transactionCount',
            'totalRevenue',
            'recentTransactions'
        ));
    }
}
