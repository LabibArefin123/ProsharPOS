@extends('adminlte::page')

@section('title', 'Add Bank Withdraw')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add Bank Withdraw</h3>
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
    <div class="card shadow-lg">
        <div class="card-body">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('bank_withdraws.store') }}" method="POST" data-confirm="create">
                @csrf

                <div class="row">

                    {{-- User --}}
                    <div class="col-md-6 form-group">
                        <label><strong>User</strong> <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Bank Balance --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Bank Balance</strong> <span class="text-danger">*</span></label>
                        <select name="bank_balance_id" class="form-control @error('bank_balance_id') is-invalid @enderror">
                            <option value="">Select Bank Balance</option>
                            @foreach ($balances as $balance)
                                <option value="{{ $balance->id }}"
                                    {{ old('bank_balance_id') == $balance->id ? 'selected' : '' }}>
                                    {{ number_format($balance->balance, 2) }} BDT
                                </option>
                            @endforeach
                        </select>
                        @error('bank_balance_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Withdraw Amount (BDT)</strong> <span class="text-danger">*</span></label>
                        <input type="number" name="amount" step="0.01"
                            class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}"
                            placeholder="Enter withdraw amount">
                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Withdraw Date --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Withdraw Date</strong></label>
                        <input type="date" name="withdraw_date"
                            class="form-control @error('withdraw_date') is-invalid @enderror"
                            value="{{ old('withdraw_date') }}">
                        @error('withdraw_date')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Withdraw Method --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Withdraw Method</strong></label>
                        <select name="withdraw_method" class="form-control @error('withdraw_method') is-invalid @enderror">
                            <option value="">Select Method</option>
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="cheque">Cheque</option>
                            <option value="mobile_banking">Mobile Banking</option>
                        </select>
                        @error('withdraw_method')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Reference --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Reference</strong></label>
                        <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no') }}"
                            placeholder="e.g., TRX ID / Cheque No">
                    </div>

                    {{-- Note --}}
                    <div class="col-md-12 form-group">
                        <label><strong>Note</strong></label>
                        <textarea name="note" class="form-control" rows="3" placeholder="Optional note">{{ old('note') }}</textarea>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
    </div>
@stop
