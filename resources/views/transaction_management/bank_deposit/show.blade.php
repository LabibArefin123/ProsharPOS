@extends('adminlte::page')

@section('title', 'View Bank Deposit')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Deposit Details</h3>

        <div>
            <a href="{{ route('bank_deposits.edit', $bankDeposit->id) }}" class="btn btn-primary btn-sm">Edit</a>
            <a href="{{ route('bank_deposits.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">

                <div class="row">

                    {{-- User --}}
                    <div class="col-md-6 form-group">
                        <label><strong>User</strong></label>
                        <input class="form-control" value="{{ $bankDeposit->user->name }}" readonly>
                    </div>

                    {{-- Bank Balance --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Bank Balance</strong></label>
                        <input class="form-control" value="{{ $bankDeposit->bankBalance->balance . ' Tk' }}" readonly>
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Amount (BDT)</strong></label>
                        <input class="form-control" value="৳{{ number_format($bankDeposit->amount, 2) }}" readonly>
                    </div>

                    {{-- Deposit Method --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Deposit Method</strong></label>
                        <input class="form-control"
                            value="{{ ucfirst(str_replace('_', ' ', $bankDeposit->deposit_method)) }}" readonly>
                    </div>

                    {{-- Deposit Date --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Deposit Date</strong></label>
                        <input class="form-control"
                            value="{{ \Carbon\Carbon::parse($bankDeposit->deposit_date)->format('d F Y') }}" readonly>
                    </div>

                    {{-- Reference --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Reference</strong></label>
                        <input class="form-control" value="{{ $bankDeposit->reference_no }}" readonly>
                    </div>

                    {{-- Note --}}
                    <div class="col-md-12 form-group">
                        <label><strong>Note</strong></label>
                        <textarea class="form-control" readonly>{{ $bankDeposit->note }}</textarea>
                    </div>

                </div>

            </div>
        </div>
    </div>
@stop
