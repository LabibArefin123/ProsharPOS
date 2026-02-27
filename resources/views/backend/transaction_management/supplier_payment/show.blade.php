@extends('adminlte::page')

@section('title', 'Supplier Payment Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3>Supplier Payment Details</h3>
        <a href="{{ route('supplier_payments.index') }}" class="btn btn-sm btn-secondary">
            Back
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>Payment No</th>
                    <td>{{ $supplierPayment->payment_no }}</td>
                </tr>
                <tr>
                    <th>Supplier</th>
                    <td>{{ $supplierPayment->supplier->name }}</td>
                </tr>
                <tr>
                    <th>Amount</th>
                    <td>৳{{ number_format($supplierPayment->amount, 2) }}</td>
                </tr>
                <tr>
                    <th>Payment Date</th>
                    <td>{{ $supplierPayment->payment_date->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th>Method</th>
                    <td>{{ ucfirst($supplierPayment->payment_method) }}</td>
                </tr>
                <tr>
                    <th>Created By</th>
                    <td>{{ $supplierPayment->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Note</th>
                    <td>{{ $supplierPayment->note ?? '-' }}</td>
                </tr>
            </table>

        </div>
    </div>
@stop
