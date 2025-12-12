@extends('adminlte::page')

@section('title', 'System Users')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">System Users</h1>
        <a href="{{ route('system_users.create') }}"
            class="btn btn-success btn-sm d-flex align-items-center gap-2 shadow-sm rounded-pill px-3 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus"
                viewBox="0 0 16 16">
                <path d="M6 8c1.657 0 3-1.343 3-3S7.657 2 6 2 3 3.343 3 5s1.343 3 3 3zm0 1c-2.21
                                            0-4 1.79-4 4v1h8v-1c0-2.21-1.79-4-4-4z" />
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 0-.5.5V7h-1.5a.5.5 0 0 0
                                            0 1H13v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0
                                            0 0-1H14V5.5a.5.5 0 0 0-.5-.5z" />
            </svg>
            <span>Add New</span>
        </a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap text-center" id="dataTables">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? 'Not Provided' }}</td>
                                <td>{{ $user->username ?? 'Not Provided' }}</td>
                                <td>
                                    <a href="{{ route('system_users.edit', $user->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('system_users.destroy', $user->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm"
                                            onclick="triggerDeleteModal('{{ route('system_users.destroy', $user->id) }}')">
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
