@extends('adminlte::page')

@section('title', 'Edit Bank Withdraw')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Bank Withdraw</h3>
        <a href="{{ route('bank_withdraws.index') }}"
            class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bank_withdraws.update', $bankWithdraw->id) }}" method="POST" data-confirm="edit">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- User --}}
                        <div class="col-md-6 form-group">
                            <label><strong>User</strong></label>
                            <select name="user_id" class="form-control">
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}"
                                        {{ $bankWithdraw->user_id == $u->id ? 'selected' : '' }}>
                                        {{ $u->name }} ({{ $u->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Bank Balance --}}
                        <div class="col-md-6 form-group">
                            <label><strong>Bank Balance</strong></label>
                            <select name="bank_balance_id" class="form-control">
                                @foreach ($balances as $b)
                                    <option value="{{ $b->id }}"
                                        {{ $bankWithdraw->bank_balance_id == $b->id ? 'selected' : '' }}>
                                        {{ number_format($b->balance, 2) }} BDT
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Amount --}}
                        <div class="col-md-6 form-group">
                            <label><strong>Withdraw Amount (BDT)</strong></label>
                            <input type="number" step="0.01" name="amount" class="form-control"
                                value="{{ $bankWithdraw->amount }}">
                        </div>

                        {{-- Date --}}
                        <div class="col-md-6 form-group">
                            <label><strong>Withdraw Date</strong></label>
                            <input type="date" name="withdraw_date" class="form-control"
                                value="{{ $bankWithdraw->withdraw_date }}">
                        </div>

                        {{-- Method --}}
                        <div class="col-md-6 form-group">
                            <label><strong>Withdraw Method</strong></label>
                            <select name="withdraw_method" class="form-control">
                                <option value="cash" {{ $bankWithdraw->withdraw_method == 'cash' ? 'selected' : '' }}>
                                    Cash</option>
                                <option value="bank_transfer"
                                    {{ $bankWithdraw->withdraw_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer
                                </option>
                                <option value="cheque" {{ $bankWithdraw->withdraw_method == 'cheque' ? 'selected' : '' }}>
                                    Cheque</option>
                                <option value="mobile_banking"
                                    {{ $bankWithdraw->withdraw_method == 'mobile_banking' ? 'selected' : '' }}>Mobile
                                    Banking</option>
                            </select>
                        </div>

                        {{-- Reference --}}
                        <div class="col-md-6 form-group">
                            <label><strong>Reference</strong></label>
                            <input type="text" name="reference_no" class="form-control"
                                value="{{ $bankWithdraw->reference_no }}">
                        </div>

                        {{-- Note --}}
                        <div class="col-md-12 form-group">
                            <label><strong>Note</strong></label>
                            <textarea name="note" class="form-control" rows="3">{{ $bankWithdraw->note }}</textarea>
                        </div>

                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@stop
