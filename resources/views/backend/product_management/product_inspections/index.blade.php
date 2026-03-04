@extends('adminlte::page')

@section('title', 'Product Inspection List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Product Inspection List</h1>
        <div>
            <a href="{{ route('product_inspections.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Create New
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover text-nowrap" id="dataTables">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th style="width: 50px;">SL</th>
                        <th>Product</th>
                        <th>Inspection Type</th>
                        <th>Status</th>
                        <th>Checked Qty</th>
                        <th>Defective Qty</th>
                        <th>Inspector</th>
                        <th>Date</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody class="text-center">

                    @forelse($inspections as $inspection)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            {{-- Product Name --}}
                            <td>
                                {{ $inspection->storage->product->name ?? 'N/A' }}
                            </td>

                            {{-- Inspection Type --}}
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ ucfirst($inspection->inspection_type) }}
                                </span>
                            </td>

                            {{-- Status Badge --}}
                            <td>
                                @if ($inspection->status == 'passed')
                                    <span class="badge bg-success">Passed</span>
                                @elseif($inspection->status == 'partial')
                                    <span class="badge bg-warning text-dark">Partial</span>
                                @else
                                    <span class="badge bg-danger">Failed</span>
                                @endif
                            </td>

                            {{-- Quantities --}}
                            <td>{{ $inspection->checked_quantity ?? 0 }}</td>
                            <td>{{ $inspection->defective_quantity ?? 0 }}</td>

                            {{-- Inspector --}}
                            <td>{{ $inspection->user->name ?? 'N/A' }}</td>

                            {{-- Date --}}
                            <td>{{ $inspection->created_at->format('d M Y') }}</td>

                            {{-- Actions --}}
                            <td class="d-flex justify-content-center gap-1">

                                {{-- Show --}}
                                <a href="{{ route('product_inspections.show', $inspection->id) }}"
                                    class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('product_inspections.edit', $inspection->id) }}"
                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('product_inspections.destroy', $inspection->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="triggerDeleteModal('{{ route('product_inspections.destroy', $inspection->id) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No inspections found.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@stop
