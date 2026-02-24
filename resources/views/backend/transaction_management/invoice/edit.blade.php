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

    <style>
        .product-card {
            cursor: pointer;
            transition: 0.3s;
        }

        .product-card:hover {
            background-color: #d9f0ff;
            /* Sky blue hover */
        }

        .selected-product {
            background-color: #87ceeb !important;
            /* Sky blue for selected */
            border: 2px solid #1e90ff;
        }
    </style>
    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" id="invoiceForm" data-confirm="edit">
        @csrf
        @method('PUT')

        {{-- Customer Section --}}
        <div class="card mb-4 shadow">
            @include('backend.transaction_management.invoice.edit.partial.part_1')
            @include('backend.transaction_management.invoice.edit.partial.part_2')
            @include('backend.transaction_management.invoice.edit.partial.part_3')
        </div>

        {{-- Include Cart Section --}}
        @include('backend.transaction_management.invoice.edit.partial.cart')
    </form>
@stop
