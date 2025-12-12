@extends('adminlte::page')

@section('title', 'Division List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Division List</h1>
        <a href="{{ route('divisions.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2">
            <i class="fas fa-plus"></i> Add New
        </a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Branch Name</th>
                            <th>Division Code</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Contact Person</th>
                            <th>Contact Phone</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($divisions as $division)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $division->branch->name ?? '' }}</td>
                                <td>{{ $division->div_code }}</td>
                                <td>{{ $division->name }}</td>
                                <td>{{ $division->phone }}</td>
                                <td>{{ $division->email ?? 'N/A' }}</td>
                                <td>{{ $division->address }}</td>
                                <td>{{ $division->contact_person }}</td>
                                <td>{{ $division->contact_phone }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('divisions.show', $division->id) }}" class="btn btn-info btn-sm">
                                            View
                                        </a>
                                        <a href="{{ route('divisions.edit', $division->id) }}"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('divisions.destroy', $division->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="triggerDeleteModal('{{ route('divisions.destroy', $division->id) }}')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No division found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $divisions->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@stop
