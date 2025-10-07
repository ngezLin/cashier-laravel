@extends('templates.dashboard')
@include('templates.script')

<link rel="stylesheet" href="{{ asset('css/print.css') }}">

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Invoice</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Invoice</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="invoice p-3 mb-3" id="print-area">
            <!-- Info Header -->
            <div class="row mb-4">
                <div class="col-sm-6">
                    <strong>Transaction ID:</strong> {{ $transaction->id }}<br>
                    <strong>Date:</strong> {{ $transaction->created_at->format('d M Y H:i') }}<br>
                    <strong>Cashier:</strong> {{ $transaction->user->name }}
                </div>
            </div>

            <!-- Product Table -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Str::limit($item->product->product_name, 15) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment & Summary -->
            <div class="row mt-4">
                <div class="col-6">
                    <p class="lead">Payment Method:</p>
                    <p>{{ $transaction->payment_method ?? '-' }}</p>

                    @if($transaction->note)
                    <p class="lead mt-3">Note:</p>
                    <p>{{ $transaction->note }}</p>
                    @endif
                </div>
                <div class="col-6">
                    <p class="lead">Amount Summary</p>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width: 50%">Total:</th>
                                <td>Rp{{ number_format($transaction->total, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Amount Given:</th>
                                <td>Rp{{ number_format($transaction->customer_amount, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Change:</th>
                                <td>Rp{{ number_format($transaction->change, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row no-print mt-4">
                <div class="col-12">
                    <button onclick="window.print()" class="btn btn-default">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <a href="{{ route('admin.products.list') }}" class="btn btn-primary float-right">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styling -->
<style>
@media print {
    .no-print {
        display: none !important;
    }
}
</style>
@endsection
