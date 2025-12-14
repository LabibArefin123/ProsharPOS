@extends('adminlte::page')

@section('title', 'Edit Supplier')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Supplier</h3>
        <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" data-confirm="edit">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $supplier->name) }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Company Name</label>
                            <input type="text" name="company_name"
                                class="form-control @error('company_name') is-invalid @enderror"
                                value="{{ old('company_name', $supplier->company_name) }}">
                            @error('company_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $supplier->email) }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Phone Number</label>
                            <input type="text" name="phone_number"
                                class="form-control  @error('phone_number') is-invalid @enderror"
                                value="{{ old('phone_number', $supplier->phone_number) }}">
                            @error('phone_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Company Number</label>
                            <input type="text" name="company_number"
                                class="form-control @error('company_number') is-invalid @enderror"
                                value="{{ old('company_number', $supplier->company_number) }}">
                            @error('company_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>License Number</label>
                            <input type="text" name="license_number"
                                class="form-control @error('license_number') is-invalid @enderror"
                                value="{{ old('license_number', $supplier->license_number) }}">
                            @error('license_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label>Location</label>
                            <input type="text" name="location"
                                class="form-control @error('location') is-invalid @enderror"
                                value="{{ old('location', $supplier->location) }}">
                            @error('location')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
@stop
