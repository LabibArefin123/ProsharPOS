@extends('adminlte::page')

@section('title', 'Add Supplier')

@section('content_header')
    <h1>Add Supplier</h1>
@stop

@section('content')
<form action="{{ route('suppliers.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Company Name</label>
                <input type="text" name="company_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone_number" class="form-control">
            </div>
            <div class="form-group">
                <label>Company Number</label>
                <input type="text" name="company_number" class="form-control">
            </div>
            <div class="form-group">
                <label>License Number</label>
                <input type="text" name="license_number" class="form-control">
            </div>
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" class="form-control">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</form>
@stop
