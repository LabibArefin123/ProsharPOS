@extends('adminlte::page')

@section('title', 'Invoice Return List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">Invoice Return System</h1>
        <a href="{{ route('invoices.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Invoice List
        </a>
    </div>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover table-striped align-middle" id="dataTables">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Invoice No</th>
                        <th>Customer</th>
                        <th>Branch</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $invoice->invoice_id }}</td>
                            <td>{{ $invoice->customer->name ?? 'N/A' }}</td>
                            <td>{{ $invoice->branch->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</td>
                            <td>৳{{ number_format($invoice->total, 2) }}</td>

                            <td>
                                @if ($invoice->status === 'returned')
                                    <span class="badge badge-danger">Returned</span>
                                @elseif($invoice->status === '1')
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if ($invoice->status !== 'returned')
                                    <a href="{{ route('invoice-return.create', $invoice->id) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-undo"></i> Return
                                    </a>
                                @else
                                    <form action="{{ route('invoice-return.undo', $invoice->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success" type="submit" title="Undo Return">
                                            <i class="fas fa-undo-alt"></i> Undo Return
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No invoices available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
