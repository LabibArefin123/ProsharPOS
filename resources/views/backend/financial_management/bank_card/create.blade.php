@extends('adminlte::page')

@section('title', 'Add Card Payment')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add Card Payment</h3>
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

            <form action="{{ route('bank_cards.store') }}" method="POST" data-confirm="create">
                @csrf
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label for="bank_balance_id"><strong>Bank</strong> <span class="text-danger">*</span></label>
                        <select name="bank_balance_id" id="bank_balance_id"
                            class="form-control @error('bank_balance_id') is-invalid @enderror">
                            <option value="">Select Bank</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}"
                                    {{ old('bank_balance_id') == $bank->id ? 'selected' : '' }}>
                                    {{ $bank->name }} ({{ $bank->user->name ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
                        @error('bank_balance_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="payment_date"><strong>Payment Date</strong> <span class="text-danger">*</span></label>
                        <input type="date" name="payment_date" id="payment_date"
                            class="form-control @error('payment_date') is-invalid @enderror"
                            value="{{ old('payment_date', date('Y-m-d')) }}">
                        @error('payment_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="card_type"><strong>Card Type</strong> <span class="text-danger">*</span></label>
                        <select name="card_type" id="card_type"
                            class="form-control @error('card_type') is-invalid @enderror">
                            <option value="">Select Card</option>
                            <option value="Visa" {{ old('card_type') == 'Visa' ? 'selected' : '' }}>Visa</option>
                            <option value="MasterCard" {{ old('card_type') == 'MasterCard' ? 'selected' : '' }}>MasterCard
                            </option>
                            <option value="Amex" {{ old('card_type') == 'Amex' ? 'selected' : '' }}>Amex</option>
                            <option value="Other" {{ old('card_type') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('card_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="card_holder_name"><strong>Card Holder Name</strong> <span
                                class="text-danger">*</span></label>
                        <input type="text" name="card_holder_name" id="card_holder_name"
                            class="form-control @error('card_holder_name') is-invalid @enderror"
                            value="{{ old('card_holder_name') }}">
                        @error('card_holder_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="card_last_four"><strong>Card Last 4 Digits</strong> <span
                                class="text-danger">*</span></label>
                        <input type="text" name="card_last_four" id="card_last_four"
                            class="form-control @error('card_last_four') is-invalid @enderror" maxlength="4"
                            value="{{ old('card_last_four') }}">
                        @error('card_last_four')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="amount"><strong>Amount (BDT)</strong> <span class="text-danger">*</span></label>
                        <input type="number" name="amount" id="amount"
                            class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}">
                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="amount_in_dollar"><strong>Amount (USD)</strong></label>
                        <input type="number" name="amount_in_dollar" id="amount_in_dollar"
                            class="form-control @error('amount_in_dollar') is-invalid @enderror"
                            value="{{ old('amount_in_dollar') }}">
                        @error('amount_in_dollar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="reference_no"><strong>Reference No</strong> <span class="text-danger">*</span></label>
                        <input type="text" name="reference_no" id="reference_no"
                            class="form-control @error('reference_no') is-invalid @enderror"
                            value="{{ old('reference_no') }}">
                        @error('reference_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="note"><strong>Note</strong></label>
                        <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>

            </form>
        </div>
    </div>
@stop
