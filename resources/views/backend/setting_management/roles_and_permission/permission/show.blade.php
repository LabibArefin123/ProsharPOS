
@extends('adminlte::page')

@section('title', 'Permission Details')

@section('content_header')
    <div class="permission-show-page-header">
        <div>
            <h1>Permission Details</h1>
            <p>View permission information and configuration.</p>
        </div>

        <a href="{{ route('permissions.index') }}" class="permission-show-back">
            <i class="fas fa-arrow-left"></i>
            Back to Permissions
        </a>
    </div>
@stop

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/permission/show_page/permission_show.css') }}">
@stop

@section('content')
    <div class="container-fluid permission-show-container">

        <div class="permission-show-card">

            {{-- Card Header --}}
            <div class="permission-show-card-header">

                <div class="permission-show-heading">
                    <div class="permission-show-icon">
                        <i class="fas fa-key"></i>
                    </div>

                    <div>
                        <h5>Permission Information</h5>
                        <p>Detailed information about this permission.</p>
                    </div>
                </div>

                <span class="permission-show-status">
                    <i class="fas fa-check-circle"></i>
                    Registered
                </span>

            </div>

            {{-- Card Body --}}
            <div class="permission-show-card-body">

                <div class="permission-show-section-title">
                    <i class="fas fa-info-circle"></i>
                    General Information
                </div>

                <div class="permission-show-grid">

                    <div class="permission-show-item">
                        <span class="permission-show-label">
                            Permission ID
                        </span>

                        <div class="permission-show-value">
                            #{{ $permission->id }}
                        </div>
                    </div>

                    <div class="permission-show-item">
                        <span class="permission-show-label">
                            Permission Name
                        </span>

                        <div class="permission-show-value permission-show-name">
                            <i class="fas fa-shield-alt"></i>
                            {{ $permission->name }}
                        </div>
                    </div>

                    <div class="permission-show-item">
                        <span class="permission-show-label">
                            Guard Name
                        </span>

                        <div class="permission-show-value">
                            <span class="permission-show-guard">
                                {{ $permission->guard_name }}
                            </span>
                        </div>
                    </div>

                    <div class="permission-show-item">
                        <span class="permission-show-label">
                            Created At
                        </span>

                        <div class="permission-show-value">
                            <i class="far fa-calendar-alt"></i>
                            {{ $permission->created_at?->format('d M Y, h:i A') ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="permission-show-item">
                        <span class="permission-show-label">
                            Last Updated
                        </span>

                        <div class="permission-show-value">
                            <i class="far fa-clock"></i>
                            {{ $permission->updated_at?->format('d M Y, h:i A') ?? 'N/A' }}
                        </div>
                    </div>

                </div>

                {{-- Roles Section --}}
                <div class="permission-show-section-title permission-show-roles-title">
                    <i class="fas fa-user-tag"></i>
                    Assigned Roles
                </div>

                <div class="permission-show-roles">

                    @forelse ($permission->roles as $role)
                        <div class="permission-show-role">
                            <i class="fas fa-user-shield"></i>
                            <span>{{ $role->name }}</span>
                        </div>
                    @empty
                        <div class="permission-show-empty">
                            <i class="fas fa-info-circle"></i>
                            This permission is not assigned to any role.
                        </div>
                    @endforelse

                </div>

            </div>

            {{-- Card Footer --}}
            <div class="permission-show-card-footer">

                <a href="{{ route('permissions.index') }}" class="permission-show-btn permission-show-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

                <a href="{{ route('permissions.edit', $permission->id) }}"
                    class="permission-show-btn permission-show-btn-primary">
                    <i class="fas fa-edit"></i>
                    Edit Permission
                </a>

            </div>

        </div>

    </div>
@stop

