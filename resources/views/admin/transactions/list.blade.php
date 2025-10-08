{{-- resources/views/admin/transactions/list.blade.php --}}
@extends('templates.dashboard')
@include('templates.script')

@section('content')
<div class="container-fluid mt-4">
    {{-- Search Form --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <input type="text" id="search" class="form-control form-control-sm"
            style="width: 200px;" placeholder="Search products...">
    </div>

    {{-- Alerts --}}
    <div id="alert-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <div class="row">
        {{-- Product List --}}
        <div class="col-lg-8">
            <div id="product-list">
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
                                    <form class="add-to-cart-form" data-product-id="{{ $product->id }}">
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
        </div>

        {{-- Mini Cart --}}
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 80px;">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">🛒 Mini Cart (<span id="cart-count">{{ $cartItems->count() }}</span>)</h5>
                    @if(!$cartItems->isEmpty())
                        <form action="{{ route('admin.cart.clear') }}" method="POST" onsubmit="return confirm('Clear cart?')">
                            @csrf
                            <button class="btn btn-sm btn-outline-light">Clear</button>
                        </form>
                    @endif
                </div>
                <div class="card-body" id="mini-cart-body">
                    @include('admin.transactions.partials.cart-items', ['cartItems' => $cartItems, 'cartTotal' => $cartTotal])
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
    .add-btn:disabled {
        cursor: not-allowed;
        opacity: 0.6;
    }
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.2em;
    }
</style>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Live Search Script
    const searchInput = document.getElementById('search');
    const productList = document.getElementById('product-list');
    let timer;

    searchInput.addEventListener('keyup', function() {
        clearTimeout(timer);
        const query = this.value.trim();

        timer = setTimeout(() => {
            fetch(`{{ route('admin.products.list') }}?search=${encodeURIComponent(query)}`)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newProducts = doc.querySelector('#product-list').innerHTML;
                    productList.innerHTML = newProducts;
                    attachAddToCartHandlers(); // Re-attach event listeners
                })
                .catch(err => console.error('Error:', err));
        }, 300);
    });

    // Add to Cart AJAX Handler
    function attachAddToCartHandlers() {
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const btn = this.querySelector('.add-btn');
                const originalContent = btn.innerHTML;
                const formData = new FormData(this);

                // Disable button and show loading
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

                fetch('{{ route('admin.cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update mini cart
                        document.getElementById('mini-cart-body').innerHTML = data.cartHtml;
                        document.getElementById('cart-count').textContent = data.cartCount;

                        // Show success message
                        showAlert('success', data.message);

                        // Reset quantity input
                        form.querySelector('input[name="quantity"]').value = 1;
                    } else {
                        showAlert('danger', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('danger', 'An error occurred. Please try again.');
                })
                .finally(() => {
                    // Re-enable button
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                });
            });
        });
    }

    // Show alert function
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alert-container');
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        alertContainer.appendChild(alert);

        // Auto-dismiss after 3 seconds
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }

    // Initial attachment
    attachAddToCartHandlers();
});
</script>
@endsection
