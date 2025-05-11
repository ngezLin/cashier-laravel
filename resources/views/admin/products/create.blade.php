@include('templates.script')
@extends('templates.dashboardAdmin')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Product</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('admin.products.store') }}">
        @csrf
        <div class="card-body">
            <!-- Product Name -->
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter product name">
            </div>

            <!-- Sell Price -->
            <div class="form-group">
                <label for="sell_price">Sell Price</label>
                <input type="number" class="form-control" id="sell_price" name="sell_price" placeholder="Enter sell price">
            </div>

            <!-- Buy Price -->
            <div class="form-group">
                <label for="buy_price">Buy Price</label>
                <input type="number" class="form-control" id="buy_price" name="buy_price" placeholder="Enter buy price">
            </div>

            <!-- Stock -->
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" placeholder="Enter stock quantity">
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create Product</button>
        </div>
    </form>
</div>
@endsection
