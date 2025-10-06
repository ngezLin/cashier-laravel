@extends('templates.dashboardCashier')
@include('templates.script')

@section('content')
<div class="container mt-4">
    <h1>Tambah Produk</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cashier.products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="product_name" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" name="product_name" value="{{ old('product_name') }}" required>
        </div>
        <div class="mb-3">
            <label for="sell_price" class="form-label">Harga Jual</label>
            <input type="number" class="form-control" name="sell_price" value="{{ old('sell_price') }}" required>
        </div>
        <div class="mb-3">
            <label for="buy_price" class="form-label">Harga Beli</label>
            <input type="number" class="form-control" name="buy_price" value="{{ old('buy_price') }}" required>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" name="stock" value="{{ old('stock') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('cashier.products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
