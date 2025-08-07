@include('templates.script')
@extends('templates.dashboardAdmin')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Product</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.products.update', $product->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <!-- Product Name -->
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name', $product->product_name) }}" placeholder="Enter product name">
            </div>

            <!-- Sell Price -->
            <div class="form-group">
                <label for="sell_price">Sell Price</label>
                <input type="number" class="form-control" id="sell_price" name="sell_price" value="{{ old('sell_price', $product->sell_price) }}" placeholder="Enter sell price">
            </div>

            <!-- Buy Price -->
            <div class="form-group">
                <label for="buy_price">Buy Price</label>
                <input type="number" class="form-control" id="buy_price" name="buy_price" value="{{ old('buy_price', $product->buy_price) }}" placeholder="Enter buy price">
            </div>

            <!-- Stock -->
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="Enter stock quantity">
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" id="submit-button" class="btn btn-primary">Update Product</button>
        </div>
    </form>
</div>
@endsection
