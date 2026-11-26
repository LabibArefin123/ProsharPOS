@extends('adminlte::page')

@section('title', 'Permissions List')

@section('adminlte_css')
    {{-- Permission Generator --}}
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/permission/index_page/permission_generator.css') }}">
    {{-- Permission Modal --}}
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/permission/index_page/permission_modal.css') }}">
    {{-- Permission Table --}}
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/permission/index_page/permission_table.css') }}">
    {{-- Permission Buttons --}}
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/permission/index_page/permission_buttons.css') }}">
    {{-- Permission Pagination --}}
    <link rel="stylesheet"
        href="{{ asset('css/backend/setting_management/permission/index_page/permission_pagination.css') }}">
    {{-- Permission Responsive --}}
    <link rel="stylesheet" href="{{ asset('css/backend/setting_management/permission/index_page/permission_resp.css') }}">
@stop


@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Permissions List</h1>
        @if (auth()->user()->hasRole('admin'))
            <button type="button" id="delete-selected" class="btn btn-danger btn-sm">
                <i class="fas fa-trash-alt me-1"></i>
                Delete Selected
            </button>
        @endif
    </div>
@stop

@section('content')

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input.</strong>

            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            {{-- Permission Generator --}}
            @include('backend.setting_management.roles_and_permission.permission.partials.index_page._permission_generator')

            {{-- Hidden Permission Save Form --}}
            <form method="POST" action="{{ route('permissions.store') }}" id="permissionSaveForm">
                @csrf
            </form>
            {{-- Permission Generator Modal --}}
            @include('backend.setting_management.roles_and_permission.permission.partials.index_page._permission_generator_modal')

            {{-- Permissions Table --}}
            @include('backend.setting_management.roles_and_permission.permission.partials.index_page._permission_table')
        </div>
    </div>
@stop

@section('js')
    @include('backend.setting_management.roles_and_permission.permission.partials.index_page._permission_scripts')
@stop
