<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
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

    public function refund(Transaction $transaction)
    {
        if ($transaction->is_refunded) {
            return redirect()->back()->with('error', 'Transaction already refunded.');
        }

        DB::transaction(function () use ($transaction) {
            $transaction->is_refunded = true;
            $transaction->save();

            foreach ($transaction->items as $item) {
                $product = $item->product;
                $product->stock += $item->quantity;
                $product->save();
            }
        });

        return redirect()->back()->with('success', 'Transaction has been refunded.');
    }
}
