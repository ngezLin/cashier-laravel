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
        <span id="cart-total-display">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
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
