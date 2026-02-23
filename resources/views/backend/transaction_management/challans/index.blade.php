@extends('adminlte::page')

@section('title', 'Challan List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Challan List</h1>
        <a href="{{ route('challans.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Create New
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Challan No</th>
                        <th>Item Name</th>
                        <th>Challan Date</th>
                        <th>Challan Expiry Date</th>
                        <th>Supplier</th>
                        <th>Branch</th>
                        <th>Total Qty</th>
                        <th>Bill Qty</th>
                        <th>Unbill Qty</th>
                        <th>FOC Qty</th>
                        <th>Challan Reference</th>
                        <th>Out Reference</th>
                        <th>Note</th>
                        <th width="110">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($challans as $challan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $challan->challan_no }}</td>
                            <td>
                                @forelse ($challan->citems as $item)
                                    <div>{{ $item->product?->name ?? 'N/A' }}</div>
                                @empty
                                    <span class="text-muted">No items</span>
                                @endforelse
                            </td>

                            <td>{{ \Carbon\Carbon::parse($challan->challan_date)->format('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($challan->valid_until)->format('d F Y') }}</td>
                            <td>{{ $challan->supplier?->name ?? 'N/A' }}</td>
                            <td>{{ $challan->branch?->name ?? 'N/A' }}</td>
                            <td>{{ $challan->citems?->sum('challan_total') ?? 0 }}</td>
                            <td>{{ $challan->citems?->sum('challan_bill') ?? 0 }}</td>
                            <td>{{ $challan->citems?->sum('challan_unbill') ?? 0 }}</td>
                            <td>{{ $challan->citems?->sum('challan_foc') ?? 0 }}</td>
                            <td>{{ $challan->challan_ref }}</td>
                            <td>{{ $challan->out_ref }}</td>
                            <td>{{ $challan->note }}</td>
                            <td>
                                <a href="{{ route('challans.show', $challan->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('challans.edit', $challan->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="triggerDeleteModal('{{ route('challans.destroy', $challan->id) }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No challans found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
@stop
