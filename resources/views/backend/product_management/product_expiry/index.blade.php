@extends('adminlte::page')

@section('title', 'Product Expiry List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Product Expired List</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('products_expirys.create') }}" class="btn btn-danger btn-sm">
                <i class="fas fa-plus"></i> Create New
            </a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
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
                    @foreach ($expiries as $expire)
                        <tr>
                            <td>{{ $expire->id }}</td>
                            <td>{{ $expire->product_name }}</td>
                            <td>{{ $expire->batch_no }}</td>
                            <td>{{ $expire->expiry_date }}</td>
                            <td>{{ $expire->quantity }}</td>
                            <td>
                                <a href="{{ route('products_expirys.show', $expire->id) }}" class="btn btn-info btn-sm">
                                    View
                                </a>
                                <a href="{{ route('products_expirys.edit', $expire->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('products_expirys.destroy', $expire->id) }}" method="POST"
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
