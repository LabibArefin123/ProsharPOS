@extends('adminlte::page')

@section('title', 'Add Company')

@section('content_header')
    <h1>Add Company</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-md-4">
                        <label for="name">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="logo">Company Logo</label>
                        <input type="file" name="logo" class="form-control">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" name="contact_number" class="form-control"
                            value="{{ old('contact_number') }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="shipping_charge_inside">Shipping Charge (Inside)</label>
                        <input type="number" step="0.01" name="shipping_charge_inside" class="form-control"
                            value="{{ old('shipping_charge_inside') }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="shipping_charge_outside">Shipping Charge (Outside)</label>
                        <input type="number" step="0.01" name="shipping_charge_outside" class="form-control"
                            value="{{ old('shipping_charge_outside') }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="currency_symbol">Currency Symbol</label>
                        <input type="text" name="currency_symbol" class="form-control"
                            value="{{ old('currency_symbol') }}">
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
