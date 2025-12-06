@extends('adminlte::page')

@section('title', 'Edit Bank Deposit')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Bank Deposit</h3>
        <a href="{{ route('bank_deposits.index') }}" class="btn btn-sm btn-secondary">Back</a>
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
                <form action="{{ route('bank_deposits.update', $bankDeposit->id) }}" method="POST" data-confirm="edit">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label><strong>User</strong></label>
                            <select name="user_id" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $bankDeposit->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="bank_balance_id">Bank Balance</label>
                            <select name="bank_balance_id" id="bank_balance_id"
                                class="form-control @error('bank_balance_id') is-invalid @enderror">
                                <option value="">Select Balance</option>

                                @foreach ($balances as $balance)
                                    <option value="{{ $balance->id }}"
                                        {{ $bankDeposit->bank_balance_id == $balance->id ? 'selected' : '' }}>
                                        {{ $balance->balance }} Taka
                                    </option>
                                @endforeach

                            </select>

                            @error('bank_balance_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Deposit Amount (BDT)</strong></label>
                            <input type="number" name="amount" class="form-control"
                                value="{{ old('amount', $bankDeposit->amount) }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Deposit Date</strong></label>
                            <input type="date" name="deposit_date"
                                class="form-control @error('deposit_date') is-invalid @enderror"
                                value="{{ old('deposit_date', $bankDeposit->deposit_date) }}">
                            @error('deposit_date')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Method</strong></label>
                            <select name="deposit_method" class="form-control @error('deposit_date') is-invalid @enderror">
                                <option value="cash" {{ $bankDeposit->deposit_method == 'cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="bank_transfer"
                                    {{ $bankDeposit->deposit_method == 'bank_transfer' ? 'selected' : '' }}>
                                    Bank Transfer</option>
                                <option value="cheque" {{ $bankDeposit->deposit_method == 'cheque' ? 'selected' : '' }}>
                                    Cheque
                                </option>
                                <option value="mobile_banking"
                                    {{ $bankDeposit->deposit_method == 'mobile_banking' ? 'selected' : '' }}>Mobile Banking
                                </option>
                            </select>
                            @error('deposit_date')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Reference</strong></label>
                            <input type="text" name="reference_no"
                                class="form-control @error('reference_no') is-invalid @enderror"
                                value="{{ old('reference_no', $bankDeposit->reference_no) }}">
                            @error('reference_no')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="col-md-12 form-group">
                            <label><strong>Note</strong></label>
                            <textarea name="note" class="form-control" rows="3">{{ old('note', $bankDeposit->note) }}</textarea>
                        </div>

                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@stop
