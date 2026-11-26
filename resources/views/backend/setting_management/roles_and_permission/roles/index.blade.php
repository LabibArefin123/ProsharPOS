@extends('adminlte::page')

@section('title', 'Role List')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/index_page/role_index_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/index_page/role_index_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/index_page/role_index_table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/roles/index_page/role_index_resp.css') }}">
@stop

@section('content_header')
    <div class="role-index-heading">
        <div class="role-index-heading-content">
            <div class="role-index-heading-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <span class="role-index-eyebrow">ACCESS CONTROL</span>
                <h1>Role Management</h1>
                <p>Manage system roles and their assigned permissions.</p>
            </div>
        </div>

        <a href="{{ route('roles.create') }}" class="role-index-add-btn">
            <i class="fas fa-plus"></i>
            <span>Create New Role</span>
        </a>
    </div>
@stop

@section('content')
    <div class="role-index-page">

        <div class="role-index-overview">
            <div class="role-index-overview-card">
                <div class="role-index-overview-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div>
                    <span>Total Roles</span>
                    <h3>{{ $roles->count() }}</h3>
                </div>
            </div>

            <div class="role-index-overview-card">
                <div class="role-index-overview-icon role-index-permission-icon">
                    <i class="fas fa-key"></i>
                </div>
                <div>
                    <span>Total Assigned Permissions</span>
                    <h3>{{ $roles->sum(function ($role) {return $role->permissions->count();}) }}</h3>
                </div>
            </div>
        </div>

        <div class="role-index-card">

            <div class="role-index-card-header">
                <div>
                    <h4>
                        <i class="fas fa-list-ul"></i>
                        System Roles
                    </h4>
                    <p>View, update, or remove existing roles.</p>
                </div>

                <span class="role-index-record-count">
                    {{ $roles->count() }} {{ $roles->count() === 1 ? 'Role' : 'Roles' }}
                </span>
            </div>

            <div class="role-index-table-wrapper">
                <table id="dataTables" class="table role-index-table">
                    <thead>
                        <tr>
                            <th class="role-index-sl-column">SL</th>
                            <th>Role Name</th>
                            <th>Assigned Permissions</th>
                            <th class="role-index-action-column">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($roles as $role)
                            @php
                                $permissionCount = $role->permissions->count();
                            @endphp

                            <tr>
                                <td class="role-index-sl">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <div class="role-index-name-cell">
                                        <span class="role-index-name-icon">
                                            <i class="fas fa-user-tag"></i>
                                        </span>
                                        <div>
                                            <span class="role-index-role-name">
                                                {{ $role->name }}
                                            </span>
                                            <small>System access role</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="role-index-permission-badge">
                                        <i class="fas fa-key"></i>
                                        {{ $permissionCount }}
                                        {{ $permissionCount === 1 ? 'Permission' : 'Permissions' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="role-index-actions">
                                        <a href="{{ route('roles.show', $role->id) }}"
                                            class="role-index-action-btn role-index-view-btn" title="View Role">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('roles.edit', $role->id) }}"
                                            class="role-index-action-btn role-index-edit-btn" title="Edit Role">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                            class="role-index-delete-form"
                                            onsubmit="return confirm('Are you sure you want to delete the {{ addslashes($role->name) }} role?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="role-index-action-btn role-index-delete-btn"
                                                title="Delete Role">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="role-index-empty-state">
                                        <div class="role-index-empty-icon">
                                            <i class="fas fa-user-shield"></i>
                                        </div>
                                        <h5>No Roles Found</h5>
                                        <p>Create your first role to start managing system access.</p>
                                        <a href="{{ route('roles.create') }}" class="role-index-empty-btn">
                                            <i class="fas fa-plus"></i>
                                            Create Role
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@stop
