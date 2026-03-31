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
    {{-- CART MODAL --}}
    <div class="modal fade" id="cartModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-right">
            <div class="modal-content">

                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">🛒 Cart</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <table class="table">
                        <tbody id="pos-cart"></tbody>
                    </table>

                    <div class="text-right">
                        <h4>Total: ৳ <span id="grand-total">0</span></h4>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" id="checkout-btn">
                        💳 Checkout
                    </button>
                </div>

            </div>
        </div>
    </div>

    
@endsection

@section('js')
    <script>
        let cart = {};

        // 👉 Add Product
        $(document).on('click', '.add-product', function() {

            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = parseFloat($(this).data('price'));
            let stock = parseInt($(this).data('stock'));

            if (stock <= 0) {
                toastr.warning("Out of stock!");
                return;
            }

            if (cart[id]) {
                if (cart[id].qty >= stock) {
                    toastr.error("Stock limit reached!");
                    return;
                }
                cart[id].qty++;
            } else {
                cart[id] = {
                    name,
                    price,
                    qty: 1,
                    stock
                };
            }

            updateCartCount();
            renderCart();
        });


        // 🔴 UPDATE BADGE COUNT
        function updateCartCount() {

            let count = 0;

            $.each(cart, function(id, item) {
                count += item.qty;
            });

            if (count > 0) {
                $('#cart-count').text(count).show();
            } else {
                $('#cart-count').hide();
            }
        }


        // 🛒 OPEN MODAL
        $('#open-cart').click(function() {
            $('#cartModal').modal('show');
        });


        // 👉 Render Cart
        function renderCart() {

            let html = '';
            let total = 0;

            $.each(cart, function(id, item) {

                let sub = item.qty * item.price;
                total += sub;

                html += `
        <tr>
            <td>
                <strong>${item.name}</strong><br>
                ৳ ${item.price}
            </td>

            <td>
                <input type="number"
                       class="form-control form-control-sm qty-input"
                       value="${item.qty}"
                       min="1"
                       max="${item.stock}"
                       data-id="${id}">
            </td>

            <td>৳ ${sub.toFixed(2)}</td>

            <td>
                <button class="btn btn-danger btn-sm remove-item"
                        data-id="${id}">
                    ✕
                </button>
            </td>
        </tr>`;
            });

            $('#pos-cart').html(html);
            $('#grand-total').text(total.toFixed(2));
        }


        // 👉 Quantity change
        $(document).on('change', '.qty-input', function() {

            let id = $(this).data('id');
            let qty = parseInt($(this).val());

            if (qty <= 0) {
                delete cart[id];
            } else {
                cart[id].qty = qty;
            }

            updateCartCount();
            renderCart();
        });


        // 👉 Remove item
        $(document).on('click', '.remove-item', function() {

            delete cart[$(this).data('id')];

            updateCartCount();
            renderCart();
        });


        // 🔍 SEARCH
        $('#search-product').on('keyup', function() {

            let value = $(this).val().toLowerCase();

            $('.product-item').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });

        });


        // 💳 Checkout
        $('#checkout-btn').click(function() {

            if (Object.keys(cart).length === 0) {
                toastr.warning("Cart is empty!");
                return;
            }

            console.log(cart);
            alert("Next: Payment system 💳");

        });
    </script>
@endsection
