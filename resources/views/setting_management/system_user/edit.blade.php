@extends('adminlte::page')

@section('title', 'Edit System User')

@section('content_header')
    <h1 class="m-0 text-dark">Edit System User</h1>
@endsection

@section('content')
    <div class="container-fluid">
        <form action="{{ route('system_users.update', $system_user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card card-primary">
                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="role">Role *</label>
                            <select name="role" id="role" class="form-control" required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ $system_user->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name">Full Name *</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $system_user->name) }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="username">Username *</label>
                            <input type="text" name="username" class="form-control"
                                value="{{ old('username', $system_user->username) }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email">Email *</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $system_user->email) }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone">Phone *</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $system_user->phone) }}" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="current_password">Current Password *</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password">New Password (Leave blank to keep current)</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success">Update User</button>
                </div>
            </div>
        </form>
    </div>
@endsection
