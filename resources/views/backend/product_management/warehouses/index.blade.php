@extends('adminlte::page')

@section('title', 'Warehouses')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Warehouse List</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('warehouses.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Create Warehouse
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-sm border-left-primary">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Location</th>
                        <th>Manager</th>
                        <th>Storages</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($warehouses as $warehouse)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $warehouse->name }}</td>
                            <td>{{ $warehouse->code }}</td>
                            <td>{{ $warehouse->location ?? '-' }}</td>
                            <td>{{ $warehouse->manager ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $warehouse->storages_count ?? $warehouse->storages->count() }}
                                </span>
                            </td>
                            <td>
                                @if ($warehouse->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{ route('warehouses.show', $warehouse->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Are you sure to delete this warehouse?');">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
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
