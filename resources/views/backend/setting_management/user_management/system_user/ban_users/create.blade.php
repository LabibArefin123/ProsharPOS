@extends('adminlte::page')

@section('title', 'Ban User')

@section('css')
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/ban_user/form_part/ban_form_base.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/ban_user/form_part/ban_form_header.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/ban_user/form_part/ban_form_fields.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/ban_user/form_part/ban_form_actions.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/ban_user/form_part/ban_form_resp.css') }}">
@stop

@section('content_header')
    <div class="ban-form-page-header">
        <div>
            <span class="ban-form-eyebrow">
                <i class="fas fa-shield-alt"></i>
                USER SECURITY MANAGEMENT
            </span>
            <h1>Ban User</h1>
            <p>Restrict a user account and provide a reason for the action.</p>
        </div>

        <a href="{{ route('ban_users.index') }}" class="ban-form-back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Users</span>
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid ban-form-container">

        @if ($errors->any())
            <div class="ban-form-alert">
                <div class="ban-alert-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div>
                    <strong>Please check the following information</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="ban-form-card">
            <div class="ban-form-card-header">
                <div class="ban-form-card-icon">
                    <i class="fas fa-user-lock"></i>
                </div>
                <div>
                    <h3>Account Restriction Details</h3>
                    <p>Select the account and provide the reason for banning.</p>
                </div>
            </div>

            <form action="{{ route('ban_users.store') }}" method="POST">
                @csrf

                <div class="ban-form-body">
                    <div class="ban-form-section-title">
                        <span class="ban-section-number">01</span>
                        <div>
                            <h4>User Selection</h4>
                            <p>Choose the account you want to restrict.</p>
                        </div>
                    </div>

                    <div class="form-group ban-form-group">
                        <label for="user_id">
                            Select User <span class="text-danger">*</span>
                        </label>

                        <div class="ban-input-wrapper">
                            <i class="fas fa-user ban-input-icon"></i>
                            <select name="user_id" id="user_id"
                                class="form-control ban-form-control @error('user_id') is-invalid @enderror" required>
                                <option value="">Choose a user account</option>

                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @error('user_id')
                            <span class="ban-field-error">{{ $message }}</span>
                        @enderror

                        <small class="ban-field-hint">
                            <i class="fas fa-info-circle"></i>
                            Select the account that should no longer have access.
                        </small>
                    </div>

                    <div class="ban-form-divider"></div>

                    <div class="ban-form-section-title">
                        <span class="ban-section-number">02</span>
                        <div>
                            <h4>Restriction Reason</h4>
                            <p>Explain why this account is being banned.</p>
                        </div>
                    </div>

                    <div class="form-group ban-form-group">
                        <label for="ban_reason">Ban Reason</label>

                        <div class="ban-textarea-wrapper">
                            <textarea name="ban_reason" id="ban_reason" rows="5"
                                class="form-control ban-form-control ban-reason-textarea @error('ban_reason') is-invalid @enderror"
                                placeholder="Describe the reason for restricting this account...">{{ old('ban_reason') }}</textarea>
                        </div>

                        @error('ban_reason')
                            <span class="ban-field-error">{{ $message }}</span>
                        @enderror

                        <small class="ban-field-hint">
                            <i class="fas fa-lightbulb"></i>
                            Provide a clear explanation for future reference.
                        </small>
                    </div>

                    <div class="ban-warning-note">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Before you continue</strong>
                            <p>
                                Please verify that you selected the correct user.
                                Banning an account may restrict the user's access to your system.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="ban-form-footer">
                    <a href="{{ route('ban_users.index') }}" class="ban-form-cancel-btn">
                        Cancel
                    </a>

                    <button type="submit" class="ban-form-submit-btn">
                        <i class="fas fa-user-lock"></i>
                        Ban User
                    </button>
                </div>
            </form>
        </div>
    </div>
@stop
