@extends('adminlte::page')

@section('title', 'POS')

@section('content')

    <div class="row">

        {{-- Product List --}}
        <div class="col-md-8">

            <h4 class="mb-3">Products</h4>

            <div class="row">

                @foreach ($products as $product)
                    @php
                        $stock = $product->storage->stock_quantity ?? 0;
                    @endphp

                    <div class="col-md-3 mb-3">

                        <div class="card product-card text-center p-2">

                            <img src="{{ asset('uploads/images/product/' . $product->image) }}" class="img-fluid mb-2"
                                style="height:80px;object-fit:contain">

                            <strong>{{ $product->name }}</strong>

                            <div>৳ {{ $product->sell_price }}</div>

                            <small class="text-success">
                                Stock: {{ $stock }}
                            </small>

                            <button class="btn btn-primary btn-sm mt-2 add-product" data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}" data-price="{{ $product->sell_price }}"
                                data-stock="{{ $stock }}">
                                Add
                            </button>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>


        {{-- Cart --}}
        <div class="col-md-4">

            <h4>Cart</h4>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Product</th>
                        <th width="80">Qty</th>
                        <th width="80">Price</th>
                        <th width="80">Total</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id="pos-cart"></tbody>

            </table>

            <div class="text-right">

                <h4>Total: ৳ <span id="grand-total">0</span></h4>

            </div>

        </div>

    </div>

@endsection
@section('js')

    <script>
        let cart = {};

        $(document).on('click', '.add-product', function() {

            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = parseFloat($(this).data('price'));
            let stock = parseInt($(this).data('stock'));

            if (cart[id]) {
                if (cart[id].qty >= stock) {
                    alert("Stock limit reached!");
                    return;
                }

                cart[id].qty++;
            } else {
                cart[id] = {
                    name: name,
                    price: price,
                    qty: 1,
                    stock: stock
                };
            }

            renderCart();

        });


        function renderCart() {

            let html = '';
            let grandTotal = 0;

            $.each(cart, function(id, item) {

                let total = item.qty * item.price;

                grandTotal += total;

                html += `
        <tr>

            <td>${item.name}</td>

            <td>
                <input type="number"
                       min="1"
                       max="${item.stock}"
                       value="${item.qty}"
                       class="form-control qty-input"
                       data-id="${id}">
            </td>

            <td>${item.price}</td>

            <td>${total}</td>

            <td>
                <button class="btn btn-danger btn-sm remove-item"
                data-id="${id}">
                X
                </button>
            </td>

        </tr>
        `;
            });

            $('#pos-cart').html(html);

            $('#grand-total').text(grandTotal);

        }


        $(document).on('change', '.qty-input', function() {

            let id = $(this).data('id');
            let qty = parseInt($(this).val());

            if (qty <= 0) {
                delete cart[id];
            } else {
                cart[id].qty = qty;
            }

            renderCart();

        });


        $(document).on('click', '.remove-item', function() {

            let id = $(this).data('id');

            delete cart[id];

            renderCart();

        });
    </script>

@endsection
