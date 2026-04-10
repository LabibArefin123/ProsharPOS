@extends('adminlte::page')

@section('title', 'POS Terminal')

@section('content')

    <style>
        /* ===== PRODUCT GRID ===== */
        .product-card {
            border-radius: 12px;
            transition: 0.2s;
            cursor: pointer;
            height: 200px;
        }

        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* square feel */
        .product-img {
            height: 90px;
            object-fit: contain;
        }

        /* ===== FLOATING CART ===== */
        .cart-panel {
            position: fixed;
            top: 70px;
            right: 0;
            width: 350px;
            height: calc(100vh - 70px);
            background: #fff;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 999;
            display: flex;
            flex-direction: column;
        }

        .cart-body {
            flex: 1;
            overflow-y: auto;
        }

        .qty-input {
            width: 60px;
        }

        .product-meta {
            font-size: 12px;
            color: #888;
        }

        .modal-dialog-right {
            position: fixed;
            right: 0;
            margin: 0;
            height: 100%;
        }

        .modal-dialog-right .modal-content {
            height: 100%;
            border-radius: 0;
        }
    </style>


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
@endsection

@section('js')
    <script src="{{ asset('js/backend/pos_menu/index.js') }}"></script>
@endsection
