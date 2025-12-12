@extends('adminlte::page')

@section('title', 'Department List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Department List</h1>
        <a href="{{ route('departments.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2">
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
                            <th>Division Name</th>
                            <th>Department Code</th>
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
                        @forelse ($departments as $department)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $department->branch->name ?? '' }}</td>
                                <td>{{ $department->division->name ?? '' }}</td>
                                <td>{{ $department->dept_code }}</td>
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->phone }}</td>
                                <td>{{ $department->email ?? 'N/A' }}</td>
                                <td>{{ $department->address }}</td>
                                <td>{{ $department->contact_person }}</td>
                                <td>{{ $department->contact_phone }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('departments.show', $department->id) }}"
                                            class="btn btn-info btn-sm">
                                            View
                                        </a>
                                        <a href="{{ route('departments.edit', $department->id) }}"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="triggerDeleteModal('{{ route('departments.destroy', $department->id) }}')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">No department found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $departments->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@stop
