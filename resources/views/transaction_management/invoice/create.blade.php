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
            @include('transaction_management.invoice.create.partial.part_1')
            @include('transaction_management.invoice.create.partial.part_2')
            @include('transaction_management.invoice.create.partial.part_3')
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
                    customerPhone.value = selected.phone;
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
