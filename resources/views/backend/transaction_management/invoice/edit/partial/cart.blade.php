<div class="row">
    @php
        $savedPercent = $invoice->discount_type == 'percentage' ? $invoice->discount_percent : 0;
    @endphp

    {{-- Product Grid --}}
    <div class="col-md-6 position-relative">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">📦 Products</h5>
                <button class="btn btn-light btn-sm position-absolute end-0 top-50 translate-middle-y" id="toggle-filter">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>

            <div class="card-body position-relative">

                {{-- Filter Box --}}
                <div id="filter-box" class="card p-3 shadow position-absolute bg-white border"
                    style="top:10px; right:10px; display:none; z-index:1000; width:250px;">
                    <h6>Search Products</h6>
                    <input type="text" id="product-search" class="form-control" placeholder="Type name...">
                </div>

                {{-- Product Grid --}}
                <div class="row" id="product-grid"></div>

                {{-- Pagination --}}
                <nav>
                    <ul class="pagination justify-content-center" id="product-pagination"></ul>
                </nav>
            </div>
        </div>
    </div>

    {{-- Invoice Cart --}}
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">🛒 Update Invoice</h5>
            </div>

            <div class="card-body p-3">
                <table class="table table-sm table-bordered" id="invoice-cart">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Disc</th>
                            <th>Amt</th>
                            <th>Total</th>
                            <th>❌</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <div class="mb-2">
                    <strong>Subtotal:</strong> <span id="sub-total">0</span><br>
                    <strong>Subtotal (BDT):</strong> <span id="sub-total-bdt">0</span>
                </div>

                <div class="form-group mb-2">
                    <label>Discount Type</label>
                    <select id="discount-type" name="discount_type" class="form-control">
                        <option value="percentage" {{ $invoice->discount_type == 'percentage' ? 'selected' : '' }}>
                            Percentage</option>
                        <option value="flat" {{ $invoice->discount_type == 'flat' ? 'selected' : '' }}>Flat</option>
                    </select>
                </div>

                <div id="discount-section">
                    <div id="percent-section"
                        style="{{ $invoice->discount_type == 'percentage' ? '' : 'display:none' }}">
                        <label>Discount (%)</label>
                        <input type="number" name="discount_percent" id="discount-percent"
                            value="{{ $invoice->discount_percent }}" class="form-control">
                        <p class="mb-0">Discount Amount: <span id="discount-amount">0</span></p>
                        <p class="mb-0">Total After Discount: <span id="total-after-discount">0</span></p>
                        <p class="mb-0">Discount Amount ($): <span id="discount-amount-dollar">0.00</span></p>
                        <p class="mb-0">Total After Discount ($): <span id="total-after-discount-dollar">0.00</span>
                        </p>

                    </div>

                    <div id="flat-section" style="{{ $invoice->discount_type == 'flat' ? '' : 'display:none' }}">
                        <label>Flat Discount</label>
                        <input type="number" name="flat_discount" id="flat-discount"
                            value="{{ $invoice->flat_discount }}" class="form-control">
                        <p class="mt-2 mb-0">Total After Discount: <span id="flat-total">0</span></p>
                    </div>
                </div>

                {{-- Hidden JSON --}}
                <input type="hidden" name="items" id="invoice-items" value="{{ json_encode($invoice->items) }}">

                <button type="submit" class="btn btn-success btn-block">Update</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 text-center">
            <img id="zoomed-image" class="img-fluid mb-2" style="max-height:400px;">
            <p id="zoomed-name" class="fw-bold"></p>
        </div>
    </div>
</div>
<script>
    window.invoiceProducts = @json($products);
    window.invoiceItems = @json($invoice->items);
    window.invoiceExchangeRate = "{{ $invoice->exchange_rate ?? 122.2 }}";
    window.defaultProductImage = "{{ asset('images/default.jpg') }}";
</script>

<script src="{{ asset('js/backend/transaction_management/invoice/edit_page/cart.js') }}"></script>
