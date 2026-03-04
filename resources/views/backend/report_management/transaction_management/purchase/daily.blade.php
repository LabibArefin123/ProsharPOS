@extends('adminlte::page')

@section('title', 'Purchase Daily Report')

@section('content_header')
    <h1>Purchase Daily Report</h1>
@stop

@section('content')

    {{-- Filter --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('report.purchase.daily') }}">
                <div class="row g-3 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-control">
                            <option value="">All Suppliers</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                        <a href="{{ route('report.purchase.daily.pdf', request()->query()) }}" class="btn btn-danger"
                            target="_blank">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Report Table --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover text-nowrap">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Purchase Date</th>
                        <th>Reference No</th>
                        <th>Supplier</th>
                        <th>Total Items</th>
                        <th>Total Quantity</th>
                        <th>Total Amount</th>
                        <th>Note</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($purchases as $purchase)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d F Y') }}</td>
                            <td>{{ $purchase->reference_no ?? 'N/A' }}</td>
                            <td>{{ $purchase->supplier?->name }}</td>
                            <td>{{ $purchase->items->count() }}</td>
                            <td>{{ $purchase->items->sum('quantity') }}</td>
                            <td>{{ number_format($purchase->total_amount, 2) }}</td>
                            <td>{{ $purchase->note }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No purchase records found</td>
                        </tr>
                    @endforelse
                </tbody>

                @if ($purchases->count())
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="4" class="text-end">Total</td>
                            <td>{{ $purchases->sum(fn($p) => $p->items->count()) }}</td>
                            <td>{{ $purchases->sum(fn($p) => $p->items->sum('quantity')) }}</td>
                            <td>{{ number_format($purchases->sum('total_amount'), 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                @endif

            </table>
        </div>
    </div>

@stop
