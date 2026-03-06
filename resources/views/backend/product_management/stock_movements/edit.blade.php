@extends('adminlte::page')

@section('title', 'Edit Stock Movement')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Stock Movement</h3>
        <a href="{{ route('stock_movements.index') }}"
            class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('stock_movements.update', $movement->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <label>Product Storage <span class="text-danger">*</span></label>
                        <select name="storage_id" class="form-control @error('storage_id') is-invalid @enderror">
                            <option value="">Select Storage</option>
                            @foreach ($storages as $storage)
                                <option value="{{ $storage->id }}"
                                    {{ old('storage_id', $movement->storage_id) == $storage->id ? 'selected' : '' }}>
                                    {{ $storage->product->name ?? 'Product' }}
                                    (Stock: {{ $storage->stock_quantity }})
                                </option>
                            @endforeach
                        </select>

                        @error('storage_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label>Movement Type <span class="text-danger">*</span></label>
                        <select name="movement_type" class="form-control @error('movement_type') is-invalid @enderror">
                            <option value="IN"
                                {{ old('movement_type', $movement->movement_type) == 'IN' ? 'selected' : '' }}>
                                Stock IN
                            </option>

                            <option value="OUT"
                                {{ old('movement_type', $movement->movement_type) == 'OUT' ? 'selected' : '' }}>
                                Stock OUT
                            </option>

                            <option value="ADJUSTMENT"
                                {{ old('movement_type', $movement->movement_type) == 'ADJUSTMENT' ? 'selected' : '' }}>
                                Adjustment
                            </option>
                        </select>

                        @error('movement_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label>Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" value="{{ old('quantity', $movement->quantity) }}"
                            class="form-control @error('quantity') is-invalid @enderror">

                        @error('quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label>Reference No</label>
                        <input type="text" name="reference_no"
                            value="{{ old('reference_no', $movement->reference_no) }}"
                            class="form-control @error('reference_no') is-invalid @enderror">

                        @error('reference_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-3">
                        <label>Note</label>
                        <input type="text" name="note" value="{{ old('note', $movement->note) }}"
                            class="form-control @error('note') is-invalid @enderror">

                        @error('note')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="text-end mt-3">
                    <button class="btn btn-primary ">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
