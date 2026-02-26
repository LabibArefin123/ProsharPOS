@extends('adminlte::page')

@section('title', 'Edit Card Payment')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Card Payment</h3>
        <a href="{{ route('bank_cards.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('bank_cards.update', $bankCard->id) }}" method="POST" data-confirm="edit">
                @csrf
                @method('PUT')
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label for="bank_balance_id"><strong>Bank</strong></label>
                        <select name="bank_balance_id" id="bank_balance_id"
                            class="form-control @error('bank_balance_id') is-invalid @enderror">
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}"
                                    {{ $bankCard->bank_balance_id == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->name }} ({{ $bank->user->name ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('bank_balance_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="payment_date"><strong>Payment Date</strong></label>
                        <input type="date" name="payment_date"
                            class="form-control @error('payment_date') is-invalid @enderror"
                            value="{{ old('payment_date', optional($bankCard->payment_date)->format('Y-m-d')) }}">
                        @error('payment_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="card_type"><strong>Card Type</strong></label>
                        <select name="card_type" class="form-control @error('card_type') is-invalid @enderror">
                            @foreach (['Visa', 'MasterCard', 'Amex', 'Other'] as $type)
                                <option value="{{ $type }}" {{ $bankCard->card_type == $type ? 'selected' : '' }}>
                                    {{ $type }}</option>
                            @endforeach
                        </select>
                        @error('card_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="card_holder_name"><strong>Card Holder Name</strong></label>
                        <input type="text" name="card_holder_name"
                            class="form-control @error('card_holder_name') is-invalid @enderror"
                            value="{{ old('card_holder_name', $bankCard->card_holder_name) }}">
                        @error('card_holder_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="card_last_four"><strong>Card Last 4 Digits</strong></label>
                        <input type="text" name="card_last_four" maxlength="4"
                            class="form-control @error('card_last_four') is-invalid @enderror"
                            value="{{ old('card_last_four', $bankCard->card_last_four) }}">
                        @error('card_last_four')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="amount"><strong>Amount (BDT)</strong></label>
                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                            value="{{ old('amount', $bankCard->amount) }}">
                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="amount_in_dollar"><strong>Amount (USD)</strong></label>
                        <input type="number" name="amount_in_dollar"
                            class="form-control @error('amount_in_dollar') is-invalid @enderror"
                            value="{{ old('amount_in_dollar', $bankCard->amount_in_dollar) }}">
                        @error('amount_in_dollar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="reference_no"><strong>Reference No</strong></label>
                        <input type="text" name="reference_no"
                            class="form-control @error('reference_no') is-invalid @enderror"
                            value="{{ old('reference_no', $bankCard->reference_no) }}">
                        @error('reference_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="note"><strong>Note</strong></label>
                        <textarea name="note" class="form-control">{{ old('note', $bankCard->note) }}</textarea>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
@stop
