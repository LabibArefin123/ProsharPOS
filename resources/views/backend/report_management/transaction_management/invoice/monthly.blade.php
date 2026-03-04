@extends('adminlte::page')

@section('title', 'Invoice Monthly Report')

@section('content_header')
    <h1>Invoice Monthly Report</h1>
@stop

@section('content')

    {{-- Filter --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('report.invoice.monthly') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label>Month</label>
                        <select name="month" class="form-control">
                            <option value="">All Months</option>
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Year</label>
                        <select name="year" class="form-control">
                            <option value="">All Years</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Customer</label>
                        <select name="customer_id" class="form-control">
                            <option value="">All Customers</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                        <a href="{{ route('report.invoice.monthly.pdf', request()->query()) }}" class="btn btn-danger"
                            target="_blank">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover text-nowrap">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Invoice ID</th>
                        <th>Invoice Date</th>
                        <th>Customer</th>
                        <th>Total Items</th>
                        <th>Total Quantity</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $invoice->invoice_id }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d F Y') }}</td>
                            <td>{{ $invoice->customer?->name }}</td>
                            <td>{{ $invoice->invoiceItems->count() }}</td>
                            <td>{{ $invoice->invoiceItems->sum('quantity') }}</td>
                            <td>{{ number_format($invoice->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No invoices found</td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($invoices->count())
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="4" class="text-end">Total</td>

                            {{-- Total Item Lines --}}
                            <td>
                                {{ $invoices->sum(function ($invoice) {
                                    return $invoice->invoiceItems->count();
                                }) }}
                            </td>

                            {{-- Total Quantity --}}
                            <td>
                                {{ $invoices->sum(function ($invoice) {
                                    return $invoice->invoiceItems->sum('quantity');
                                }) }}
                            </td>

                            {{-- Total Amount --}}
                            <td>{{ number_format($invoices->sum('total'), 2) }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
@stop
