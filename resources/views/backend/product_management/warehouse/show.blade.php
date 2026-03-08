@extends('adminlte::page')

@section('title', 'Warehouse Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Warehouse Details</h3>
        <div>
            <a href="{{ route('warehouses.index') }}" class="btn btn-sm btn-secondary">
                Back
            </a>
            <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
@stop


@section('content')
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Warehouse Name</th>
                    <td>{{ $warehouse->name }}</td>
                </tr>
                <tr>
                    <th>Warehouse Code</th>
                    <td>{{ $warehouse->code }}</td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td>{{ $warehouse->location ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Manager</th>
                    <td>{{ $warehouse->manager ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($warehouse->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Total Storages</th>
                    <td>{{ $warehouse->storages->count() }}</td>
                </tr>
                <tr>
                    <th>Created By</th>
                    <td>{{ $warehouse->creator->name ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
@stop
