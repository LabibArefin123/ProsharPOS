@extends('adminlte::page')

@section('title', 'Add System User')

@section('content_header')
    <h1 class="m-0 text-dark">Add New System User</h1>
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ route('system_users.store') }}" method="POST">
            @csrf

            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="role">Role *</label>
                            <select name="role" id="role" class="form-control" required>
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name">Full Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="username">Username *</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}"
                                required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email">Email *</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone">Phone *</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="current_password">Current Password *</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password">New Password *</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password_confirmation">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>
            </div>
        </form>
    </div>
@endsection
