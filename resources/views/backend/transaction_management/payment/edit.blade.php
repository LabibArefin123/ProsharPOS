@extends('adminlte::page')

@section('title', 'Edit Payment')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Payment</h3>
        <a href="{{ route('payments.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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

            <form action="{{ route('payments.update', $payment->id) }}" method="POST" data-confirm="edit">
                @csrf
                @method('PUT')
                <div class="row">

                    <div class="col-md-6 form-group">
                        <label><strong>Payment Name</strong></label> <span class="text-danger">*</span>
                        <input type="text" name="payment_name"
                            class="form-control @error('payment_name') is-invalid @enderror"
                            value="{{ old('payment_name', $payment->payment_name) }}">
                        @error('payment_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Invoice</strong></label> <span class="text-danger">*</span>
                        <select name="invoice_id" class="form-control @error('invoice_id') is-invalid @enderror">
                            <option value="">-- Select Invoice (Optional) --</option>
                            @foreach ($invoices as $invoice)
                                <option value="{{ $invoice->id }}"
                                    {{ $invoice->id == $payment->invoice_id ? 'selected' : '' }}>
                                    #{{ $invoice->invoice_id }} - {{ $invoice->customer->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                        @error('invoice_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Paid By</strong></label> <span class="text-danger">*</span>
                        <select name="paid_by" class="form-control  @error('paid_by') is-invalid @enderror">
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $user->id == $payment->paid_by ? 'selected' : '' }}>{{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('paid_by')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Payment Type</strong></label> <span class="text-danger">*</span>
                        <select name="payment_type" class="form-control  @error('payment_type') is-invalid @enderror">
                            <option value="">--- Select Payment Type ---
                            </option>
                            <option value="cash" {{ $payment->payment_type == 'cash' ? 'selected' : '' }}>Cash
                            </option>
                            <option value="bank" {{ $payment->payment_type == 'bank' ? 'selected' : '' }}>Bank
                            </option>
                            <option value="mobile" {{ $payment->payment_type == 'mobile' ? 'selected' : '' }}>Mobile
                            </option>
                        </select>
                        @error('payment_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Payment Method</strong></label> <span class="text-danger">*</span>
                        <select name="payment_method" class="form-control @error('payment_method') is-invalid @enderror">
                            <option value="">--- Select Method ---</option>
                            <option value="Cash" {{ $payment->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bKash" {{ $payment->payment_method == 'bKash' ? 'selected' : '' }}>bKash
                            </option>
                            <option value="Nagad" {{ $payment->payment_method == 'Nagad' ? 'selected' : '' }}>Nagad
                            </option>
                            <option value="Bank" {{ $payment->payment_method == 'Bank' ? 'selected' : '' }}>Bank</option>
                            <option value="Card" {{ $payment->payment_method == 'Card' ? 'selected' : '' }}>Card</option>
                        </select>
                        @error('payment_method')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Transaction ID</strong></label>
                        <input type="text" name="transaction_id"
                            value="{{ old('transaction_id', $payment->transaction_id) }}"
                            class="form-control @error('transaction_id') is-invalid @enderror"
                            placeholder="Enter trx ID (if applicable)">
                        @error('transaction_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-12 form-group">
                        <label><strong>Note</strong></label>
                        <textarea name="note" class="form-control @error('note') is-invalid @enderror" rows="2"
                            placeholder="Optional note">{{ old('note', $payment->note) }}</textarea>
                        @error('note')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Paid Amount</strong></label> <span class="text-danger">*</span>
                        <input type="number" step="0.01" name="paid_amount"
                            class="form-control @error('paid_amount') is-invalid @enderror"
                            value="{{ old('paid_amount', $payment->paid_amount) }}">
                        @error('paid_amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Due Amount</strong></label>
                        <input type="number" step="0.01" name="due_amount" class="form-control"
                            value="{{ old('due_amount', $payment->due_amount) }}">
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>

            </form>
        </div>
    </div>
@stop
