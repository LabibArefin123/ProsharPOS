@extends('adminlte::page')

@section('title', 'Edit Payment')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Payment</h3>
        <a href="{{ route('payments.index') }}" class="btn btn-sm btn-secondary">Back</a>
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

                <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label><strong>Payment Name</strong></label>
                            <input type="text" name="payment_name" class="form-control"
                                value="{{ old('payment_name', $payment->payment_name) }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Invoice</strong></label>
                            <select name="invoice_id" class="form-control">
                                <option value="">-- Select Invoice (Optional) --</option>
                                @foreach ($invoices as $invoice)
                                    <option value="{{ $invoice->id }}"
                                        {{ $invoice->id == $payment->invoice_id ? 'selected' : '' }}>
                                        #{{ $invoice->invoice_id }} - {{ $invoice->customer->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Paid By</strong></label>
                            <select name="paid_by" class="form-control" required>
                                <option value="">-- Select User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $user->id == $payment->paid_by ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Payment Type</strong></label>
                            <select name="payment_type" class="form-control" required>
                                <option value="cash" {{ $payment->payment_type == 'cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="bank" {{ $payment->payment_type == 'bank' ? 'selected' : '' }}>Bank
                                </option>
                                <option value="mobile" {{ $payment->payment_type == 'mobile' ? 'selected' : '' }}>Mobile
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Paid Amount</strong></label>
                            <input type="number" step="0.01" name="paid_amount" class="form-control"
                                value="{{ old('paid_amount', $payment->paid_amount) }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Due Amount</strong></label>
                            <input type="number" step="0.01" name="due_amount" class="form-control"
                                value="{{ old('due_amount', $payment->due_amount) }}">
                        </div>

                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Update Payment</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop
