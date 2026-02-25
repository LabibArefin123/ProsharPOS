@extends('adminlte::page')

@section('title', 'Payment History')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Payment History</h3>
        <a href="{{ route('payments.create') }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Add Payment
        </a>
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
                            <th>Invoice ID</th>
                            <th>Customer</th>
                            <th>Paid By</th>
                            <th class="text-end">Paid Amount (৳)</th>
                            <th class="text-end">Due Amount (৳)</th>
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
                                <td>{{ $payment->invoice?->customer?->name ?? '-' }}</td>
                                <td>{{ $payment->paidBy?->name ?? '-' }}</td>
                                <td class="text-end">৳{{ number_format($payment->paid_amount, 2) }}</td>
                                <td class="text-end">৳{{ number_format($payment->due_amount, 2) }}</td>
                                <td>{{ ucfirst($payment->payment_type) }}</td>
                                <td>{{ $payment->created_at->format('d M, Y H:i') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Are you sure to delete this payment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted">No payments found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <!-- Optional: DataTables styling if you want advanced sorting/searching -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    <!-- Optional: DataTables scripts -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTables').DataTable({
                "order": [
                    [0, "desc"]
                ],
                "columnDefs": [{
                        "orderable": false,
                        "targets": -1
                    } // Actions column
                ]
            });
        });
    </script>
@stop
