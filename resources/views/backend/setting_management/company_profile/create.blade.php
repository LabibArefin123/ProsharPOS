@extends('adminlte::page')

@section('title', 'Add Company')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New Company</h3>
        <a href="{{ route('companies.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data"
                    data-confirm="create">
                    @csrf
                    <div class="row">

                        <div class="form-group col-md-6">
                            <label for="name">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="logo">Company Logo</label>
                            <input type="file" name="logo" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="contact_number">Contact Number</label> <span class="text-danger">*</span>
                            <input type="text" name="contact_number"
                                class="form-control @error('contact_number') is-invalid @enderror"
                                value="{{ old('contact_number') }}">
                            @error('contact_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="address">Address</label> <span class="text-danger">*</span>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                value="{{ old('address') }}">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="shipping_charge_inside">Shipping Charge (Inside)</label> <span
                                class="text-danger">*</span>
                            <input type="number" step="0.01" name="shipping_charge_inside"
                                class="form-control @error('shipping_charge_inside') is-invalid @enderror"
                                value="{{ old('shipping_charge_inside') }}">
                            @error('shipping_charge_inside')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="shipping_charge_outside">Shipping Charge (Outside)</label> <span
                                class="text-danger">*</span>
                            <input type="number" step="0.01" name="shipping_charge_outside"
                                class="form-control @error('shipping_charge_outside') is-invalid @enderror"
                                value="{{ old('shipping_charge_outside') }}">
                            @error('shipping_charge_outside')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="currency_symbol">Currency Symbol</label> <span class="text-danger">*</span>
                            <input type="text" name="currency_symbol"
                                class="form-control @error('currency_symbol') is-invalid @enderror"
                                value="{{ old('currency_symbol') }}">
                            @error('currency_symbol')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
