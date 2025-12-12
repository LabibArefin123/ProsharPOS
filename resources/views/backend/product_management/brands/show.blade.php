@extends('adminlte::page')

@section('title', 'View Brand')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Brand Details</h3>
        <div>
            <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('brands.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Brand Name:</label>
                    <input type="text" class="form-control" value="{{ $brand->name }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label>Category:</label>
                    <input type="text" class="form-control" value="{{ $brand->category->name ?? '-' }}" readonly>
                </div>

                <div class="form-group col-md-12">
                    <label>Description:</label>
                    <textarea class="form-control" rows="3" readonly>{{ $brand->description }}</textarea>
                </div>
            </div>
        </div>
    </div>
@stop
