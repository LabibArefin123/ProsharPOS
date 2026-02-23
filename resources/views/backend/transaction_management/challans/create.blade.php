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
            @include('backend.transaction_management.challans.partial_create.part_1_supplier')
            @include('backend.transaction_management.challans.partial_create.part_2_branch')
            @include('backend.transaction_management.challans.partial_create.part_3_information')
        </div>

        @include('backend.transaction_management.challans.create.partial.cart')


    </form>
    {{-- --- JavaScript for supplier and Branch Details --- --}}
    <script>
        window.suppliers = @json($suppliers ?? []);
        window.branches = @json($branches ?? []);
    </script>
     <script src="{{ asset('js/backend/transaction_management/challan/create_page/supplier_branch_load.js') }}"></script> {{--  Supplier + Branch load  JS --}}
    {{-- --- End JS --- --}}
@stop
