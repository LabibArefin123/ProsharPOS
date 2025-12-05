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
                                data-model="{{ $product->type_model }}" data-stock="{{ $product->stock_quantity }}">
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
                    <select name="payment_term" class="form-control">
                        <option value="free">Free of Cost</option>
                        <option value="credit">Credit</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Challan Date</label>
                    <input type="date" name="challan_date" class="form-control">
                </div>

                <div class="form-group">
                    <label>Note</label>
                    <textarea name="note" class="form-control" rows="2" placeholder="Write additional notes..."></textarea>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">--Select Status--</option>
                        <option value="bill">Bill</option>
                        <option value="unbill">Unbill</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success btn-block mt-3">
                    ✅ Save
                </button>
            </div>
        </div>
    </div>
</div>

