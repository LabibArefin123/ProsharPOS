@extends('adminlte::page')

@section('title', 'Create Product Inspection')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Create Product Inspection</h3>
        <a href="{{ route('product_inspections.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="bi bi-arrow-left" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
        <div class="card shadow-sm">
            <div class="card-body">

                <form action="{{ route('product_inspections.store') }}" method="POST" data-confirm="create">
                    @csrf

                    <div class="row">

                        {{-- Storage Selection --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select Storage</label>
                            <select name="storage_id" class="form-control" >
                                <option value="">-- Select Product Storage --</option>
                                @foreach ($storages as $storage)
                                    <option value="{{ $storage->id }}">
                                        {{ $storage->product->name ?? 'Product' }}
                                        (Stock: {{ $storage->stock_quantity }})
                                    </option>
                                @endforeach
                            </select>
                            @error('storage_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Inspection Type --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Inspection Type</label>
                            <select name="inspection_type" class="form-control" >
                                <option value="">-- Select Type --</option>
                                <option value="purchase">Purchase</option>
                                <option value="routine">Routine</option>
                                <option value="return">Return</option>
                            </select>
                            @error('inspection_type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" >
                                <option value="">-- Select Status --</option>
                                <option value="passed">Passed</option>
                                <option value="partial">Partial</option>
                                <option value="failed">Failed</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Checked Quantity --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Checked Quantity</label>
                            <input type="number" name="checked_quantity" class="form-control" min="0">
                            @error('checked_quantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Defective Quantity --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Defective Quantity</label>
                            <input type="number" name="defective_quantity" class="form-control" min="0">
                            @error('defective_quantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Inspection Notes</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                            @error('notes')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="text-end">
                        <a href="{{ route('product_inspections.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Inspection
                        </button>
                    </div>
                </form>
            </div>
        </div>
@stop
