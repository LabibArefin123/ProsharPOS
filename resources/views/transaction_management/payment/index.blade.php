@extends('adminlte::page')

@section('title', 'Payments List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Payments List</h3>
        <a href="{{ route('payments.create') }}" class="btn btn-sm btn-success">Add New Payment</a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Payment ID</th>
                            <th>Payment Name</th>
                            <th>Invoice</th>
                            <th>Paid By</th>
                            <th>Paid Amount</th>
                            <th>Paid Amount(in Dollar)</th>
                            <th>Due Amount</th>
                            <th>Payment Type</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->payment_id }}</td>
                                <td>{{ $payment->payment_name }}</td>
                                <td>{{ $payment->invoice ? $payment->invoice->invoice_id : '-' }}</td>
                                <td>{{ $payment->paidBy ? $payment->paidBy->name : '-' }}</td>
                                <td>৳{{ number_format($payment->paid_amount, 2) }}</td>
                                <td>${{ number_format($payment->dollar_amount, 2) }}</td>
                                <td>৳{{ number_format($payment->due_amount, 2) }}</td>
                                <td>{{ ucfirst($payment->payment_type) }}</td>
                                <td>{{ $payment->created_at->format('d M, Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('payments.show', $payment->id) }}"
                                        class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('payments.edit', $payment->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Are you sure to delete this payment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">No payments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
