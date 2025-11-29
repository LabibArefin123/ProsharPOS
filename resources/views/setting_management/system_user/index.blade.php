@extends('adminlte::page')

@section('title', 'System Users')


@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">System Users</h1>
        <a href="{{ route('system_users.create') }}" class="btn btn-success btn-sm">
            Add
        </a>
    </div>
@stop

@section('content')

    <div class="container-fluid"> <!-- Use container-fluid instead of container -->
        <div class="card"> <!-- Wrap the table in a card to align with AdminLTE's layout -->
            <div class="card-body p-0"> <!-- Remove extra padding -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0"> <!-- Add mb-0 to remove bottom margin -->
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone </th>
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
                                        <a href="{{ route('system_users.show', $user->id) }}"
                                            class="btn btn-info btn-sm me-2">View</a> <!-- Add me-2 -->
                                        <a href="{{ route('system_users.edit', $user->id) }}"
                                            class="btn btn-warning btn-sm me-2">Edit</a> <!-- Add me-2 -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
@section('js')
    @if (session('success') || session('error') || session('warning') || session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                @if (session('success'))
                    Toast.fire({
                        icon: 'success',
                        title: @json(session('success'))
                    });
                @elseif (session('error'))
                    Toast.fire({
                        icon: 'error',
                        title: @json(session('error'))
                    });
                @elseif (session('warning'))
                    Toast.fire({
                        icon: 'warning',
                        title: @json(session('warning'))
                    });
                @elseif (session('info'))
                    Toast.fire({
                        icon: 'info',
                        title: @json(session('info'))
                    });
                @endif
            });
        </script>
    @endif
@endsection
