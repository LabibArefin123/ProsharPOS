@extends('adminlte::page')

@section('title', 'View Payment')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Payment Details</h3>
        <div>
            <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('payments.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label><strong>Payment ID</strong></label>
                    <input type="text" class="form-control" value="{{ $payment->payment_id }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Payment Name</strong></label>
                    <input type="text" class="form-control" value="{{ $payment->payment_name }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Invoice</strong></label>
                    <input type="text" class="form-control"
                        value="{{ $payment->invoice ? $payment->invoice->invoice_id : '-' }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Paid By</strong></label>
                    <input type="text" class="form-control" value="{{ $payment->paidBy ? $payment->paidBy->name : '-' }}"
                        readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Payment Type</strong></label>
                    <input type="text" class="form-control" value="{{ ucfirst($payment->payment_type) }}" readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Paid Amount</strong></label>
                    <input type="text" class="form-control" value="৳{{ number_format($payment->paid_amount, 2) }}"
                        readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Due Amount</strong></label>
                    <input type="text" class="form-control" value="৳{{ number_format($payment->due_amount, 2) }}"
                        readonly>
                </div>

                <div class="col-md-6 form-group">
                    <label><strong>Date</strong></label>
                    <input type="text" class="form-control" value="{{ $payment->created_at->format('d M, Y H:i') }}"
                        readonly>
                </div>
            </div>
        </div>
    </div>
@stop
