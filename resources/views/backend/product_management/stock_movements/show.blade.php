@extends('adminlte::page')

@section('title', 'Stock Movement Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">

        <h3 class="mb-0">Stock Movement Details</h3>

        <div>
            <a href="{{ route('stock_movements.edit', $movement->id) }}" class="btn btn-sm btn-primary">Edit</a>

            <a href="{{ route('stock_movements.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>

    </div>
@stop


@section('content')

    <div class="card">

        <div class="card-body">

            <div class="row">
                {{-- Product Name --}}
                <div class="form-group col-md-6">
                    <label>Product</label>
                    <input type="text" class="form-control" value="{{ $movement->storage->product->name ?? 'N/A' }}"
                        readonly>

                </div>
               
                <div class="form-group col-md-6">
                    <label>Barcode</label>
                    <div class="form-control d-flex align-items-center justify-content-center" style="height:60px">

                        @if ($movement->storage->barcode_path)
                            <img src="{{ asset($movement->storage->barcode_path) }}" style="max-height:40px">
                        @else
                            <span class="text-muted">No Barcode</span>
                        @endif

                    </div>

                </div>

                <div class="form-group col-md-6">
                    <label>Movement Type</label>
                    <input type="text" class="form-control" value="{{ $movement->movement_type }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label>Quantity</label>
                    <input type="text" class="form-control" value="{{ $movement->quantity }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label>Reference No</label>
                    <input type="text" class="form-control" value="{{ $movement->reference_no ?? 'N/A' }}" readonly>
                </div>



                {{-- Notes --}}
                <div class="form-group col-md-6">

                    <label>Notes</label>

                    <input type="text" class="form-control" value="{{ $movement->notes ?? 'N/A' }}" readonly>

                </div>

                {{-- Created By --}}
                <div class="form-group col-md-6">

                    <label>Created By</label>

                    <input type="text" class="form-control" value="{{ $movement->createdBy->name ?? 'N/A' }}" readonly>

                </div>



                {{-- Date --}}
                <div class="form-group col-md-6">

                    <label>Created Date</label>

                    <input type="text" class="form-control" value="{{ $movement->created_at->format('d M Y H:i') }}"
                        readonly>

                </div>



                {{-- Current Stock --}}
                <div class="form-group col-md-6">

                    <label>Current Stock</label>

                    <input type="text" class="form-control" value="{{ $movement->storage->stock_quantity }}" readonly>

                </div>



                {{-- Product Image --}}
                <div class="form-group col-md-6">

                    <label>Product Image</label>

                    <div class="form-control d-flex justify-content-center align-items-center" style="height:120px">

                        @if ($movement->storage->image_path)
                            <img src="{{ asset($movement->storage->image_path) }}" style="max-height:100px">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif

                    </div>

                </div>


            </div>

        </div>

    </div>

@stop
