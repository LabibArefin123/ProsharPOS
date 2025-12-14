@extends('adminlte::page')

@section('title', 'View Customer')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Customer Details</h3>
        <div>
            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Name:</label>
                    <input type="text" class="form-control" value="{{ $supplier->name }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Email:</label>
                    <input type="text" class="form-control" value="{{ $supplier->email }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Phone:</label>
                    <input type="text" class="form-control" value="{{ $supplier->phone_number }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Company Name:</label>
                    <input type="text" class="form-control" value="{{ $supplier->company_name }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Company Phone:</label>
                    <input type="text" class="form-control" value="{{ $supplier->company_number }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>License Number:</label>
                    <input type="text" class="form-control" value="{{ $supplier->license_number }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Location:</label>
                    <input type="text" class="form-control" value="{{ $supplier->location }}" readonly>
                </div>

            </div>
        </div>
    </div>
@stop
