
@extends('adminlte::page')

@section('title', 'Banned Users')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/ban_user/index_page/ban_users_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/ban_user/index_page/ban_users_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/ban_user/index_page/ban_users_table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/ban_user/index_page/ban_users_status.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/ban_user/index_page/ban_users_actions.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/ban_user/index_page/ban_users_resp.css') }}">
@stop

@section('content_header')
    <div class="ban-page-header">
        <div class="ban-page-heading">
            <span class="ban-page-eyebrow">
                <i class="fas fa-user-shield"></i>
                USER SECURITY MANAGEMENT
            </span>
            <h1>Banned Users</h1>
            <p>Review restricted accounts and manage user access.</p>
        </div>

        <a href="{{ route('ban_users.create') }}" class="ban-add-btn">
            <i class="fas fa-user-plus"></i>
            <span>Add User</span>
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid ban-index-container">

        <div class="ban-summary-card">
            <div class="ban-summary-icon">
                <i class="fas fa-user-lock"></i>
            </div>
            <div>
                <span>Total Records</span>
                <strong>{{ $bannedUsers->count() }}</strong>
            </div>
            <div class="ban-summary-description">
                <i class="fas fa-shield-alt"></i>
                Account restriction records
            </div>
        </div>

        <div class="ban-table-card">
            <div class="ban-table-card-header">
                <div>
                    <h3>
                        <i class="fas fa-list-ul"></i>
                        User Restriction Records
                    </h3>
                    <p>View ban details, status, and available actions.</p>
                </div>

                <span class="ban-record-count">
                    {{ $bannedUsers->count() }} Records
                </span>
            </div>

            <div class="ban-table-wrapper">
                <table class="table ban-users-table" id="dataTables">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Information</th>
                            <th>Email Address</th>
                            <th>Username</th>
                            <th>Banned At</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bannedUsers as $ban)
                            <tr>
                                <td>
                                    <span class="ban-row-number">{{ $loop->iteration }}</span>
                                </td>

                                <td>
                                    <div class="ban-user-cell">
                                        <div class="ban-user-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="ban-user-details">
                                            <strong>{{ $ban->user->name ?? 'N/A' }}</strong>
                                            <small>User ID: {{ $ban->user_id }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="ban-email">
                                        {{ $ban->user->email ?? 'N/A' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ban-username">
                                        {{ $ban->user->username ?? 'N/A' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="ban-date-cell">
                                        <i class="far fa-calendar-alt"></i>
                                        <span>
                                            {{ $ban->banned_at ? \Carbon\Carbon::parse($ban->banned_at)->format('d M Y, h:i A') : 'Not Available' }}
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <span class="ban-reason-text"
                                        title="{{ $ban->ban_reason ?? 'Not Provided' }}">
                                        {{ $ban->ban_reason ?: 'Not Provided' }}
                                    </span>
                                </td>

                                <td>
                                    @if ($ban->is_banned)
                                        <span class="ban-status-badge banned">
                                            <i class="fas fa-ban"></i>
                                            Banned
                                        </span>
                                    @else
                                        <span class="ban-status-badge active">
                                            <i class="fas fa-check-circle"></i>
                                            Active
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if ($ban->is_banned)
                                        <form action="{{ route('ban_users.destroy', $ban->id) }}"
                                            method="POST"
                                            class="ban-unban-form"
                                            onsubmit="return confirm('Are you sure you want to unban this user?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="ban-unban-btn">
                                                <i class="fas fa-unlock-alt"></i>
                                                Unban
                                            </button>
                                        </form>
                                    @else
                                        <span class="ban-no-action">No Action</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="ban-empty-state">
                                        <div class="ban-empty-icon">
                                            <i class="fas fa-user-shield"></i>
                                        </div>
                                        <h4>No User Records Found</h4>
                                        <p>There are currently no banned user records to display.</p>
                                        <a href="{{ route('ban_users.create') }}" class="ban-empty-btn">
                                            <i class="fas fa-plus"></i>
                                            Add User
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
