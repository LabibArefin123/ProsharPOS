@extends('adminlte::page')

@section('title', 'Warranty Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Warranty Details</h3>
        <div>
            <a href="{{ route('warranties.edit', $warranty->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('warranties.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-lg">
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
                </div>
            </div>
        </div>
    </div>
@stop
