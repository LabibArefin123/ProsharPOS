@extends('adminlte::page')

@section('title', 'Product Stock Report')

@section('content_header')
    <h1 class="m-0 text-dark">Product Stock Report</h1>
@stop

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Product Stock Repor</h1>
        <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Product List
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Purchase Price</th>
                        <th>Sell Price</th>
                        <th>Profit</th>
                        <th>Stock Quantity</th>
                        <th>Alert Quantity</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->purchase_price, 2) }}</td>
                            <td>{{ number_format($product->sell_price, 2) }}</td>
                            <td>{{ number_format($product->sell_price - $product->purchase_price, 2) }}</td>
                            <td>{{ $product->storage->stock_quantity ?? 0 }}</td>

                            <td>{{ $product->storage->alert_quantity ?? 0 }}</td>
                            <td class="text-center">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="btn btn-xs btn-info mr-1">Edit</a>
                                <a href="{{ route('products.show', $product->id) }}"
                                    class="btn btn-xs btn-warning mr-1">Show</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No product stock available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
