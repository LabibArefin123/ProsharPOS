@extends('adminlte::page')

@section('title', 'Company Details')

@section('content_header')
    <h1>Company Details</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">

                <!-- Left Side: Logo -->
                <div class="col-md-4 text-center border-right">
                    <h4 class="mb-3">Company Logo</h4>
                    @if ($company->logo)
                        <img src="{{ asset('uploads/images/setting_management/company_profile/' . $company->logo) }}"
                            class="img-fluid rounded shadow" width="200" alt="Company Logo">
                    @else
                        <p class="text-muted">No Logo</p>
                    @endif
                </div>

                <!-- Right Side: Details -->
                <div class="col-md-8">
                    <h4 class="mb-3">Company Information</h4>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <strong>Name:</strong>
                            <p>{{ $company->name }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <strong>Contact Number:</strong>
                            <p>{{ $company->contact_number ?? 'N/A' }}</p>
                        </div>

                        <div class="form-group col-md-12">
                            <strong>Address:</strong>
                            <p>{{ $company->address ?? 'N/A' }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <strong>Shipping Charge (Inside):</strong>
                            <p>{{ $company->shipping_charge_inside ?? '0.00' }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <strong>Shipping Charge (Outside):</strong>
                            <p>{{ $company->shipping_charge_outside ?? '0.00' }}</p>
                        </div>

                        <div class="form-group col-md-6">
                            <strong>Currency Symbol:</strong>
                            <p>{{ $company->currency_symbol ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('companies.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
    </div>
@stop
