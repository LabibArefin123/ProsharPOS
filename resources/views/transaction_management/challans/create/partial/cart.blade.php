{{-- Main Section: Product + Cart --}}
<div class="row">

    {{-- Product Grid --}}
    <div class="col-md-6 position-relative">
        <div class="card shadow mb-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">📦 Products</h5>
                <button class="btn btn-light btn-sm" id="toggle-filter"><i class="fas fa-filter"></i> Filter</button>
            </div>

            <div class="card-body position-relative">

                {{-- Sticky Filter Box --}}
                <div id="filter-box" class="card p-3 shadow position-absolute bg-white border"
                    style="top:10px; right:10px; display:none; z-index:1000; width:250px;">
                    <h6>Search Products</h6>
                    <input type="text" id="product-search" class="form-control" placeholder="Type name...">
                </div>

                <div class="row" id="product-grid"></div>

                {{-- Pagination Controls --}}
                <nav>
                    <ul class="pagination justify-content-center" id="product-pagination"></ul>
                </nav>
            </div>
        </div>
    </div>

    {{-- CHALLAN CART --}}
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">🛒 Challan Cart</h5>
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

                <input type="hidden" name="items" id="challan-items">

                <button type="submit" class="btn btn-success btn-block mt-3">💾 Submit Challan</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal for Image Zoom --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 text-center">
            <img id="zoomed-image" src="" class="img-fluid mb-2" style="max-height:400px;">
            <p id="zoomed-name" class="fw-bold"></p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ============================================================
           RESTORE OLD DATA AFTER VALIDATION ERROR
        ============================================================ */
        let oldItems = {!! json_encode(json_decode(old('items'), true)) !!} ?? [];
        let cartItems = oldItems ?? [];
        // console.log("RESTORED OLD CART ITEMS:", cartItems);

        /* ============================================================
           PRODUCT LIST + PAGINATION
        ============================================================ */
        let products = @json($products);
        const perPage = 6;
        let currentPage = 1;

        const productGrid = document.getElementById('product-grid');
        const paginationEl = document.getElementById('product-pagination');
        const productSearch = document.getElementById('product-search');

        function renderProducts(page, filter = '') {
            let filtered = products.filter(p => p.name.toLowerCase().includes(filter.toLowerCase()));
            const start = (page - 1) * perPage;
            const paginated = filtered.slice(start, start + perPage);

            productGrid.innerHTML = '';

            paginated.forEach(product => {
                const image = product.image ?
                    `/uploads/images/product/${product.image}` :
                    "{{ asset('images/default.jpg') }}";

                const card = document.createElement('div');
                card.className = 'col-md-4 mb-3 d-flex justify-content-center';

                card.innerHTML = `
                        <div class="text-center product-card p-2"
                            data-id="${product.id}"
                            data-name="${product.name}"
                            data-image="${image}">
                            
                            <img src="${image}" class="mb-2 img-fluid product-img"
                                style="width:80px; height:80px; object-fit:cover; cursor:pointer;">

                            <small class="d-block text-truncate" style="max-width:100px;">
                                ${product.name}
                            </small>

                            <button type="button" class="btn btn-outline-primary btn-sm add-to-cart">
                                Add
                            </button>
                        </div>
                        `;

                productGrid.appendChild(card);
            });

            renderPagination(page, filtered.length);
            attachProductEvents();
            attachImageZoomEvents();
        }

        function renderPagination(page, total) {
            const totalPages = Math.ceil(total / perPage);
            paginationEl.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === page ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.onclick = e => {
                    e.preventDefault();
                    currentPage = i;
                    renderProducts(i, productSearch.value);
                };
                paginationEl.appendChild(li);
            }
        }

        productSearch.addEventListener('input', function() {
            currentPage = 1;
            renderProducts(1, this.value);
        });

        /* ============================================================
           CHALLAN CART
        ============================================================ */
        const cartTable = document.querySelector('#challan-cart tbody');
        const totalQtyEl = document.getElementById('total-qty');
        const itemsInput = document.getElementById('challan-items');

        function attachProductEvents() {
            document.querySelectorAll('.add-to-cart').forEach(btn => {
                btn.onclick = function() {
                    const card = this.closest('.product-card');
                    const id = card.dataset.id;
                    const name = card.dataset.name;

                    let exists = cartItems.find(item => item.id == id);

                    if (exists) {
                        exists.challan_total++;
                    } else {
                        cartItems.push({
                            id,
                            name,
                            challan_total: 1,
                            challan_bill: 1,
                            challan_unbill: 0,
                            challan_foc: 0,
                            warranty_id: null,
                        });
                    }

                    renderCart();
                };
            });
        }

        function getWarrantyOptions() {
            let options = '<option value="">None</option>';
            let warranties = @json($warranties);
            warranties.forEach(w => {
                options += `<option value="${w.id}" data-days="${w.day_count}">${w.name}</option>`;
            });
            return options;
        }


        function renderCart() {
            cartTable.innerHTML = '';
            let totalQty = 0;

            cartItems.forEach((item, index) => {
                totalQty += item.challan_total;

                cartTable.innerHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td><input type="number" min="1" value="${item.challan_total}" class="form-control form-control-sm cart-qty" data-index="${index}"></td>
                        <td><input type="number" min="0" value="${item.challan_bill}" class="form-control form-control-sm bill-qty" data-index="${index}"></td>
                        <td><input type="number" min="0" value="${item.challan_unbill}" class="form-control form-control-sm unbill-qty" data-index="${index}"></td>
                        <td><input type="number" min="0" value="${item.challan_foc}" class="form-control form-control-sm foc-qty" data-index="${index}"></td>
                       <td>
                            <select class="form-control form-control-sm warranty-select" data-index="${index}">
                                ${getWarrantyOptions()}
                            </select>
                        </td>

                        <td><button class="btn btn-danger btn-sm remove-btn" data-index="${index}">✕</button></td>
                    </tr>
                    `;
            });

            // Set selected warranty values
            cartItems.forEach((item, index) => {
                const select = document.querySelector(`.warranty-select[data-index="${index}"]`);
                if (select) select.value = String(item.warranty_id ?? "");

            });

            totalQtyEl.innerText = totalQty;

            // Save cart as FLAT array for backend
            itemsInput.value = JSON.stringify(cartItems);

            console.log("UPDATED CART ITEMS:", cartItems);
        }


        cartTable.addEventListener('input', function(e) {
            let index = e.target.dataset.index;
            if (!cartItems[index]) return;

            if (e.target.classList.contains('cart-qty')) cartItems[index].challan_total = parseInt(e
                .target
                .value);
            if (e.target.classList.contains('bill-qty')) cartItems[index].challan_bill = parseInt(e
                .target
                .value);
            if (e.target.classList.contains('unbill-qty')) cartItems[index].challan_unbill = parseInt(e
                .target.value);
            if (e.target.classList.contains('foc-qty')) cartItems[index].challan_foc = parseInt(e.target
                .value);

            renderCart();
        });

        /* ============================================================
           WARRANTY CHANGE — UPDATE HIDDEN FIELD ONLY
        ============================================================ */
        cartTable.addEventListener('change', function(e) {
            if (e.target.classList.contains('warranty-select')) {
                const index = e.target.dataset.index;
                const selected = e.target.selectedOptions[0];

                cartItems[index].warranty_id = selected.value || null;

                itemsInput.value = JSON.stringify(cartItems);
                console.log("WARRANTY UPDATED:", cartItems[index]);
            }
        });

        /* ============================================================
           REMOVE ITEM
        ============================================================ */
        cartTable.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-btn')) {
                const index = e.target.dataset.index;
                cartItems.splice(index, 1);
                renderCart();
            }
        });

        /* ============================================================
           IMAGE ZOOM
        ============================================================ */
        function attachImageZoomEvents() {
            document.querySelectorAll('.product-img').forEach(img => {
                img.onclick = () => {
                    document.getElementById('zoomed-image').src = img.src;
                    document.getElementById('zoomed-name').innerText =
                        img.closest('.product-card').dataset.name;
                    new bootstrap.Modal(document.getElementById('imageModal')).show();
                };
            });
        }

        /* ============================================================
           INITIAL LOAD
        ============================================================ */
        renderProducts(currentPage);
        renderCart();

    });
</script>
<script>
    const toggleFilterBtn = document.getElementById('toggle-filter');
    const filterBox = document.getElementById('filter-box');
    const productSearch = document.getElementById('product-search');
    toggleFilterBtn.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent any default action
        filterBox.style.display = (filterBox.style.display === 'block') ? 'none' : 'block';
    });

    document.addEventListener('click', function(e) {
        if (!filterBox.contains(e.target) && e.target !== toggleFilterBtn) {
            filterBox.style.display = 'none';
        }
    });
</script>
