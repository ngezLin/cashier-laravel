@include('templates.script')
@extends('templates.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Your Cart</h2>

    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price (each)</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cartItems as $item)
                    @php
                        $subtotal = $item->product->sell_price * $item->quantity;
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $item->product->product_name }}</td>
                        <td>Rp{{ number_format($item->product->sell_price, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <form action="{{ route('cashier.cart.update', $item->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('PATCH')
                                <div class="d-flex justify-content-center align-items-center" style="gap: 5px;">
                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                        min="1" max="{{ $item->product->stock }}"
                                        class="form-control text-center"
                                        style="width:60px;height:32px;font-weight:bold;">
                                </div>
                            </form>
                        </td>


                        <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cashier.cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3" class="text-right">Total</th>
                    <th colspan="2">Rp{{ number_format($total, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>

        <!-- Checkout Form -->
        <form action="{{ route('cashier.cart.checkout') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="paymentMethod">Payment Method</label>
                <select name="payment_method" id="paymentMethod" class="form-control">
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="e_wallet">Qris</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="customer_amount">Amount Given</label>
                <input type="number" name="customer_amount" id="customer_amount" class="form-control" required min="{{ $total }}">
            </div>

            <div class="form-group mb-3">
                <label for="note">Note (optional)</label>
                <textarea name="note" id="note" class="form-control" rows="2"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Checkout</button>
        </form>

        <!-- Save Draft Form -->
        <form action="{{ route('cashier.cart.saveDraft') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-warning">Save as Draft</button>
        </form>

    @endif
</div>
@endsection
