@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>View System User</h1>
        <a href="{{ route('system_users.index') }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l4.147
                        4.146a.5.5 0 0 1-.708.708l-5-5a.5.5
                        0 0 1 0-.708l5-5a.5.5 0 0
                        1 .708.708L2.707 7.5H14.5A.5.5
                        0 0 1 15 8z" />
            </svg>
            Go Back
        </a>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="form-group col-md-6">
                        <label><strong>Full Name:</strong></label>
                        <p class="form-control">{{ $user->name }}</p>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Username:</strong></label>
                        <p class="form-control">{{ $user->username }}</p>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Email Address:</strong></label>
                        <p class="form-control">{{ $user->email }}</p>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Phone 1:</strong></label>
                        <p class="form-control">{{ $user->phone ?? 'Not Provided' }}</p>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>User Role:</strong></label>
                        <p class="form-control">
                            {{ $user->roles->pluck('name')->join(', ') }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
