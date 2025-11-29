@extends('adminlte::page')

@section('title', 'Create Invoice')

@section('content_header')
    <h1 class="text-dark font-weight-bold">Create Invoice</h1>
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

    @php
        $customersData = $customers->map(
            fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'email' => $c->email,
                'phone' => $c->phone_number,
                'location' => $c->location,
            ],
        );

    @endphp
    <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
        @csrf

        {{-- Customer Section --}}
        <div class="card mb-4 shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">👤 Customer Information</h5>
            </div>
            <div class="card-body row">
                <div class="form-group col-md-3">
                    <label for="customer_id">Customer Name</label>
                    <select name="customer_id" id="customer_id" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Email</label>
                    <input type="text" id="customer_email" class="form-control" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Phone</label>
                    <input type="text" id="customer_phone" class="form-control" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Location</label>
                    <input type="text" id="customer_location" class="form-control" readonly>
                </div>
            </div>
        </div>
        @include('transaction_management.invoice.partial.filter')
        @include('transaction_management.invoice.partial.cart')
        <style>
            .product-card {
                transition: all 0.2s ease;
            }

            .product-card:hover {
                transform: scale(1.02);
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
        </style>
    </form>
@stop
