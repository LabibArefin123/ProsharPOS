@extends('adminlte::page')

@section('title', 'Supplier List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Supplier List</h1>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New 
        </a>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('suppliers.create') }}" class="btn btn-success">Add Supplier</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>License No</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $index => $supplier)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->company_name }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td>{{ $supplier->phone_number }}</td>
                        <td>{{ $supplier->license_number }}</td>
                        <td>{{ $supplier->location }}</td>
                        <td>
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
