@extends('adminlte::page')

@section('title', 'Edit Invoice')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Invoice </h3>
        <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" id="invoiceForm">
        @csrf
        @method('PUT')

        {{-- Customer Section --}}
        <div class="card mb-4 shadow">

            <div class="card-body row">
                <div class="form-group col-md-3">
                    <label for="customer">Customer Name</label>
                    <select name="customer_id" id="customer_id" class="form-control">
                        <option value="">Select Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Email</label>
                    <input type="text" id="customer_email" class="form-control"
                        value="{{ $invoice->customer->email ?? '' }}" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Phone</label>
                    <input type="text" id="customer_phone" class="form-control"
                        value="{{ $invoice->customer->phone_number ?? '' }}" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Address</label>
                    <input type="text" id="customer_location" class="form-control"
                        value="{{ $invoice->customer->location ?? '' }}" readonly>
                </div>
            </div>
        </div>
        <div class="card mb-4 shadow">
            <div class="card-body row">
                <div class="form-group col-md-3">
                    <label for="branch_id">Branch Name</label>
                    <select name="branch_id" id="branch_id" class="form-control">
                        <option value="">Select Branch</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $invoice->branch_id == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Branch Code</label>
                    <input type="text" id="branch_code" class="form-control"
                        value="{{ $invoice->branch->branch_code ?? '' }}" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Phone</label>
                    <input type="text" id="branch_phone" class="form-control"
                        value="{{ $invoice->branch->phone ?? '' }}" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Location</label>
                    <input type="text" id="branch_address" class="form-control"
                        value="{{ $invoice->branch->address ?? '' }}" readonly>
                </div>

            </div>
        </div>
        <div class="card mb-4 shadow">
            <div class="card-body row">

                <div class="col-md-4 form-group">
                    <label><strong>Invoice ID</strong></label>
                    <input type="text" name="invoice_id" class="form-control @error('invoice_id') is-invalid @enderror"
                        value="{{ old('invoice_id', $invoice->invoice_id) }}">
                    @error('invoice_id')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="col-md-4 form-group">
                    <label><strong>Invoice Date</strong></label>
                    <input type="date" name="invoice_date"
                        class="form-control @error('invoice_date') is-invalid @enderror"
                        value="{{ old('invoice_date', $invoice->invoice_date) }}">
                    @error('invoice_date')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="col-md-4 form-group">
                    <label>Status</label> <span class="text-danger">*</span>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="">
                            Select Status
                        </option>
                        <option value="1" {{ old('status', $invoice->status) == '1' ? 'selected' : '' }}>
                            Paid
                        </option>
                        <option value="0" {{ old('status', $invoice->status) == '0' ? 'selected' : '' }}>
                            Pending
                        </option>
                    </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Include Cart Section --}}
        @include('transaction_management.invoice.edit.partial.cart')



    @stop
