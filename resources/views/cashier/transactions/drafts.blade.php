@include('templates.script')
@extends('templates.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Saved Drafts</h2>

    @if($drafts->isEmpty())
        <p>No drafts found.</p>
    @else
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Items</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drafts as $draft)
                    <tr>
                        <td>#{{ $draft->id }}</td>
                        <td>Rp{{ number_format($draft->total, 0, ',', '.') }}</td>
                        <td>
                            <ul>
                                @foreach($draft->items as $item)
                                    <li>{{ $item->product->product_name }} (x{{ $item->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <form action="{{ route('cashier.cart.loadDraft', $draft->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Load Draft</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
