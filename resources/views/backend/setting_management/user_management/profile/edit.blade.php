@extends('adminlte::page')

@section('title', 'Edit My Profile')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/backend/user_profile/edit_page/edit_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/user_profile/edit_page/edit_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/user_profile/edit_page/edit_form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/user_profile/edit_page/edit_password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/user_profile/edit_page/edit_resp.css') }}">
@stop

@section('content_header')
    @include('backend.setting_management.user_management.profile.partial.edit_page.header')
@stop

@section('content')
    <div class="profile-edit-container">
        {{-- Validation Summary --}}
        @include('backend.setting_management.user_management.profile.partial.edit_page.error')

        <form action="{{ route('user_profile_update') }}" method="POST" enctype="multipart/form-data" id="profileUpdateForm">
            @csrf
            @method('PUT')

            {{-- Profile Edit Hero --}}
            @include('backend.setting_management.user_management.profile.partial.edit_page.part_1')
            {{-- Personal Information --}}
            @include('backend.setting_management.user_management.profile.partial.edit_page.part_2')
            {{-- Sticky Form Actions --}}
            @include('backend.setting_management.user_management.profile.partial.edit_page.part_3')
        </form>
    </div>
@stop


@push('js')
    <script src="{{ asset('js/custom_backend/profile_page/edit_page/profile_edit_init.js') }}"></script>
    <script src="{{ asset('js/custom_backend/profile_page/edit_page/profile_edit_changes.js') }}"></script>
    <script src="{{ asset('js/custom_backend/profile_page/edit_page/profile_edit_image.js') }}"></script>
    <script src="{{ asset('js/custom_backend/profile_page/edit_page/profile_edit_password.js') }}"></script>
    <script src="{{ asset('js/custom_backend/profile_page/edit_page/profile_edit_form.js') }}"></script>
@endpush
