@include('templates.script')
@extends('templates.dashboardCashier')

@section('content')
<div class="container mt-4">
    <h2>Your Cart</h2>

    @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
    @else
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
                        <td>{{ $item->quantity }}</td>
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

        <a href="#" class="btn btn-success">Checkout</a>
    @endif
</div>
@endsection
