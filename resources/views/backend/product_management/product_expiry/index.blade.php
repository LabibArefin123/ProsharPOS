@extends('adminlte::page')

@section('title', 'Product Expiry List')

@section('content_header')
    <h1>Product Expiry List</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <a href="{{ route('product_expirys.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Product Expiry
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="bg-dark">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Batch No</th>
                        <th>Expiry Date</th>
                        <th>Quantity</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->batch_no }}</td>
                            <td>{{ $product->expiry_date }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>
                                <a href="{{ route('product_expirys.show', $product->id) }}" class="btn btn-info btn-sm">
                                    View
                                </a>
                                <a href="{{ route('product_expirys.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('product_expirys.destroy', $product->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this record?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

@stop
