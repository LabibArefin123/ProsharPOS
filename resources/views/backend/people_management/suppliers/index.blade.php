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

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="thead-dark">

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
                    @foreach ($suppliers as $index => $supplier)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->company_name }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>{{ $supplier->phone_number }}</td>
                            <td>{{ $supplier->license_number }}</td>
                            <td>{{ $supplier->location }}</td>
                            <td>
                                <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('suppliers.show', $supplier->id) }}"
                                    class="btn btn-secondary btn-sm">View</a>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="triggerDeleteModal('{{ route('suppliers.destroy', $supplier->id) }}')">
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
