@extends('adminlte::page')

@section('title', 'Show Bank Withdraw')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Bank Withdraw Details</h3>
        <div>
            <a href="{{ route('bank_withdraws.edit', $bankWithdraw->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('bank_withdraws.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">

            <div class="row">

                <div class="col-md-6 form-group">
                    <label><strong>User</strong></label>
                    <input class="form-control" value="{{ $bankWithdraw->user->name }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Bank Balance</strong></label>
                    <input class="form-control" value="৳{{ number_format($bankWithdraw->bankBalance->balance, 2) }}"
                        readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Withdraw Amount</strong></label>
                    <input class="form-control text-danger" value="৳{{ number_format($bankWithdraw->amount, 2) }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Withdraw Method</strong></label>
                    <input class="form-control" value="{{ ucfirst(str_replace('_', ' ', $bankWithdraw->withdraw_method)) }}"
                        readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Withdraw Date</strong></label>
                    <input class="form-control"
                        value="{{ \Carbon\Carbon::parse($bankWithdraw->withdraw_date)->format('d F Y') }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Reference</strong></label>
                    <input class="form-control" value="{{ $bankWithdraw->reference_no }}" readonly>
                </div>

                <div class="col-md-12 form-group">
                    <label><strong>Note</strong></label>
                    <textarea class="form-control" readonly>{{ $bankWithdraw->note }}</textarea>
                </div>

            </div>
        </div>
    </div>
@stop
