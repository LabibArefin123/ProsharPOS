@extends('adminlte::page')

@section('title', 'Role List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Role List</h3>
        <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add
        </a>
    </div>
@stop
@section('content')
    <div class="card shadow-sm">
        <div class="card-body table-responsive ">
            <table class="table table-hover table-striped text-center" id="dataTables">
                <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Role Name</th>
                        <th>Permissions</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                {{ $role->permissions->count() }}
                                permission{{ $role->permissions->count() !== 1 ? 's' : '' }}
                            </td>
                            <td>
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="triggerDeleteModal('{{ route('roles.destroy', $role->id) }}')">
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
