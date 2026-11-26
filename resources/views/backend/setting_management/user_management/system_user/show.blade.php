@extends('adminlte::page')

@section('title', 'User Details')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/show_page/show_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/show_page/show_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/show_page/show_profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/show_page/show_info.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/show_page/show_resp.css') }}">
@stop

@section('content_header')
    <div class="user-show-page-header">
        <div class="user-show-heading">
            <span class="user-show-eyebrow">
                <i class="fas fa-user-shield"></i>
                USER MANAGEMENT
            </span>
            <h1>User Details</h1>
            <p>View account information and assigned permissions.</p>
        </div>

        <a href="{{ route('system_users.index') }}" class="user-show-back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Users</span>
        </a>
    </div>
@stop

@section('content')
    @php
        $roleName = $user->getRoleNames()->first();
        $profileImage = $user->profile_picture ?: 'uploads/images/default.jpg';
        $phoneOne = $user->phone_1 ?? ($user->phone ?? null);
    @endphp

    <div class="container-fluid user-show-container">
        <div class="user-show-layout">

            {{-- PROFILE SUMMARY --}}
            <div class="user-show-profile-card user-show-reveal">
                <div class="user-show-profile-cover">
                    <div class="user-show-cover-decoration"></div>
                    <span class="user-show-account-label">
                        <i class="fas fa-check-circle"></i>
                        Account Information
                    </span>
                </div>

                <div class="user-show-profile-content">
                    <div class="user-show-avatar-wrapper">
                        <img src="{{ asset($profileImage) }}" alt="{{ $user->name }} profile picture"
                            class="user-show-avatar"
                            onerror="this.onerror=null;this.src='{{ asset('uploads/images/default.jpg') }}';">
                    </div>

                    <div class="user-show-profile-details">
                        <h2>{{ $user->name }}</h2>
                        <p class="user-show-username">
                            <i class="fas fa-at"></i>
                            {{ $user->username }}
                        </p>

                        <div class="user-show-role">
                            <i class="fas fa-user-tag"></i>
                            {{ $roleName ?? 'Not Assigned' }}
                        </div>
                    </div>

                    <div class="user-show-profile-footer">
                        <div>
                            <span class="user-show-footer-label">USER ID</span>
                            <strong>#{{ $user->id }}</strong>
                        </div>
                        <div>
                            <span class="user-show-footer-label">ACCOUNT CREATED</span>
                            <strong>{{ $user->created_at?->format('d M Y') ?? 'Not Available' }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INFORMATION CARD --}}
            <div class="user-show-information-card user-show-reveal">
                <div class="user-show-card-heading">
                    <div class="user-show-heading-icon">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <div>
                        <h3>Personal Information</h3>
                        <p>Basic information associated with this account.</p>
                    </div>
                </div>

                <div class="user-show-info-grid">
                    <div class="user-show-info-item">
                        <span class="user-show-info-label">
                            <i class="fas fa-user"></i>
                            Full Name
                        </span>
                        <strong>{{ $user->name ?: 'Not Provided' }}</strong>
                    </div>

                    <div class="user-show-info-item">
                        <span class="user-show-info-label">
                            <i class="fas fa-user-circle"></i>
                            Username
                        </span>
                        <strong>{{ $user->username ?: 'Not Provided' }}</strong>
                    </div>

                    <div class="user-show-info-item">
                        <span class="user-show-info-label">
                            <i class="fas fa-envelope"></i>
                            Email Address
                        </span>
                        <strong>{{ $user->email ?: 'Not Provided' }}</strong>
                    </div>

                    <div class="user-show-info-item">
                        <span class="user-show-info-label">
                            <i class="fas fa-phone"></i>
                            Phone Number 1
                        </span>
                        <strong>{{ $phoneOne ?: 'Not Provided' }}</strong>
                    </div>

                    <div class="user-show-info-item">
                        <span class="user-show-info-label">
                            <i class="fas fa-mobile-alt"></i>
                            Phone Number 2
                        </span>
                        <strong>{{ $user->phone_2 ?: 'Not Provided' }}</strong>
                    </div>

                    <div class="user-show-info-item">
                        <span class="user-show-info-label">
                            <i class="fas fa-user-tag"></i>
                            Assigned Role
                        </span>
                        <strong class="user-show-role-value">
                            {{ $roleName ?? 'Not Assigned' }}
                        </strong>
                    </div>
                </div>

                <div class="user-show-section-divider"></div>

                {{-- ACCOUNT SECURITY --}}
                <div class="user-show-card-heading user-show-security-heading">
                    <div class="user-show-heading-icon security-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h3>Account Security</h3>
                        <p>Password and account security information.</p>
                    </div>
                </div>

                <div class="user-show-security-box">
                    <div class="user-show-security-icon">
                        <i class="fas fa-lock"></i>
                    </div>

                    <div class="user-show-security-text">
                        <strong>Password Protected</strong>
                        <span>
                            This account password is securely hashed and cannot be displayed.
                        </span>
                    </div>

                    <span class="user-show-security-status">
                        <i class="fas fa-check-circle"></i>
                        Protected
                    </span>
                </div>

                <div class="user-show-last-updated">
                    <i class="far fa-clock"></i>
                    Last updated:
                    {{ $user->updated_at?->format('d M Y, h:i A') ?? 'Not Available' }}
                </div>
            </div>

        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/backend/setting_management/system_users/show_page/user_show.js') }}"></script>
@stop
