@include('templates.script')
@extends('templates.dashboardCashier')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form action="{{ route('cashier.products.list') }}" method="GET" class="d-flex" style="gap: 0.5rem;">
            <input type="text" name="search" class="form-control form-control-sm" style="width: 200px;"
                placeholder="Search..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary btn-sm">Search</button>
        </form>

    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                <p class="card-text mb-1">Stock: {{ $product->stock }}</p>
                                <p class="card-text mb-2">
                                    Price: <strong>Rp{{ number_format($product->sell_price, 0, ',', '.') }}</strong>
                                </p>

                                <form action="{{ route('cashier.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="input-group">
                                        <input type="number" name="quantity" value="1" min="1"
                                            max="{{ $product->stock }}" class="form-control" required>
                                        <button type="submit" class="btn btn-success">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm sticky-top" style="top: 80px;">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">🛒 Mini Cart</h5>
                </div>
                <div class="card-body">
                    @if($cartItems->isEmpty())
                        <p class="text-muted">Your cart is empty.</p>
                    @else
                        <ul class="list-group mb-3">
                            @foreach($cartItems as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item->product->product_name }}</strong><br>
                                        <small>Qty: {{ $item->quantity }}</small>
                                    </div>
                                    <span>Rp{{ number_format($item->product->sell_price * $item->quantity, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-between fw-bold border-top pt-2">
                            <span>Total:</span>
                            <span>Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="mt-3 d-grid gap-2">
                            <a href="{{ route('cashier.cart.index') }}" class="btn btn-success w-100">Go to Cart</a>
                            <a href="{{ route('cashier.cart.draft') }}" class="btn btn-warning w-100">View Drafts</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
