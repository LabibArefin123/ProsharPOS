
@extends('adminlte::page')

@section('title', 'Edit Permission')

@section('content_header')
    <h1>Update Permission</h1>
@stop

@section('adminlte_css')
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/permission/edit_page/permission_edit.css') }}">
@stop

@section('content')
    <div class="container-fluid permission-edit-container">

        <form method="POST" action="{{ route('permissions.update', $permission->id) }}">
            @method('PUT')
            @csrf

            <div class="card permission-edit-card">

                <div class="card-header">
                    <div class="permission-edit-icon">
                        <i class="fas fa-key"></i>
                    </div>

                    <div>
                        <h5 class="permission-edit-heading">Permission Information</h5>
                        <p class="permission-edit-subtitle">
                            Update the permission name and guard configuration.
                        </p>
                    </div>
                </div>

                <div class="card-body">

                    <div class="permission-edit-form-group">
                        <label for="name">
                            Permission Name <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter permission name"
                            value="{{ old('name', $permission->name) }}"
                            required
                        >

                        @error('name')
                            <span class="permission-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="permission-edit-form-group">
                        <label for="guard_name">
                            Guard <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            id="guard_name"
                            name="guard_name"
                            class="form-control @error('guard_name') is-invalid @enderror"
                            placeholder="Enter guard name"
                            value="{{ old('guard_name', $permission->guard_name) }}"
                            required
                        >

                        @error('guard_name')
                            <span class="permission-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn permission-edit-submit">
                        <i class="fas fa-save"></i>
                        Update Permission
                    </button>
                </div>

            </div>
        </form>

    </div>
@stop
