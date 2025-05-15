@include('templates.script')
@extends('templates.dashboardCashier')

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>Transaction Details</h1>
  </div>
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('cashier.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('cashier.transactions.index') }}">Transaction History</a></li>
      <li class="breadcrumb-item active">Transaction #{{ $transaction->id }}</li>
    </ol>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Transaction #{{ $transaction->id }}</h3>
  </div>
  <div class="card-body">
    <p><strong>Date:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
    <p><strong>Cashier:</strong> {{ $transaction->user->name }}</p>
    <p><strong>Total:</strong> Rp{{ number_format($transaction->total, 0, ',', '.') }}</p>

    <hr>

    <h5>Items</h5>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Product</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach($transaction->items as $index => $item)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $item->product->product_name }}</td>
          <td>{{ $item->quantity }}</td>
          <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
          <td>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
