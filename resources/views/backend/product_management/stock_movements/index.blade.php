@extends('adminlte::page')

@section('title', 'Stock Movements')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Stock Movements</h1>

        <div class="d-flex gap-2">
            <a href="{{ route('stock_movements.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Movement
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
                        <th style="width:50px;">SL</th>
                        <th>Product</th>
                        <th>Barcode</th>
                        <th>Movement Type</th>
                        <th>Quantity</th>
                        <th>Reference</th>
                        <th>Created By</th>
                        <th>Date</th>
                        <th style="width:150px;">Action</th>
                    </tr>
                </thead>

                <tbody class="text-center">

                    @forelse($movements as $movement)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $movement->storage->product->name ?? 'N/A' }}
                            </td>
                            <td>
                                @if ($movement->storage->barcode_path)
                                    <img src="{{ asset($movement->storage->barcode_path) }}" style="height:40px">
                                @endif

                            </td>
                            <td>
                                @if ($movement->movement_type == 'IN')
                                    <span class="badge badge-success">IN</span>
                                @elseif($movement->movement_type == 'OUT')
                                    <span class="badge badge-danger">OUT</span>
                                @else
                                    <span class="badge badge-warning">ADJUSTMENT</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $movement->quantity }}
                                </span>
                            </td>
                            <td>{{ $movement->reference_no ?? 'N/A' }}</td>
                            <td>{{ $movement->createdBy->name ?? 'N/A' }}</td>
                            <td> {{ \Carbon\Carbon::parse($movement->created_at)->format('d M Y') }}</td>
                            <td class="d-flex justify-content-center gap-1">
                                
                                <a href="{{ route('stock_movements.show', $movement->id) }}"
                                    class="btn btn-sm btn-outline-info" title="View">

                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('stock_movements.edit', $movement->id) }}"
                                    class="btn btn-sm btn-outline-primary" title="Edit">

                                    <i class="fas fa-edit"></i>

                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('stock_movements.destroy', $movement->id) }}" method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="triggerDeleteModal('{{ route('stock_movements.destroy', $movement->id) }}')">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No stock movements found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@stop
