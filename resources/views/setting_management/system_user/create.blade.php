@extends('adminlte::page')

@section('title', 'Add System User')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Create System User</h1>
        <a href="{{ route('system_users.index') }}"
            class="btn btn-warning btn-sm d-flex align-items-center gap-2 shadow rounded-pill px-3 py-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.354
                                     11.354a.5.5 0 0 0 0-.708L6.707 9H11.5a.5.5
                                     0 0 0 0-1H6.707l1.647-1.646a.5.5 0 0
                                     0-.708-.708l-2.5 2.5a.5.5 0 0
                                     0 0 .708l2.5 2.5a.5.5 0 0
                                     0 .708 0z" />
            </svg>
            <span class="fw-bold">Back to List</span>
        </a>
    </div>
@stop


@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('system_users.store') }}" method="POST" data-confirm="create">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="role">Assign Role<span class="text-danger">*</span></label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">Full Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="username">Username<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                            name="username" value="{{ old('username') }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email">Email Address<span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone">Phone<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="current_password"> Current Password<span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                            id="password" name="current_password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="password">Password<span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="password_confirmation">Confirm Password<span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
