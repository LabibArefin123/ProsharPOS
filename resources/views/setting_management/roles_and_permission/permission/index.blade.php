@extends('adminlte::page')

@section('title', 'Permissions List')

@section('content_header')
    <h1>Permissions List</h1>
@stop


@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input.</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <!-- Add Permission Form -->
            <form method="POST" action="{{ route('permissions.store') }}">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Add New Permission</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                placeholder="Enter permission name" required>
                        </div>
                        <div class="form-group">
                            <label for="guard_name">Guard Name <span class="text-danger">*</span></label>
                            <select name="guard_name" class="form-control" required>

                                <option value="web" {{ old('guard_name') == 'web' ? 'selected' : '' }}>web</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Permission</button>
                    </div>
                </div>
            </form>

            <!-- Permissions Table -->
            <table id="permissionsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Permission Name</th>
                        <th>Guard</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                            <td>
                                <a href="{{ route('permissions.edit', $permission->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" type="submit"
                                        class="btn btn-danger btn-sm">
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
