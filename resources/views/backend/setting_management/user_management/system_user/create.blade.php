
@extends('adminlte::page')

@section('title', 'Add System User')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/form_part/form_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/form_part/form_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/form_part/form_fields.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/form_part/form_actions.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/form_part/form_resp.css') }}">
@stop

@section('content_header')
    <div class="user-form-header">
        <div class="user-form-heading">
            <span class="user-form-eyebrow">USER MANAGEMENT</span>
            <h1><i class="fas fa-user-plus"></i> Add System User</h1>
            <p>Create a new account and assign system permissions.</p>
        </div>

        <a href="{{ route('system_users.index') }}" class="user-form-back-btn">
            <i class="fas fa-arrow-left"></i>
            Go Back
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid user-form-page">

        @if ($errors->any())
            <div class="user-form-alert user-form-alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Please correct the following errors:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="user-form-alert user-form-alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="user-form-card">

            <div class="user-form-card-header">
                <div class="user-form-card-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h5>Create New Account</h5>
                    <p>Fill in the information below to register a system user.</p>
                </div>
            </div>

            <form action="{{ route('system_users.store') }}"
                method="POST" class="system-user-form">

                @csrf

                <div class="user-form-section">
                    <div class="user-form-section-heading">
                        <i class="fas fa-id-card"></i>
                        <div>
                            <h6>Personal Information</h6>
                            <p>Enter the new user's basic account information.</p>
                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="name">Full Name <span>*</span></label>
                            <div class="user-input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Enter full name" required>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="role">Assign Role <span>*</span></label>
                            <div class="user-input-wrapper">
                                <i class="fas fa-user-shield"></i>
                                <select id="role" name="role"
                                    class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ old('role') == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('role')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="username">Username <span>*</span></label>
                            <div class="user-input-wrapper">
                                <i class="fas fa-at"></i>
                                <input type="text" id="username" name="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}"
                                    placeholder="Choose a username" required>
                            </div>
                            @error('username')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="email">Email Address <span>*</span></label>
                            <div class="user-input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="Enter email address" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="user-form-section">
                    <div class="user-form-section-heading">
                        <i class="fas fa-address-book"></i>
                        <div>
                            <h6>Contact Information</h6>
                            <p>Provide the user's contact information.</p>
                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="phone">Phone Number <span>*</span></label>
                            <div class="user-input-wrapper">
                                <i class="fas fa-phone"></i>
                                <input type="text" id="phone" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}"
                                    placeholder="Enter phone number" required>
                            </div>
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone_2">Alternative Phone <small>(Optional)</small></label>
                            <div class="user-input-wrapper">
                                <i class="fas fa-mobile-alt"></i>
                                <input type="text" id="phone_2" name="phone_2"
                                    class="form-control @error('phone_2') is-invalid @enderror"
                                    value="{{ old('phone_2') }}"
                                    placeholder="Enter alternative phone">
                            </div>
                            @error('phone_2')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="user-form-section">
                    <div class="user-form-section-heading">
                        <i class="fas fa-shield-alt"></i>
                        <div>
                            <h6>Account Security</h6>
                            <p>Create a secure password for the new account.</p>
                        </div>
                    </div>

                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="password">Password <span>*</span></label>
                            <div class="user-input-wrapper user-password-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter password" autocomplete="new-password" required>
                                <button type="button" class="user-password-toggle"
                                    data-target="password" aria-label="Show password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="user-field-hint">Minimum 6 characters.</small>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password_confirmation">Confirm Password <span>*</span></label>
                            <div class="user-input-wrapper user-password-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Confirm password" autocomplete="new-password" required>
                                <button type="button" class="user-password-toggle"
                                    data-target="password_confirmation" aria-label="Show password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="user-form-footer">
                    <a href="{{ route('system_users.index') }}" class="user-form-cancel-btn">
                        Cancel
                    </a>

                    <button type="submit" class="user-form-submit-btn">
                        <i class="fas fa-user-plus"></i>
                        Create User
                    </button>
                </div>

            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/backend/setting_management/system_users/form_part/user_form.js') }}"></script>
@stop
