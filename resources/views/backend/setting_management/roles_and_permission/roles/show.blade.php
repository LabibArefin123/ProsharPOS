@extends('adminlte::page')

@section('title', 'Role Details')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/show_page/role_show_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/show_page/role_show_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/show_page/role_show_summary.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/show_page/role_show_permissions.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/show_page/role_show_resp.css') }}">
@stop

@section('content_header')
    <div class="role-show-heading">
        <div class="role-show-heading-content">
            <div class="role-show-heading-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <span class="role-show-eyebrow">ROLE MANAGEMENT</span>
                <h1>Role Details</h1>
                <p>Review role information and its assigned permissions.</p>
            </div>
        </div>

        <div class="role-show-heading-actions">
            <a href="{{ route('roles.index') }}" class="role-show-btn role-show-back-btn">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Roles</span>
            </a>

            <a href="{{ route('roles.edit', $role->id) }}" class="role-show-btn role-show-edit-btn">
                <i class="fas fa-edit"></i>
                <span>Edit Role</span>
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="role-show-page">

        {{-- Role Summary --}}
        <div class="role-show-summary-grid">

            <div class="role-show-summary-card role-show-main-card">
                <div class="role-show-summary-icon">
                    <i class="fas fa-user-tag"></i>
                </div>

                <div class="role-show-summary-content">
                    <span class="role-show-summary-label">ROLE NAME</span>
                    <h3>{{ $role->name }}</h3>
                    <span class="role-show-summary-caption">
                        <i class="fas fa-check-circle"></i>
                        Registered system role
                    </span>
                </div>
            </div>

            <div class="role-show-summary-card role-show-count-card">
                <div class="role-show-count-icon">
                    <i class="fas fa-key"></i>
                </div>

                <div class="role-show-summary-content">
                    <span class="role-show-summary-label">ASSIGNED PERMISSIONS</span>
                    <h3>{{ $role->permissions->count() }}</h3>
                    <span class="role-show-summary-caption">
                        {{ $role->permissions->count() === 1 ? 'Permission assigned' : 'Permissions assigned' }}
                    </span>
                </div>
            </div>

        </div>

        {{-- Permission Section --}}
        <div class="role-show-permissions-card">

            <div class="role-show-section-header">
                <div class="role-show-section-heading">
                    <div class="role-show-section-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h4>Assigned Permissions</h4>
                        <p>All permissions currently connected to this role.</p>
                    </div>
                </div>

                <span class="role-show-total-badge">
                    <i class="fas fa-list-check"></i>
                    {{ $role->permissions->count() }} Total
                </span>
            </div>

            <div class="role-show-permissions-body">
                @forelse ($groupedPermissions as $group => $permissions)
                    <div class="role-show-permission-group">

                        <div class="role-show-group-heading">
                            <div class="role-show-group-title">
                                <span class="role-show-group-icon">
                                    <i class="fas fa-folder-open"></i>
                                </span>
                                <h5>{{ \Illuminate\Support\Str::headline($group) }}</h5>
                            </div>

                            <span class="role-show-group-count">
                                {{ $permissions->count() }}
                                {{ $permissions->count() === 1 ? 'permission' : 'permissions' }}
                            </span>
                        </div>

                        <div class="role-show-permission-grid">
                            @foreach ($permissions as $permission)
                                <div class="role-show-permission-item">
                                    <span class="role-show-permission-check">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <span class="role-show-permission-name">
                                        {{ $permission->name }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @empty
                    <div class="role-show-empty-state">
                        <div class="role-show-empty-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>No Permissions Assigned</h5>
                        <p>This role does not have any permissions yet.</p>
                        <a href="{{ route('roles.edit', $role->id) }}" class="role-show-empty-btn">
                            <i class="fas fa-plus"></i>
                            Assign Permissions
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@stop