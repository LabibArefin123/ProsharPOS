@extends('adminlte::page')

@section('title', 'Challan Daily Report')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Challan Daily Report</h1>
    </div>
@stop

@section('content')

    {{-- 🔍 Filter Section --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('report.challan.daily') }}">
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
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>

                        <a href="{{ route('report.challan.daily.pdf', request()->query()) }}" class="btn btn-danger"
                            target="_blank">
                            <i class="fas fa-file-pdf"></i> PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- 📊 Report Table --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover text-nowrap" id="dataTables">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Challan No</th>
                        <th>Challan Date</th>
                        <th>Supplier</th>
                        <th>Branch</th>
                        <th>Total Qty</th>
                        <th>Bill Qty</th>
                        <th>Unbill Qty</th>
                        <th>FOC Qty</th>
                        <th>Challan Type</th>
                        <th>Reference</th>
                        <th>Note</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($challans as $challan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $challan->challan_no }}</td>
                            <td>{{ \Carbon\Carbon::parse($challan->challan_date)->format('d F Y') }}</td>
                            <td>{{ $challan->supplier?->name ?? 'N/A' }}</td>
                            <td>{{ $challan->branch?->name ?? 'N/A' }}</td>

                            <td>{{ $challan->citems->sum('challan_total') }}</td>
                            <td>{{ $challan->citems->sum('challan_bill') }}</td>
                            <td>{{ $challan->citems->sum('challan_unbill') }}</td>
                            <td>{{ $challan->citems->sum('challan_foc') }}</td>

                            <td>
                                <span class="badge bg-info">
                                    {{ $challan->challan_type }}
                                </span>
                            </td>

                            <td>{{ $challan->challan_ref }}</td>
                            <td>{{ $challan->note }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted">
                                No challan records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                {{-- 🔢 Summary Footer --}}
                @if ($challans->count())
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="5" class="text-end">Total</td>
                            <td>{{ $challans->sum(fn($c) => $c->citems->sum('challan_total')) }}</td>
                            <td>{{ $challans->sum(fn($c) => $c->citems->sum('challan_bill')) }}</td>
                            <td>{{ $challans->sum(fn($c) => $c->citems->sum('challan_unbill')) }}</td>
                            <td>{{ $challans->sum(fn($c) => $c->citems->sum('challan_foc')) }}</td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                @endif

            </table>
        </div>
    </div>

@stop
