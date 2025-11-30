@extends('adminlte::page')

@section('title', 'View Customer')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Customer Details</h3>
        <div>
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-primary">Edit</a>
            <a href="{{ route('customers.index') }}" class="btn btn-sm btn-secondary">Go Back</a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Name:</label>
                    <input type="text" class="form-control" value="{{ $customer->name }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Email:</label>
                    <input type="text" class="form-control" value="{{ $customer->email }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Phone:</label>
                    <input type="text" class="form-control" value="{{ $customer->phone_number }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label>Location:</label>
                    <input type="text" class="form-control" value="{{ $customer->location }}" readonly>
                </div>

            </div>
        </div>
    </div>
@stop
