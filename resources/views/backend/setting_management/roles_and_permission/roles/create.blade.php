@extends('adminlte::page')

@section('title', 'Create Role')

@section('adminlte_css')
<link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/role_form/role_form_base.css') }}">
<link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/role_form/role_form_header.css') }}">
<link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/role_form/role_form_fields.css') }}">
<link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/role_form/role_form_permissions.css') }}">
<link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/role_form/role_form_resp.css') }}">
@stop

@section('content_header')
<div class="role-page-heading">
    <div class="role-heading-content">
        <div class="role-heading-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <div>
            <h1>Create New Role</h1>
            <p>Create a role and assign access permissions to it.</p>
        </div>
    </div>

    <a href="{{ route('roles.index') }}" class="role-back-btn">
        <i class="fas fa-arrow-left"></i>
        Back to Roles
    </a>
</div>
@stop

@section('content')
<div class="role-form-page">

    @if ($errors->any())
        <div class="role-error-alert">
            <div class="role-error-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div>
                <strong>Please check the following errors</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('roles.store') }}" data-confirm="create">
        @csrf

        {{-- ROLE INFORMATION --}}
        <section class="role-form-card role-name-card">
            <div class="role-card-heading">
                <div class="role-card-heading-icon">
                    <i class="fas fa-id-badge"></i>
                </div>
                <div>
                    <h5>Role Information</h5>
                    <p>Give this role a clear and meaningful name.</p>
                </div>
            </div>

            <div class="role-card-body">
                <div class="role-form-group">
                    <label for="name">Role Name <span>*</span></label>
                    <input type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Example: Content Manager"
                        autocomplete="off"
                        required>

                    @error('name')
                        <small class="role-field-error">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </section>

        {{-- PERMISSIONS --}}
        <div class="role-permissions-heading">
            <div>
                <span class="role-section-kicker">ACCESS CONTROL</span>
                <h3><i class="fas fa-key"></i> Assign Permissions</h3>
                <p>Select which areas and actions this role can access.</p>
            </div>
            <div class="role-permission-total">
                <i class="fas fa-layer-group"></i>
                {{ $routes->flatten(1)->count() }} Permissions
            </div>
        </div>

        @forelse ($routes as $group => $groupRoutes)
            <section class="role-permission-group">

                <div class="role-group-header">
                    <div class="role-group-title">
                        <span class="role-group-icon">
                            <i class="fas fa-folder"></i>
                        </span>
                        <div>
                            <h5>{{ \Illuminate\Support\Str::headline($group) }}</h5>
                            <span>{{ $groupRoutes->count() }} available permissions</span>
                        </div>
                    </div>

                    <div class="role-group-actions">
                        <button type="button"
                            class="role-select-btn select-all-btn"
                            data-group="{{ $group }}">
                            <i class="fas fa-check-double"></i>
                            Select All
                        </button>

                        <button type="button"
                            class="role-unselect-btn unselect-all-btn"
                            data-group="{{ $group }}">
                            <i class="fas fa-times"></i>
                            Clear
                        </button>
                    </div>
                </div>

                <div class="role-permission-grid">
                    @foreach ($groupRoutes as $route)
                        <label class="role-permission-item">
                            <input type="checkbox"
                                name="permissions[]"
                                value="{{ $route->getName() }}"
                                class="role-permission-checkbox"
                                data-permission-group="{{ $group }}"
                                @checked(in_array($route->getName(), old('permissions', [])))>

                            <span class="role-custom-check">
                                <i class="fas fa-check"></i>
                            </span>

                            <span class="role-permission-name">
                                {{ $route->getName() }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </section>
        @empty
            <div class="role-empty-state">
                <i class="fas fa-folder-open"></i>
                <h5>No Permissions Found</h5>
                <p>There are no authenticated controller routes available for assignment.</p>
            </div>
        @endforelse

        {{-- SUBMIT --}}
        <div class="role-submit-area">
            <a href="{{ route('roles.index') }}" class="role-cancel-btn">
                Cancel
            </a>
            <button type="submit" class="role-submit-btn">
                <i class="fas fa-save"></i>
                Create Role
            </button>
        </div>
    </form>
</div>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.select-all-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const group = this.dataset.group;

            document.querySelectorAll('.role-permission-checkbox').forEach(function (checkbox) {
                if (checkbox.dataset.permissionGroup === group) {
                    checkbox.checked = true;
                }
            });
        });
    });

    document.querySelectorAll('.unselect-all-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const group = this.dataset.group;

            document.querySelectorAll('.role-permission-checkbox').forEach(function (checkbox) {
                if (checkbox.dataset.permissionGroup === group) {
                    checkbox.checked = false;
                }
            });
        });
    });
});
</script>
@stop