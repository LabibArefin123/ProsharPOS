@extends('adminlte::page')

@section('title', 'Edit Supplier')

@section('content_header')
    <h1>Edit Supplier</h1>
@stop

@section('content')
<form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $supplier->name) }}" required>
            </div>
            <div class="form-group">
                <label>Company Name</label>
                <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $supplier->company_name) }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email) }}">
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $supplier->phone_number) }}">
            </div>
            <div class="form-group">
                <label>Company Number</label>
                <input type="text" name="company_number" class="form-control" value="{{ old('company_number', $supplier->company_number) }}">
            </div>
            <div class="form-group">
                <label>License Number</label>
                <input type="text" name="license_number" class="form-control" value="{{ old('license_number', $supplier->license_number) }}">
            </div>
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $supplier->location) }}">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</form>
@stop
