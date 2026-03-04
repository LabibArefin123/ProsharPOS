@extends('adminlte::page')

@section('title', 'Inspection Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Inspection Details</h3>
        <div>
            <a href="{{ route('product_inspections.edit', $inspection->id) }}" class="btn btn-sm btn-primary">Edit</a>

            <a href="{{ route('product_inspections.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">

                {{-- Product --}}
                <div class="form-group col-md-6">
                    <label>Product</label>
                    <input type="text" class="form-control" value="{{ $inspection->storage->product->name ?? 'N/A' }}"
                        readonly>
                </div>

                {{-- Inspection Type --}}
                <div class="form-group col-md-6">
                    <label>Inspection Type</label>
                    <input type="text" class="form-control" value="{{ ucfirst($inspection->inspection_type) }}" readonly>
                </div>

                {{-- Status --}}
                <div class="form-group col-md-6">
                    <label>Status</label>
                    <input type="text" class="form-control" value="{{ ucfirst($inspection->status) }}" readonly>
                </div>

                {{-- Checked Quantity --}}
                <div class="form-group col-md-6">
                    <label>Checked Quantity</label>
                    <input type="text" class="form-control" value="{{ $inspection->checked_quantity ?? 0 }}" readonly>
                </div>

                {{-- Defective Quantity --}}
                <div class="form-group col-md-6">
                    <label>Defective Quantity</label>
                    <input type="text" class="form-control" value="{{ $inspection->defective_quantity ?? 0 }}" readonly>
                </div>

                {{-- Inspector --}}
                <div class="form-group col-md-6">
                    <label>Inspected By</label>
                    <input type="text" class="form-control" value="{{ $inspection->user->name ?? 'N/A' }}" readonly>
                </div>

                {{-- Date --}}
                <div class="form-group col-md-6">
                    <label>Inspection Date</label>
                    <input type="text" class="form-control"
                        value="{{ \Carbon\Carbon::parse($inspection->created_at)->format('d M Y, h:i A') }}" readonly>
                </div>

                {{-- Notes --}}
                <div class="form-group col-md-12">
                    <label>Inspection Notes</label>
                    <textarea class="form-control" rows="3" readonly>{{ $inspection->notes }}</textarea>
                </div>

            </div>
        </div>
    </div>
@stop
