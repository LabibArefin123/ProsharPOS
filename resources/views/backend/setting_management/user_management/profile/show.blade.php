@extends('adminlte::page')

@section('title', 'My Profile')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/backend/user_profile/show_page/profile_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/user_profile/show_page/profile_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/user_profile/show_page/profile_information.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/user_profile/show_page/profile_actions.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/user_profile/show_page/profile_resp.css') }}">
@stop

@section('content_header')
    @include('backend.setting_management.user_management.profile.partial.show_page.header')
@stop

@section('content')
    @php
        $profileFields = [
            $user->name,
            $user->username,
            $user->email,
            $user->phone,
            $user->phone_2,
            $user->profile_picture,
        ];

        $completedFields = collect($profileFields)->filter(fn($value) => filled($value))->count();

        $profileCompletion = (int) round(($completedFields / count($profileFields)) * 100);

        $initials = collect(explode(' ', trim($user->name)))
            ->filter()
            ->take(2)
            ->map(fn($part) => strtoupper(substr($part, 0, 1)))
            ->implode('');
    @endphp

    <div class="profile-page-container">
        {{-- Profile Overview --}}
       @include('backend.setting_management.user_management.profile.partial.show_page.part_1')
        {{-- Profile Information --}}
        <div class="profile-content-grid">
            <div class="profile-main-column">
                {{-- Personal Information --}}
                @include('backend.setting_management.user_management.profile.partial.show_page.part_2_a')
                {{-- Contact Information --}}
                @include('backend.setting_management.user_management.profile.partial.show_page.part_2_b')
                {{-- Account Information --}}
                @include('backend.setting_management.user_management.profile.partial.show_page.part_2_c')
            </div>

            {{-- Sidebar --}}
            <aside class="profile-sidebar-column">
                {{-- Profile Completion --}}
               @include('backend.setting_management.user_management.profile.partial.show_page.part_2_d')
               {{-- Quick Actions --}}
               @include('backend.setting_management.user_management.profile.partial.show_page.part_2_e')
               {{-- Helpful Note --}}
               @include('backend.setting_management.user_management.profile.partial.show_page.part_2_f')
            </aside>
        </div>
    </div>
@stop

@push('js')
    <script src="{{ asset('js/custom_backend/profile_page/show_page/profile_show_init.js') }}"></script>
    <script src="{{ asset('js/custom_backend/profile_page/show_page/profile_show_animation.js') }}"></script>
    <script src="{{ asset('js/custom_backend/profile_page/show_page/profile_show_progress.js') }}"></script>
    <script src="{{ asset('js/custom_backend/profile_page/show_page/profile_show_actions.js') }}"></script>
    <script src="{{ asset('js/custom_backend/profile_page/show_page/profile_show_copy.js') }}"></script>
@endpush
