@extends('templates.dashboardCashier')
@include('templates.script')

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1>Transaction History</h1>
  </div>
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('cashier.dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Transaction History</li>
    </ol>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Your Past Transactions</h3>
  </div>
  <div class="card-body p-0">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Date</th>
          <th>Total</th>
          <th>Cashier</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($transaction as $trx)
        <tr>
            <td>{{ $trx->id }}</td>
            <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
            <td>Rp{{ number_format($trx->total, 0, ',', '.') }}</td>
            <td>{{ $trx->user->name }}</td>
            <td>
            <a href="{{ route('cashier.transactions.show', $trx->id) }}" class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i> View
            </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">No transactions found.</td>
        </tr>
        @endforelse

      </tbody>
    </table>
  </div>
  <div class="card-footer clearfix">
    {{ $transaction->links() }}
  </div>
</div>
@endsection
