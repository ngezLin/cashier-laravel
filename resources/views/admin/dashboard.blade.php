@include('templates.script')
@extends('templates.dashboardAdmin')
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Low Stock Products (Stock &lt; 5)</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    @if($lowStockProducts->isEmpty())
                        <p class="p-3">All products have sufficient stock.</p>
                    @else
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Sell Price</th>
                                    <th>Buy Price</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStockProducts as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->sell_price }}</td>
                                        <td>{{ $product->buy_price }}</td>
                                        <td>
                                            <span class="badge {{ $product->stock == 0 ? 'badge-danger' : 'badge-warning' }}">
                                                {{ $product->stock }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
