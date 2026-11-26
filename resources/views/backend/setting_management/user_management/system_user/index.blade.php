@extends('adminlte::page')

@section('title', 'System Users')

@section('adminlte_css')
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_base.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_header.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_table.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_profile.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_actions.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_modal.css') }}">
@stop

@section('content_header')
    <div class="system-users-header">
        <div class="system-users-heading">
            <span class="system-users-eyebrow">USER MANAGEMENT</span>
            <h1>System Users</h1>
            <p>Manage system accounts, roles and access credentials.</p>
        </div>

        <a href="{{ route('system_users.create') }}" class="btn system-users-add-btn">
            <i class="fas fa-plus"></i>
            <span>Add User</span>
        </a>
    </div>
@stop

@section('content')

    <div class="container-fluid system-users-page">

        <div class="system-users-card">

            <div class="system-users-card-header">
                <div>
                    <h5>
                        <i class="fas fa-users"></i>
                        User Directory
                    </h5>
                    <p>Overview of all registered system users.</p>
                </div>
                <span class="system-users-count">
                    {{ $users->count() }} Users
                </span>
            </div>

            <div class="table-responsive">
                <table class="table system-users-table mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Profile</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone 1</th>
                            <th>Phone 2</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)

                            <tr>
                                <td class="user-serial">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <div class="user-profile-cell">
                                        <img src="{{ asset($user->profile_picture ?: 'uploads/images/default.jpg') }}"
                                            alt="{{ $user->name }}" class="user-profile-image"
                                            onerror="this.onerror=null;this.src='{{ asset('uploads/images/default.jpg') }}';">
                                    </div>
                                </td>

                                <td>
                                    <div class="user-role-list">
                                        @forelse ($user->roles as $role)
                                            <span class="user-role-badge">
                                                {{ $role->name }}
                                            </span>
                                        @empty
                                            <span class="user-empty-value">No Role</span>
                                        @endforelse
                                    </div>
                                </td>

                                <td>
                                    <span class="user-name">
                                        {{ $user->name }}
                                    </span>
                                </td>

                                <td>
                                    <span class="user-email">
                                        {{ $user->email }}
                                    </span>
                                </td>

                                <td>{{ $user->phone ?? 'Not Provided' }}</td>

                                <td>{{ $user->phone_2 ?? 'Not Provided' }}</td>

                                <td>
                                    <span class="user-username">
                                        {{ $user->username ?? 'Not Provided' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="user-password-value">
                                        {{ $user->decrypted_password ?? 'Not Provided' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="user-action-group">

                                        <a href="{{ route('system_users.show', $user->id) }}"
                                            class="user-action-btn user-view-btn" title="View User">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('system_users.edit', $user->id) }}"
                                            class="user-action-btn user-edit-btn" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if (auth()->user()->hasRole('admin'))
                                            <button type="button"
                                                class="user-action-btn user-password-btn change-password-btn"
                                                data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                                data-user-email="{{ $user->email }}"
                                                data-user-username="{{ $user->username ?? 'Not Provided' }}"
                                                data-user-picture="{{ asset($user->profile_picture ?: 'uploads/images/default.jpg') }}"
                                                title="Change Password">

                                                <i class="fas fa-key"></i>
                                            </button>
                                        @endif
                                        @if (auth()->user()->hasRole('admin'))
                                            <form action="{{ route('system_users.destroy', $user->id) }}" method="POST"
                                                class="user-delete-form"
                                                onsubmit="return confirm('Are you sure you want to delete {{ addslashes($user->name) }}? This action cannot be undone.');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="user-action-btn user-delete-btn"
                                                    title="Delete User">

                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="10">
                                    <div class="system-users-empty">
                                        <i class="fas fa-users-slash"></i>
                                        <h5>No Users Found</h5>
                                        <p>There are currently no system users available.</p>
                                    </div>
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>

    {{-- CHANGE PASSWORD MODAL --}}
    <div class="modal fade system-password-modal" id="changePasswordModal" tabindex="-1" role="dialog"
        aria-labelledby="changePasswordModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

                <div class="password-modal-header">

                    <div class="password-modal-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>

                    <div>
                        <h5 id="changePasswordModalLabel">Update Password</h5>
                        <p>Securely update this user's login credentials.</p>
                    </div>

                    <button type="button" class="close password-modal-close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>

                </div>

                <form method="POST" id="changePasswordForm">

                    @csrf

                    <div class="modal-body">

                        {{-- USER PROFILE --}}
                        <div class="password-user-profile">

                            <img src="{{ asset('uploads/images/default.jpg') }}" id="modalUserPicture"
                                class="password-user-avatar" alt="User Profile">

                            <div class="password-user-info">

                                <h5 id="modalUserName">User Name</h5>

                                <span class="password-user-role">
                                    <i class="fas fa-user-circle"></i>
                                    System User
                                </span>

                                <div class="password-user-meta">
                                    <span>
                                        <i class="fas fa-at"></i>
                                        <span id="modalUserUsername">Username</span>
                                    </span>

                                    <span>
                                        <i class="fas fa-envelope"></i>
                                        <span id="modalUserEmail">Email</span>
                                    </span>
                                </div>

                            </div>

                        </div>

                        <div class="password-modal-divider"></div>

                        <div class="password-section-heading">
                            <i class="fas fa-lock"></i>
                            <span>New Login Credentials</span>
                        </div>

                        {{-- NEW PASSWORD --}}
                        <div class="form-group password-form-group">

                            <label for="password">New Password</label>

                            <div class="input-group password-input-group">

                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter new password" autocomplete="new-password" >

                                <div class="input-group-append">
                                    <button type="button" class="input-group-text toggle-password"
                                        data-target="password" aria-label="Show password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                            </div>

                        </div>

                        {{-- CONFIRM PASSWORD --}}
                        <div class="form-group password-form-group mb-0">

                            <label for="password_confirmation">Confirm Password</label>

                            <div class="input-group password-input-group">

                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="Confirm new password" autocomplete="new-password"
                                    >

                                <div class="input-group-append">
                                    <button type="button" class="input-group-text toggle-password"
                                        data-target="password_confirmation" aria-label="Show password">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="password-modal-footer">

                        <button type="button" class="btn password-cancel-btn" data-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn password-update-btn">
                            <i class="fas fa-key"></i>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/backend/setting_management/system_users/index_page/change_password.js') }}"></script>
@stop
