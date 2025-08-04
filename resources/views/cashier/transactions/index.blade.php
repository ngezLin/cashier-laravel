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
    <div class="table-responsive">
        <table class="table table-striped">
        <thead>
            <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Total</th>
            <th>Cashier</th>
            <th>Status</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
            <tr>
                <td>{{ $trx->id }}</td>
                <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                <td>Rp{{ number_format($trx->total, 0, ',', '.') }}</td>
                <td>{{ $trx->user->name }}</td>
                <td>
                @if($trx->is_refunded)
                    <span class="badge bg-danger">Refunded</span>
                @else
                    <span class="badge bg-success">Completed</span>
                @endif
                </td>
                <td>
                <a href="{{ route('cashier.transactions.show', $trx->id) }}" class="btn btn-sm btn-info">
                    <i class="fas fa-eye"></i> View
                </a>
                @if(!$trx->is_refunded)
                    <form action="{{ route('cashier.transactions.refund', $trx->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to refund this transaction?');">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-undo"></i> Refund
                    </button>
                    </form>
                @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No transactions found.</td>
            </tr>
            @endforelse
        </tbody>
        </table>
    </div>
    </div>

  <div class="card-footer clearfix">
    {{ $transactions->links() }}
  </div>
</div>
@endsection
