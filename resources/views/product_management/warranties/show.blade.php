@extends('adminlte::page')

@section('title', 'Warranty Details')

@section('content_header')
    <h1 class="m-0 text-dark">Warranty Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Warranty Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Warranty Name</label>
                    <input type="text" class="form-control" value="{{ $warranty->name }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Duration Type</label>
                    <input type="text" class="form-control" value="{{ ucfirst($warranty->duration_type) }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Day Count</label>
                    <input type="text" class="form-control" value="{{ $warranty->day_count }}" readonly>
                </div>
                <div class="form-group col-md-12">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" readonly>{{ $warranty->description }}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>Created By</label>
                    <input type="text" class="form-control" value="{{ $warranty->createdBy->name ?? 'N/A' }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Created At</label>
                    <input type="text" class="form-control" value="{{ $warranty->created_at->format('d M, Y h:i A') }}"
                        readonly>
                </div>
                @if ($warranty->updated_by)
                    <div class="form-group col-md-6">
                        <label>Updated By</label>
                        <input type="text" class="form-control" value="{{ $warranty->updatedBy->name ?? 'N/A' }}"
                            readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Updated At</label>
                        <input type="text" class="form-control"
                            value="{{ $warranty->updated_at->format('d M, Y h:i A') }}" readonly>
                    </div>
                @endif
            </div>

            <div class="mt-3 d-flex justify-content-between">
                <a href="{{ route('warranties.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <a href="{{ route('warranties.edit', $warranty->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Warranty
                </a>
            </div>
        </div>
    </div>
@stop
