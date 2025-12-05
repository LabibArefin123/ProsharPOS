@extends('adminlte::page')

@section('title', 'Create Invoice')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New Invoice</h3>
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

    <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm" data-confirm="create">
        @csrf

        {{-- Customer Section --}}
        <div class="card mb-4 shadow">
            <div class="card-body row">
                <div class="form-group col-md-3">
                    <label for="customer_id">Customer Name</label>
                    <select name="customer_id" id="customer_id" class="form-control">
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
            <div class="card-body row">
                <div class="form-group col-md-3">
                    <label for="branch_id">Branch Name</label>
                    <select name="branch_id" id="branch_id" class="form-control">
                        <option value="">Select Branch</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Branch Code</label>
                    <input type="text" id="branch_code" class="form-control" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Phone</label>
                    <input type="text" id="branch_phone" class="form-control" readonly>
                </div>
                <div class="form-group col-md-3">
                    <label>Address</label>
                    <input type="text" id="branch_location" class="form-control" readonly>
                </div>
            </div>
          
        </div>

        @include('transaction_management.invoice.create.partial.cart')

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

    {{-- --- JavaScript for Customer and Branch Details --- --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ---------------------
            // Customers Data
            // ---------------------
            const customers = @json($customers);
            const customerSelect = document.getElementById('customer_id');
            const customerEmail = document.getElementById('customer_email');
            const customerPhone = document.getElementById('customer_phone');
            const customerLocation = document.getElementById('customer_location');

            customerSelect.addEventListener('change', function() {
                const selected = customers.find(c => c.id == this.value);
                if (selected) {
                    customerEmail.value = selected.email;
                    customerPhone.value = selected.phone_number;
                    customerLocation.value = selected.location;
                } else {
                    customerEmail.value = '';
                    customerPhone.value = '';
                    customerLocation.value = '';
                }
            });

            // ---------------------
            // Branches Data
            // ---------------------
            const branches = @json($branches);
            const branchSelect = document.getElementById('branch_id');
            const branchCode = document.getElementById('branch_code');
            const branchPhone = document.getElementById('branch_phone');
            const branchLocation = document.getElementById('branch_location');

            branchSelect.addEventListener('change', function() {
                const selected = branches.find(b => b.id == this.value);
                if (selected) {
                    branchCode.value = selected.branch_code;
                    branchPhone.value = selected.phone;
                    branchLocation.value = selected.address;
                } else {
                    branchCode.value = '';
                    branchPhone.value = '';
                    branchLocation.value = '';
                }
            });

        });
    </script>
    {{-- --- End JS --- --}}
@stop
