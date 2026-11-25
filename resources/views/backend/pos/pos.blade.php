@extends('adminlte::page')

@section('title', 'POS Terminal')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/pos_page/pos_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/pos_page/pos_header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/pos_page/pos_products.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/pos_page/pos_cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/pos_page/pos_modals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend/pos_page/pos_resp.css') }}">
@stop

@section('content')
    <div class="container-fluid pp-pos-container">
        @include('backend.pos.partials.pos_header')
        <div class="row">

            {{-- PRODUCT SECTION --}}
            <div class="col-xl-9 col-lg-8">
                @include('backend.pos.partials.product_grid')
            </div>

            {{-- CART SUMMARY --}}
            <div class="col-xl-3 col-lg-4">
                @include('backend.pos.partials.cart_summary')
            </div>

        </div>
    </div>

    @include('backend.pos.modal.cart')
    @include('backend.pos.modal.invoice')
@stop

@section('js')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('js/backend/pos_menu/pos_cart.js') }}"></script>
    <script src="{{ asset('js/backend/pos_menu/pos_products.js') }}"></script>
    <script src="{{ asset('js/backend/pos_menu/pos_checkout.js') }}"></script>
@stop
