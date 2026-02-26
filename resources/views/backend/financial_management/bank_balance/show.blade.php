@extends('adminlte::page')

@section('title', 'View Bank Balance')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Bank Balance Details</h3>
        <div>
            <a href="{{ route('bank_balances.edit', $bank_balance->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('bank_balances.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                {{-- User --}}
                <div class="col-md-6 form-group">
                    <label><strong>User</strong></label>
                    <input type="text" class="form-control" value="{{ $bank_balance->user->name ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Username</strong></label>
                    <input type="text" class="form-control" value="{{ $bank_balance->user->username ?? 'N/A' }}"
                        readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Email</strong></label>
                    <input type="text" class="form-control" value="{{ $bank_balance->user->email ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Balance (USD)</strong></label>
                    <input type="text" class="form-control"
                        value="${{ number_format($bank_balance->balance_in_dollars, 2) }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Balance (BDT) from [DB] </strong></label>
                    <input type="text" class="form-control"
                        value="৳{{ number_format($bank_balance->original_balance, 2) }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Balance (BDT) In this System</strong></label>
                    <input type="text" class="form-control"
                        value="৳{{ number_format($bank_balance->system_balance, 2) }}" readonly>
                </div>
            </div>
        </div>
    </div>
@stop
