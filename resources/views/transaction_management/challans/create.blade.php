@extends('adminlte::page')

@section('title', 'Create Challan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New Challan</h3>
        <a href="{{ route('challans.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
            <strong>Whoops!</strong> Something went wrong:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('challans.store') }}" method="POST" id="challanForm">
        @csrf




        <div class="card mb-4 shadow">
            @include('transaction_management.challans.partial_create.part_1_supplier')
            @include('transaction_management.challans.partial_create.part_2_branch')
            @include('transaction_management.challans.partial_create.part_3_information')
        </div>

        @include('transaction_management.challans.create.partial.cart')


    </form>
    {{-- --- JavaScript for supplier and Branch Details --- --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* -------------------------
               SUPPLIERS DATA
            -------------------------- */
            const suppliers = @json($suppliers);
            const supplierSelect = document.getElementById('supplier_id');
            const supplierEmail = document.getElementById('supplier_email');
            const supplierPhone = document.getElementById('supplier_phone');
            const supplierLocation = document.getElementById('supplier_location');

            function loadSupplierInfo(id) {
                const selected = suppliers.find(s => s.id == id);
                if (selected) {
                    supplierEmail.value = selected.email ?? '';
                    supplierPhone.value = selected.phone_number ?? '';
                    supplierLocation.value = selected.location ?? '';
                }
            }

            supplierSelect.addEventListener('change', function() {
                loadSupplierInfo(this.value);
            });

            // Auto-load old/edit value on page load
            if (supplierSelect.value) {
                loadSupplierInfo(supplierSelect.value);
            }

            /* -------------------------
               BRANCHES DATA
            -------------------------- */
            const branches = @json($branches);
            const branchSelect = document.getElementById('branch_id');
            const branchCode = document.getElementById('branch_code');
            const branchPhone = document.getElementById('branch_phone');
            const branchLocation = document.getElementById('branch_location');

            function loadBranchInfo(id) {
                const selected = branches.find(b => b.id == id);
                if (selected) {
                    branchCode.value = selected.branch_code ?? '';
                    branchPhone.value = selected.phone ?? '';
                    branchLocation.value = selected.address ?? '';
                }
            }

            branchSelect.addEventListener('change', function() {
                loadBranchInfo(this.value);
            });

            // Auto-load old/edit value on page load
            if (branchSelect.value) {
                loadBranchInfo(branchSelect.value);
            }

        });
    </script>
    {{-- --- End JS --- --}}
@stop
