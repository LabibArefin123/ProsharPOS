@extends('adminlte::page')

@section('title', 'View Manufacturer')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Manufacturer Details</h3>
        <div>
            <a href="{{ route('manufacturers.edit', $manufacturer->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('manufacturers.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Name:</label>
                    <input type="text" class="form-control" value="{{ $manufacturer->name }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Email:</label>
                    <input type="text" class="form-control" value="{{ $manufacturer->email }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Phone:</label>
                    <input type="text" class="form-control" value="{{ $manufacturer->phone }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Country:</label>
                    <input type="text" class="form-control" value="{{ $manufacturer->country }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Location:</label>
                    <input type="text" class="form-control" value="{{ $manufacturer->location }}" readonly>
                </div>
                <div class="form-group col-md-6">

                    <label>Status:</label>
                    @if ($manufacturer->is_active == 1)
                        <input class="form-control" value="Active"></input>
                    @else
                        <input class="form-control" value="Inactive">Inactive</input>
                    @endif

                </div>
            </div>
        </div>
    </div>
@stop
