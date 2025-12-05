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
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover text-nowrap" id="dataTables">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Challan No</th>
                            <th>Date</th>
                            <th>Supplier</th>
                            <th>Branch</th>
                            <th>Total Qty</th>
                            <th>Bill Qty</th>
                            <th>Unbill Qty</th>
                            <th>FOC Qty</th>
                            <th>Status</th>
                            <th width="110">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($challans as $challan)
                            <tr>
                                <td>{{ $challan->id }}</td>
                                <td>{{ $challan->challan_no }}</td>
                                <td>{{ $challan->challan_date }}</td>

                                <td>{{ $challan->supplier?->name ?? 'N/A' }}</td>
                                <td>{{ $challan->branch?->name ?? 'N/A' }}</td>

                                <td>{{ $challan->challan_total }}</td>
                                <td>{{ $challan->challan_bill }}</td>
                                <td>{{ $challan->challan_unbill }}</td>
                                <td>{{ $challan->challan_foc }}</td>

                                <td>
                                    <span
                                        class="badge 
                                    @if ($challan->status == 'delivered') bg-success
                                    @elseif($challan->status == 'pending') bg-warning
                                    @elseif($challan->status == 'returned') bg-danger
                                    @else bg-secondary @endif">
                                        {{ ucfirst($challan->status ?? 'N/A') }}
                                    </span>
                                </td>

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
    </div>
@stop
