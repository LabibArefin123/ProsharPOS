<div class="row">

    {{-- ================================
            PRODUCT GRID (Same as create)
        ================================= --}}
    <div class="col-md-6 position-relative">
        <div class="card shadow mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">📦 Products</h5>
                <button class="btn btn-light btn-sm" id="toggle-filter"><i class="fas fa-filter"></i> Filter</button>
            </div>

            <div class="card-body position-relative">

                {{-- Search Filter Box --}}
                <div id="filter-box" class="card p-3 shadow position-absolute bg-white border"
                    style="top:10px; right:10px; display:none; z-index:1000; width:250px;">
                    <h6>Search Products</h6>
                    <input type="text" id="product-search" class="form-control" placeholder="Type name...">
                </div>

                <div class="row" id="product-grid"></div>

                <nav>
                    <ul class="pagination justify-content-center" id="product-pagination"></ul>
                </nav>
            </div>
        </div>
    </div>

    {{-- ================================
               EDIT CART
        ================================= --}}
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">🛒 Challan Cart (Edit)</h5>
            </div>

            <div class="card-body p-3">

                <table class="table table-sm table-bordered" id="challan-cart">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th width="70">Qty</th>
                            <th width="70">Bill</th>
                            <th width="70">Unbill</th>
                            <th width="70">FOC</th>
                            <th width="110">Warranty</th>
                            <th width="50">❌</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <div class="mt-2">
                    <strong>Total Qty:</strong> <span id="total-qty">0</span>
                </div>

                {{-- Store cart into JSON --}}
                <input type="hidden" name="items" id="challan-items">

                <button type="submit" class="btn btn-success btn-block mt-3">💾 Update Challan</button>
            </div>
        </div>
    </div>

</div>
<script>
    window.products = @json($products ?? []);
    window.warranties = @json($warranties ?? []);

    // If validation error
    window.oldItems = @json(old('items') ? json_decode(old('items'), true) : []);

    // Items from database (edit mode)
    window.editItems = @json($editItems ?? []);

    window.defaultProductImage = "{{ asset('images/default.jpg') }}";
</script>
<script src="{{ asset('js/backend/transaction_management/challan/edit_page/cart.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleFilterBtn = document.getElementById('toggle-filter');
        const filterBox = document.getElementById('filter-box');

        if (toggleFilterBtn && filterBox) {
            toggleFilterBtn.addEventListener('click', function(e) {
                e.preventDefault();
                filterBox.style.display =
                    (filterBox.style.display === 'block') ? 'none' : 'block';
            });

            document.addEventListener('click', function(e) {
                if (!filterBox.contains(e.target) && e.target !== toggleFilterBtn) {
                    filterBox.style.display = 'none';
                }
            });
        }
    });
</script>
