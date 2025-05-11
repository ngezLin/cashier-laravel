@include('templates.script')
@extends('templates.dashboardCashier')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Available Products</h2>
        <a href="{{ route('cashier.cart.index') }}" class="btn btn-primary">View Cart</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <p class="card-text">Stock: {{ $product->stock }}</p>
                        <p class="card-text">Price: Rp{{ number_format($product->sell_price, 0, ',', '.') }}</p>

                        <form action="{{ route('cashier.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="input-group mb-2">
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-success">Add to Cart</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
