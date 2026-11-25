<div class="pp-product-section">

    <div class="pp-product-section-header">

        <div>
            <h5>Available Products</h5>
            <p>Choose a product to add it to your cart</p>
        </div>

        <div class="pp-product-total">
            <i class="fas fa-boxes"></i>
            {{ $products->total() }} Products
        </div>

    </div>

    <div class="row pp-product-grid" id="product-grid">

        @forelse ($products as $product)
            @php
                $stock = $product->storage->stock_quantity ?? 0;

                $image = $product->storage->image_path
                    ? asset($product->storage->image_path)
                    : asset('images/default.jpg');
            @endphp

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6 product-item">

                <div class="pp-product-card add-product
                    {{ $stock <= 0 ? 'out-of-stock' : '' }}"
                    data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->sell_price }}"
                    data-stock="{{ $stock }}">

                    <div class="pp-product-image-wrapper">

                        <img src="{{ $image }}" class="pp-product-image" alt="{{ $product->name }}"
                            loading="lazy">

                        @if ($stock <= 0)
                            <span class="pp-stock-label unavailable">
                                Out of stock
                            </span>
                        @else
                            <span class="pp-stock-label available">
                                In stock
                            </span>
                        @endif

                    </div>

                    <div class="pp-product-info">

                        <h6 title="{{ $product->name }}">
                            {{ $product->name }}
                        </h6>

                        <span class="pp-product-sku">
                            SKU: {{ $product->sku ?? 'N/A' }}
                        </span>

                        <div class="pp-product-bottom">

                            <strong>
                                ৳ {{ number_format($product->sell_price, 2) }}
                            </strong>

                            <span class="{{ $stock > 0 ? 'stock-positive' : 'stock-negative' }}">
                                {{ $stock }}
                            </span>

                        </div>

                    </div>

                    <div class="pp-product-add">
                        <i class="fas fa-plus"></i>
                        Add to cart
                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">
                <div class="pp-empty-products">
                    <i class="fas fa-box-open"></i>
                    <h5>No products available</h5>
                    <p>There are currently no active products to display.</p>
                </div>
            </div>
        @endforelse

    </div>

    {{-- Laravel Pagination --}}
    @if ($products->hasPages())
        <div class="pp-product-pagination">
            <div class="pp-pagination-info">
                Showing {{ $products->firstItem() ?? 0 }}
                to {{ $products->lastItem() ?? 0 }}
                of {{ $products->total() }} products
            </div>

            {{ $products->links() }}
        </div>
    @endif

</div>
