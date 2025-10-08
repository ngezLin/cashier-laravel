{{-- resources/views/admin/products/list.blade.php --}}
@extends('templates.dashboard')
@include('templates.script')

@section('content')
<div class="container-fluid mt-4">
    {{-- Search Form --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form action="{{ route('admin.products.list') }}" method="GET" class="d-flex" style="gap: 0.5rem;">
            <input type="text" name="search" class="form-control form-control-sm" style="width: 200px;"
                placeholder="Search..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary btn-sm">Search</button>
        </form>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        {{-- Product List --}}
        <div class="col-lg-8">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm product-card">
                            @php
                                $imagePath = Str::startsWith($product->image, ['http://', 'https://'])
                                    ? $product->image
                                    : asset('storage/' . $product->image);
                            @endphp

                            <img src="{{ $imagePath }}" class="card-img-top rounded-top"
                                alt="{{ $product->product_name }}"
                                style="height: 130px; object-fit: cover;">

                            <div class="card-body p-2 d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="fw-semibold text-truncate mb-1">{{ $product->product_name }}</h6>
                                    <small class="text-muted d-block mb-1">Stock: {{ $product->stock }}</small>
                                    <span class="fw-bold text-success d-block mb-2">
                                        Rp{{ number_format($product->sell_price, 0, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Add to Cart --}}
                                <form action="{{ route('admin.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="quantity" value="1" min="1"
                                            max="{{ $product->stock }}" class="form-control" required>
                                        <button type="submit" class="btn btn-success px-3 add-btn">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>

        {{-- Mini Cart --}}
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 80px;">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">🛒 Mini Cart</h5>
                    @if(!$cartItems->isEmpty())
                        <form action="{{ route('admin.cart.clear') }}" method="POST" onsubmit="return confirm('Clear cart?')">
                            @csrf
                            <button class="btn btn-sm btn-outline-light">Clear</button>
                        </form>
                    @endif
                </div>
                <div class="card-body">
                    @if($cartItems->isEmpty())
                        <p class="text-muted text-center">Your cart is empty.</p>
                    @else
                        <ul class="list-group mb-3">
                            @foreach($cartItems as $item)
                                @php
                                    $cartImage = Str::startsWith($item->product->image, ['http://', 'https://'])
                                        ? $item->product->image
                                        : asset('storage/' . $item->product->image);
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $cartImage }}" alt="{{ $item->product->product_name }}"
                                            style="width:45px; height:45px; object-fit:cover; border-radius:4px;">
                                        <div>
                                            <strong>{{ $item->product->product_name }}</strong><br>
                                            <small>Qty: {{ $item->quantity }}</small>
                                        </div>
                                    </div>
                                    <span>Rp{{ number_format($item->product->sell_price * $item->quantity, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="d-flex justify-content-between fw-bold border-top pt-2 mb-3">
                            <span>Total:</span>
                            <span>Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.cart') }}" class="btn btn-success w-100">
                                <i class="fas fa-shopping-cart"></i> View Cart
                            </a>
                            <a href="{{ route('admin.drafts') }}" class="btn btn-warning w-100">
                                <i class="fas fa-file-alt"></i> View Drafts
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
    .product-card {
        transition: all 0.2s ease-in-out;
        border-radius: 10px;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .add-btn:hover {
        background-color: #146c43 !important;
        border-color: #146c43 !important;
    }
</style>
@endsection
