@extends('templates.dashboard')
@include('templates.script')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Product</h3>
    </div>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <!-- Product Name -->
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="product_name" class="form-control" placeholder="Enter product name" required>
            </div>

            <!-- SKU -->
            <div class="form-group">
                <label>SKU (optional)</label>
                <input type="text" name="sku" class="form-control" placeholder="Auto-generated if empty">
            </div>

            <!-- Sell Price -->
            <div class="form-group">
                <label>Sell Price</label>
                <input type="number" name="sell_price" class="form-control" required>
            </div>

            <!-- Buy Price -->
            <div class="form-group">
                <label>Buy Price</label>
                <input type="number" name="buy_price" class="form-control" required>
            </div>

            <!-- Stock -->
            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" min="0" required>
            </div>

            <!-- Image (File or URL) -->
            <div class="form-group">
                <label>Image (jpg/png/webp)</label>
                <div class="mb-2">
                    <input type="file" name="image_file" class="form-control mb-2" id="image_file" accept="image/*">
                    <small class="text-muted d-block mb-2">or enter image URL below</small>
                    <input type="text" name="image_url" id="image_url" class="form-control" placeholder="https://example.com/image.jpg">
                </div>
                <div class="mt-3 text-center">
                    <img id="preview" src="#" alt="Image Preview" class="img-fluid rounded shadow-sm" style="max-height: 200px; display: none;">
                </div>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create Product</button>
        </div>
    </form>
</div>

{{-- Real-time Preview Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('image_file');
    const urlInput = document.getElementById('image_url');
    const preview = document.getElementById('preview');

    // File upload preview
    fileInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // URL preview
    urlInput.addEventListener('input', function () {
        const url = this.value.trim();
        if (url.startsWith('http')) {
            preview.src = url;
            preview.style.display = 'block';
        } else if (url === '') {
            preview.style.display = 'none';
        }
    });
});
</script>
@endsection
