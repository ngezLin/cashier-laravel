@include('templates.script')
@extends('templates.dashboard')

@section('content')
<div class="row mt-4">
    {{-- summary --}}
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $productCount }}</h3>
                <p>Total Products</p>
            </div>
            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $transactionCount }}</h3>
                <p>Total Transactions</p>
            </div>
            <div class="icon">
                <i class="fas fa-receipt"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                <p>Total Revenue</p>
            </div>
            <div class="icon">
                <i class="fas fa-coins"></i>
            </div>
        </div>
    </div>
</div>

{{-- low stock --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Low Stock Products (Stock &lt; 5)</h3>
                <div class="card-tools">
                    <form method="GET" action="{{ route('admin.dashboard') }}">
                        {{-- <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                @if($lowStockProducts->isEmpty())
                    <p class="p-3">All products have sufficient stock.</p>
                @else
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Sell Price</th>
                                <th>Buy Price</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lowStockProducts as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>Rp {{ number_format($product->sell_price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($product->buy_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $product->stock == 0 ? 'badge-danger' : 'badge-warning' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- recent transactions --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Transactions</h3>
            </div>
            <div class="card-body table-responsive p-0">
                @if($recentTransactions->isEmpty())
                    <p class="p-3">No recent transactions found.</p>
                @else
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cashier</th>
                                <th>Total</th>
                                <th>Customer Amount</th>
                                <th>Change</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentTransactions as $trx)
                                <tr>
                                    <td>{{ $trx->id }}</td>
                                    <td>{{ $trx->user->name }}</td>
                                    <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($trx->customer_amount, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($trx->change, 0, ',', '.') }}</td>
                                    <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
