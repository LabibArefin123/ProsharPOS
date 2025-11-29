@extends('adminlte::page')

@section('title', 'User Details Information')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">User Details</h1>
        <button class="btn btn-warning btn-sm d-flex align-items-center gap-1" onclick="history.back()">
            <i class="fas fa-arrow-left mr-1"></i> Go Back
        </button>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Username</label>
                            <input type="text" class="form-control" value="{{ $user->username }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Phone</label>
                            <input type="text" class="form-control" value="{{ $user->phone ?? 'Not Provided' }}"
                                readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>User Role</label>
                            <input type="text" class="form-control" value="{{ $user->roles->pluck('name')->join(', ') }}"
                                readonly>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
