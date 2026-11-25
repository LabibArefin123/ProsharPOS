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
