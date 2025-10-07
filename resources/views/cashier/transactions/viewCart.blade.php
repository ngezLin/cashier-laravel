@extends('templates.dashboard')
@include('templates.script')

@section('content')
@php $total = 0; @endphp

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

        <table class="table table-bordered mt-3" id="cartTable">
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
                @foreach($cartItems as $item)
                    @php
                        $subtotal = $item->product->sell_price * $item->quantity;
                        $total += $subtotal;
                    @endphp
                    <tr data-item-id="{{ $item->id }}" data-price="{{ $item->product->sell_price }}">
                        <td>{{ $item->product->product_name }}</td>
                        <td>Rp{{ number_format($item->product->sell_price,0,',','.') }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center align-items-center" style="gap:5px;">
                                <button type="button" class="btn btn-sm btn-secondary btn-decrease">-</button>
                                <input type="number" class="form-control text-center quantity-input" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" style="width:60px;">
                                <button type="button" class="btn btn-sm btn-secondary btn-increase">+</button>
                            </div>
                        </td>
                        <td class="subtotal">Rp{{ number_format($subtotal,0,',','.') }}</td>
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
                    <th colspan="2" id="totalAmount">Rp{{ number_format($total,0,',','.') }}</th>
                </tr>
            </tbody>
        </table>

        <!-- Checkout Form -->
        <form action="{{ route('cashier.cart.checkout') }}" method="POST" id="checkoutForm">
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
                <input type="text" name="customer_amount" id="customer_amount" class="form-control" required>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentMethod = document.getElementById('paymentMethod');
    const customerAmount = document.getElementById('customer_amount');
    let total = {{ $total }};

    function formatRupiah(amount){
        return 'Rp' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g,'.');
    }

    function updateAmountGiven(){
        if(paymentMethod.value === 'cash'){
            customerAmount.removeAttribute('readonly');
            customerAmount.value = '';
        } else {
            customerAmount.value = formatRupiah(total);
            customerAmount.setAttribute('readonly', true);
        }
    }

    updateAmountGiven();
    paymentMethod.addEventListener('change', updateAmountGiven);

    // live-format cash input
    customerAmount.addEventListener('input', function(){
        if(!customerAmount.hasAttribute('readonly')){
            let cursorPos = customerAmount.selectionStart;
            let numbers = customerAmount.value.replace(/[^0-9]/g,'');
            customerAmount.value = formatRupiah(numbers);
            customerAmount.selectionStart = customerAmount.selectionEnd = cursorPos;
        }
    });

    // submit -> hapus Rp/titik
    document.getElementById('checkoutForm').addEventListener('submit', function(){
        if(customerAmount.hasAttribute('readonly')){
            customerAmount.value = total;
        } else {
            customerAmount.value = customerAmount.value.replace(/[^0-9]/g,'');
        }
    });

    // ===== Quantity + / - buttons =====
    const cartTable = document.getElementById('cartTable');
    cartTable.addEventListener('click', function(e){
        if(e.target.classList.contains('btn-increase') || e.target.classList.contains('btn-decrease')){
            const row = e.target.closest('tr');
            const input = row.querySelector('.quantity-input');
            let value = parseInt(input.value);
            const max = parseInt(input.getAttribute('max'));
            const min = parseInt(input.getAttribute('min'));

            if(e.target.classList.contains('btn-increase') && value < max) value++;
            else if(e.target.classList.contains('btn-decrease') && value > min) value--;
            input.value = value;

            // update subtotal
            const price = parseInt(row.dataset.price);
            const newSubtotal = price * value;
            row.querySelector('.subtotal').textContent = formatRupiah(newSubtotal);

            // update total
            total = 0;
            cartTable.querySelectorAll('tbody tr[data-item-id]').forEach(r=>{
                const q = parseInt(r.querySelector('.quantity-input').value);
                const p = parseInt(r.dataset.price);
                total += p * q;
            });
            document.getElementById('totalAmount').textContent = formatRupiah(total);

            // update amount given if non-cash
            updateAmountGiven();
        }
    });
});
</script>
@endsection
