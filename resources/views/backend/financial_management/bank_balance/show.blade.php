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
    <div class="card ">
        <div class="card-body">
            <div class="row">
                {{-- User --}}
                <div class="col-md-6 form-group">
                    <label><strong>User's Name</strong></label>
                    <input type="text" class="form-control" value="{{ $bank_balance->user->name ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>User's Username</strong></label>
                    <input type="text" class="form-control" value="{{ $bank_balance->user->username ?? 'N/A' }}"
                        readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>User's Email</strong></label>
                    <input type="text" class="form-control" value="{{ $bank_balance->user->email ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>User's Phone</strong></label>
                    <input type="text" class="form-control" value="{{ $bank_balance->user->phone ?? 'N/A' }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Balance (USD) from [DB]</strong></label>
                    <input type="text" class="form-control"
                        value="${{ number_format($bank_balance->balance_in_dollars, 2) }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Balance (BDT) from [DB] </strong></label>
                    <input type="text" class="form-control"
                        value="৳{{ number_format($bank_balance->balance, 2) }}" readonly>
                </div>
            </div>
        </div>
    </div>
@stop
