@extends('adminlte::page')

@section('title', 'Edit Company')

@section('content_header')
    <h1>Edit Company</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="name">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}"
                            required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="logo">Company Logo</label>
                        <input type="file" name="logo" class="form-control">
                        @if ($company->logo)
                            <div class="mt-2">
                                <img src="{{ asset('uploads/images/setting_management/company_profile/' . $company->logo) }}"
                                    width="80">
                            </div>
                        @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control"
                            value="{{ old('contact_number', $company->contact_number) }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $company->address) }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="shipping_charge_inside">Shipping Charge (Inside)</label>
                        <input type="number" step="0.01" name="shipping_charge_inside" class="form-control"
                            value="{{ old('shipping_charge_inside', $company->shipping_charge_inside) }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="shipping_charge_outside">Shipping Charge (Outside)</label>
                        <input type="number" step="0.01" name="shipping_charge_outside" class="form-control"
                            value="{{ old('shipping_charge_outside', $company->shipping_charge_outside) }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="currency_symbol">Currency Symbol</label>
                        <input type="text" name="currency_symbol" class="form-control"
                            value="{{ old('currency_symbol', $company->currency_symbol) }}">
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
