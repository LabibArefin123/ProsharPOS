@extends('adminlte::page')

@section('title', 'Edit Challan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Challan</h3>
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

    <style>
        /* Sky-blue highlight for selected products */
        .selected-product {
            background-color: #cfe8ff !important;
            border: 2px solid #0d6efd !important;
            border-radius: 6px;
        }
    </style>

    <form action="{{ route('challans.update', $challan->id) }}" method="POST" id="challanForm">
        @csrf
        @method('PUT')

        <div class="card mb-4 shadow">
            @include('backend.transaction_management.challans.partial_edit.part_1_supplier')
            @include('backend.transaction_management.challans.partial_edit.part_2_branch')
            @include('backend.transaction_management.challans.partial_edit.part_3_information')
        </div>
        @include('backend.transaction_management.challans.edit.partial.cart')
    </form>
    {{-- --- JavaScript for supplier and Branch Details --- --}}
    <script>
        window.suppliers = @json($suppliers ?? []);
        window.branches = @json($branches ?? []);
    </script>
    <script src="{{ asset('js/backend/transaction_management/challan/edit_page/supplier_branch_load.js') }}"></script> {{--  Supplier + Branch load  JS --}}
@stop
