@extends('adminlte::page')

@section('title', 'Customer List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Customer List</h1>
        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $index => $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone_number }}</td>
                                <td>{{ $customer->location }}</td>
                                <td>
                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <a href="{{ route('customers.show', $customer->id) }}"
                                        class="btn btn-secondary btn-sm">View</a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="triggerDeleteModal('{{ route('customers.destroy', $customer->id) }}')">
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
    </div>
@stop
