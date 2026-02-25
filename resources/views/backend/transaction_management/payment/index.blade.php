@extends('adminlte::page')

@section('title', 'Payments List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Payments List</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('payments.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Add Payment
            </a>
            <a href="{{ route('payments.history') }}" class="btn btn-sm btn-warning">
                <i class="fas fa-info"></i> See History Payment
            </a>
        </div>
    </div>
@stop

@section('content')
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
                        <th class="text-end">Paid Amount (৳)</th>
                        <th class="text-end">Paid Amount ($)</th>
                        <th class="text-end">Due (৳)</th>
                        <th class="text-end">Due ($)</th>
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
                            <td>
                                @if ($payment->invoice)
                                    <a href="{{ route('invoices.show', $payment->invoice->id) }}">
                                        {{ $payment->invoice->invoice_id }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $payment->paidBy?->name ?? '-' }}</td>
                            <td class="text-end">৳{{ number_format($payment->paid_amount, 2) }}</td>
                            <td class="text-end">${{ number_format($payment->dollar_amount, 2) }}</td>
                            <td class="text-end">৳{{ number_format($payment->due_amount, 2) }}</td>
                            <td class="text-end">${{ number_format($payment->due_amount_in_dollar, 2) }}</td>
                            <td>{{ ucfirst($payment->payment_type) }}</td>
                            <td>{{ $payment->created_at->format('d M, Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-info">View</a>
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
                            <td colspan="12" class="text-center text-muted">No payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop
