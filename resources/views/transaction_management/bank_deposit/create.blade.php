@extends('adminlte::page')

@section('title', 'Add Bank Deposit')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add Bank Deposit</h3>
        <a href="{{ route('bank_deposits.index') }}"
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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('bank_deposits.store') }}" method="POST" data-confirm="create">
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

                        <div class="col-md-6 form-group">
                            <label for="bank_balance_id"><strong>Bank Balance</strong> <span
                                    class="text-danger">*</span></label>
                            <select name="bank_balance_id" id="bank_balance_id"
                                class="form-control @error('bank_balance_id') is-invalid @enderror">
                                <option value="">Select Bank Balannce</option>
                                @foreach ($balances as $balance)
                                    <option value="{{ $balance->id }}"
                                        {{ old('bank_balance_id') == $balance->id ? 'selected' : '' }}>
                                        {{ $balance->balance }} Taka
                                    </option>
                                @endforeach
                            </select>
                            @error('bank_balance_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Amount --}}
                        <div class="col-md-6 form-group">
                            <label><strong>Deposit Amount (BDT)</strong> <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                                value="{{ old('amount') }}" placeholder="Enter deposit amount">
                            @error('amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Deposit Date</strong></label>
                            <input type="date" name="deposit_date"
                                class="form-control @error('deposit_date') is-invalid @enderror"
                                value="{{ old('deposit_date') }}">
                            @error('deposit_date')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Method --}}
                        <div class="col-md-6 form-group">
                            <label><strong>Deposit Method</strong></label>
                            <select name="deposit_method"
                                class="form-control @error('deposit_method') is-invalid @enderror">
                                <option value="">Select Method</option>
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cheque">Cheque</option>
                                <option value="mobile_banking">Mobile Banking</option>
                            </select>
                            @error('deposit_method')
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
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@stop
