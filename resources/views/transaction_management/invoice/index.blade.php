@extends('adminlte::page')

@section('title', 'Invoices')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Invoice List</h1>
        <a href="{{ route('invoices.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Invoice
        </a>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Invoice No</th>
                            <th>Customer</th>
                            <th>Branch</th>
                            <th>Date</th>
                            <th>Sub Total Amount</th>
                            <th>Discount Amount</th>
                            <th>Total Amount</th>
                            <th>Paid By</th>
                            <th>Due Amount</th>
                            <th>Paid Amount</th>
                            <th>Total Change</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices as $invoice)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $invoice->invoice_id ?? 'N/A' }}</td>
                                <td>{{ $invoice->customer->name ?? 'N/A' }}</td>
                                <td>{{ $invoice->branch->name ?? 'N/A' }}</td>
                                <td>
                                    {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') : 'N/A' }}
                                </td>
                                <td>৳{{ number_format($invoice->discount_value, 2) }}</td>
                                <td>৳{{ number_format($invoice->sub_total, 2) }}</td>
                                <td>৳{{ number_format($invoice->total, 2) }}</td>
                                <td>{{ $invoice->paidByUser->name ?? '-' }}</td>

                                <td>
                                    @if ($invoice->status == '0')
                                        ৳{{ number_format(($invoice->total ?? 0) - ($invoice->paid_amount ?? 0), 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>৳{{ number_format($invoice->paid_amount ?? 0, 2) }}</td>
                                <td>
                                    @if ($invoice->status == '1')
                                        ৳{{ number_format(($invoice->paid_amount ?? 0) - ($invoice->total ?? 0), 2) }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    @if ($invoice->status == '1')
                                        <span class="badge badge-success">Paid</span>
                                    @elseif ($invoice->status == '0')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($invoice->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-info"
                                        title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-primary"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Are you sure to delete this invoice?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted">No invoices found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
