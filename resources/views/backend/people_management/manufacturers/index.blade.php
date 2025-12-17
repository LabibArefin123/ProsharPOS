@extends('adminlte::page')

@section('title', 'Manufacturer List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Manufacturer List</h1>
        <a href="{{ route('manufacturers.create') }}" class="btn btn-primary btn-sm">
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
                        <th>Country</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($manufacturers as $index => $manu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $manu->name }}</td>
                            <td>{{ $manu->country }}</td>
                            <td>{{ $manu->email }}</td>
                            <td>{{ $manu->phone }}</td>
                            <td>{{ $manu->location }}</td>
                            <td>
                                <span class="badge {{ $manu->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $manu->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            </td>
                            <td>
                                <a href="{{ route('manufacturers.edit', $manu->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('manufacturers.show', $manu->id) }}"
                                    class="btn btn-secondary btn-sm">View</a>
                                <form action="{{ route('manufacturers.destroy', $manu->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="triggerDeleteModal('{{ route('manufacturers.destroy', $manu->id) }}')">
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
