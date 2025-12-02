@extends('adminlte::page')

@section('title', 'Create Challan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark">🚚 Create Challan</h1>
        <a href="{{ route('challans.index') }}" class="btn btn-info btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Challans
        </a>
    </div>
@endsection

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

    {{-- ✅ Pass PHP collections into JSON for JS --}}
    @php
        $productsData = $products->map(
            fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'brand' => $p->brand->name ?? '',
                'category' => $p->category->name ?? '',
            ],
        );

        $customersData = $customers->map(
            fn($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'email' => $c->email,
                'phone' => $c->phone_number,
                'location' => $c->location,
            ],
        );
    @endphp

    <form action="{{ route('challans.store') }}" method="POST" id="challanForm">
        @csrf

        @include('transaction_management.challans.partial_create.part_1_customer')
        @include('transaction_management.challans.partial_create.part_2_filter')
       

        {{-- Product & Cart Section --}}
        <div class="row">
            {{-- Product Grid --}}
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <strong>📦 Select Products</strong>
                    </div>
                    <div class="card-body">
                        <div class="row flex-nowrap overflow-auto" id="product-grid">
                            @foreach ($products as $product)
                                <div class="col-md-3 mb-4">
                                    <div class="card product-card h-100 border" data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}" data-price="{{ $product->purchase_price }}"
                                        data-model="{{ $product->type_model }}"
                                        data-stock="{{ $product->stock_quantity }}">
                                        <img src="{{ asset($product->image) }}" class="card-img-top p-2"
                                            style="height:150px; object-fit: contain;" alt="{{ $product->name }}">
                                        <div class="card-body text-center">
                                            <h6 class="card-title text-truncate">{{ $product->name }}</h6>
                                            <p class="card-text small mb-2">
                                                <span class="text-muted">Model:</span> {{ $product->type_model }}<br>
                                                <span
                                                    class="text-muted">৳</span>{{ number_format($product->purchase_price, 2) }}<br>
                                                <span class="text-muted">Stock:</span> {{ $product->stock_quantity }}
                                            </p>
                                            <button type="button" class="btn btn-sm btn-primary add-to-cart w-100">
                                                ➕ Add
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cart --}}
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <strong>🛒 Cart</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered" id="cart-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th width="70">Qty</th>
                                    <th width="100">Warranty</th>
                                    <th width="50">❌</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <input type="hidden" name="products" id="products-json">

                        <div class="form-group mt-3">
                            <label>Payment Terms</label>
                            <select name="payment_term" class="form-control" required>
                                <option value="free">Free of Cost</option>
                                <option value="credit">Credit</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Challan Date</label>
                            <input type="date" name="challan_date" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="note" class="form-control" rows="2" placeholder="Write additional notes..."></textarea>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="bill">Bill</option>
                                <option value="unbill">Unbill</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success btn-block mt-3">
                            ✅ Create Challan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script>
        const warranties = @json($warranties);
        const productsData = @json($productsData);
        const customersData = @json($customersData);

        let cart = [];

        function renderCart() {
            let tbody = $('#cart-table tbody');
            tbody.empty();

            cart.forEach((item, index) => {
                let warrantyOptions = '<option value="">None</option>';
                warranties.forEach(w => {
                    const selected = item.warranty_id == w.id ? 'selected' : '';
                    warrantyOptions += `<option value="${w.id}" ${selected}>${w.name}</option>`;
                });

                tbody.append(`
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <button type="button" class="btn btn-xs btn-warning" onclick="updateQty(${index}, -1)">-</button>
                        ${item.quantity}
                        <button type="button" class="btn btn-xs btn-success" onclick="updateQty(${index}, 1)">+</button>
                    </td>
                    <td>
                        <select class="form-control form-control-sm" onchange="updateWarranty(${index}, this.value)">
                            ${warrantyOptions}
                        </select>
                    </td>
                    <td><button type="button" class="btn btn-xs btn-danger" onclick="removeItem(${index})">🗑️</button></td>
                </tr>
            `);
            });

            $('#products-json').val(JSON.stringify(cart));
        }

        function updateQty(index, change) {
            cart[index].quantity += change;
            if (cart[index].quantity < 1) cart[index].quantity = 1;
            renderCart();
        }

        function updateWarranty(index, value) {
            cart[index].warranty_id = value;
            renderCart();
        }

        function removeItem(index) {
            cart.splice(index, 1);
            renderCart();
        }

        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                const card = $(this).closest('.product-card');
                const id = card.data('id');
                const name = card.data('name');
                const price = card.data('price');
                const model = card.data('model');

                const existing = cart.find(p => p.product_id === id);
                if (existing) {
                    existing.quantity += 1;
                } else {
                    cart.push({
                        product_id: id,
                        name: name,
                        price: price,
                        model: model,
                        quantity: 1,
                        warranty_id: null
                    });
                }

                renderCart();
            });

            $('#filter-product').on('change', function() {
                const productId = $(this).val();
                const selectedProduct = productsData.find(p => p.id == productId);
                if (selectedProduct) {
                    $('#filter-brand').val(selectedProduct.brand);
                    $('#filter-category').val(selectedProduct.category);
                }
            });

            $('#customer_id').on('change', function() {
                const selectedId = $(this).val();
                const customer = customersData.find(c => c.id == selectedId);

                if (customer) {
                    $('#customer_email').val(customer.email);
                    $('#customer_phone').val(customer.phone);
                    $('#customer_location').val(customer.location);
                } else {
                    $('#customer_email').val('');
                    $('#customer_phone').val('');
                    $('#customer_location').val('');
                }
            });
        });
    </script>
@stop
