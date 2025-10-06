@include('templates.script')
@extends('templates.dashboardCashier')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        {{-- Form Search --}}
        <form action="{{ route('cashier.products.index') }}" method="GET" class="d-flex" style="gap: 0.5rem;">
            <input type="text" name="search" class="form-control form-control-sm" style="width: 200px;" placeholder="Search..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary btn-sm">Search</button>
        </form>

        {{-- Cart & Draft Buttons --}}
        <div class="d-flex" style="gap: 0.5rem;">
            <a href="{{ route('cashier.cart.index') }}" class="btn btn-primary btn-sm">View Cart</a>
            <a href="{{ route('cashier.cart.draft') }}" class="btn btn-warning btn-sm">View Draft</a>
        </div>
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

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
