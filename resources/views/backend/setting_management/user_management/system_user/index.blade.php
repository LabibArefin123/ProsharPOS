@extends('adminlte::page')

@section('title', 'System Users')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_base.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_table.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_profile.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_actions.css') }}">
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/system_user/index_page/custom_users_modal.css') }}">
@stop

@section('content_header')
    @include('backend.setting_management.user_management.system_user.partials.index_page.header')
@stop

@section('content')
    <div class="container-fluid system-users-page">
        <div class="system-users-card">
            @include('backend.setting_management.user_management.system_user.partials.index_page.part_1')
            @include('backend.setting_management.user_management.system_user.partials.index_page.part_2')
        </div>
    </div>

    {{-- CHANGE PASSWORD MODAL --}}
    @include('backend.setting_management.user_management.system_user.modals.pass_change_modal')
@stop

@section('js')
    <script src="{{ asset('js/backend/setting_management/system_users/index_page/change_password.js') }}"></script>
@stop
