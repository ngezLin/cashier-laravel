<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $transaction = Transaction::with('user')
    //         ->where('user_id', Auth::id())
    //         ->latest()
    //         ->paginate(10);

    //     return view('cashier.transactions.index', compact('transaction'));
    // }

    public function index()
    {
        $transactions = Transaction::with('user')->latest()->paginate(10);

        return view('cashier.transactions.index', compact('transactions'));
    }


    public function show(Transaction $transaction)
    {
        $transaction->load('items.product', 'user');

        return view('cashier.transactions.show', compact('transaction'));
    }
}
