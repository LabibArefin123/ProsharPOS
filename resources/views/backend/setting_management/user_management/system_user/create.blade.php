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
    @include('backend.setting_management.user_management.system_user.partials.create_page.header')
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

        <div class="user-form-card">
            @include('backend.setting_management.user_management.system_user.partials.create_page.part_1')
            <form action="{{ route('system_users.store') }}" method="POST" class="system-user-form">
                @csrf
                {{-- Personal Information Part --}}
                @include('backend.setting_management.user_management.system_user.partials.create_page.part_2')
                {{-- Contact Information Part --}}
                @include('backend.setting_management.user_management.system_user.partials.create_page.part_3')
                {{-- Account Security Part --}}
                @include('backend.setting_management.user_management.system_user.partials.create_page.part_4')
                {{-- Footer Part --}}
                @include('backend.setting_management.user_management.system_user.partials.create_page.part_5')          
            </form>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/backend/setting_management/system_users/form_part/user_form.js') }}"></script>
@stop
