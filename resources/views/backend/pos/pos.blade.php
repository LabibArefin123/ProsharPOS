@extends('adminlte::page')

@section('title', 'POS Terminal')

@section('content')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/backend/pos_menu/index.css') }}">
    <div class="container-fluid">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h3 class="font-weight-bold">🧾 POS Terminal</h3>

            <div class="d-flex align-items-center">

                <input type="text" id="search-product" class="form-control mr-3" style="width:250px"
                    placeholder="🔍 Search product...">

                {{-- 🛒 CART BUTTON --}}
                <div style="position: relative;">
                    <button class="btn btn-dark" id="open-cart">
                        🛒 Cart
                    </button>

                    {{-- 🔴 BADGE --}}
                    <span id="cart-count"
                        style="
                    position:absolute;
                    top:-8px;
                    right:-8px;
                    background:red;
                    color:white;
                    border-radius:50%;
                    padding:2px 6px;
                    font-size:12px;
                    display:none;
                  ">
                        0
                    </span>
                </div>

            </div>

        </div>


        <div class="row">

            {{-- ================= PRODUCTS ================= --}}
            <div class="col-md-12">

                <div class="row">

                    @foreach ($products as $product)
                        @php
                            $stock = $product->storage->stock_quantity ?? 0;
                        @endphp

                        <div class="col-md-2 mb-3 product-item">

                            <div class="card product-card p-2 text-center add-product" data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}" data-price="{{ $product->sell_price }}"
                                data-stock="{{ $stock }}">

                                <img src="{{ $product->storage->image_path ? asset($product->storage->image_path) : asset('images/default.jpg') }}"
                                    class="product-img mb-1">

                                <strong class="text-truncate d-block">
                                    {{ $product->name }}
                                </strong>

                                <div class="product-meta">
                                    SKU: {{ $product->sku ?? 'N/A' }}
                                </div>

                                <div class="text-primary font-weight-bold">
                                    ৳ {{ number_format($product->sell_price, 2) }}
                                </div>

                                <small class="{{ $stock > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $stock > 0 ? "In Stock ($stock)" : 'Out of Stock' }}
                                </small>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>

    </div>
    @include('backend.pos.modal.cart')
    @include('backend.pos.modal.invoice')
@endsection

@section('js')
    <script src="{{ asset('js/backend/pos_menu/index.js') }}"></script>
@endsection
