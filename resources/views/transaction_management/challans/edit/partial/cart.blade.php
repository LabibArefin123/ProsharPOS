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
    document.addEventListener("DOMContentLoaded", function() {

        /* ============================================================
           RESTORE ITEMS (EDIT MODE OR OLD FORM ERROR)
        ============================================================ */
        let oldItems = {!! json_encode(old('items') ? json_decode(old('items'), true) : []) !!};

        let cartItems =
            oldItems.length > 0 ?
            oldItems :
            {!! json_encode($editItems ?? []) !!};

        /* ============================================================
           PRODUCT LIST + PAGINATION
        ============================================================ */
        let products = @json($products);
        const perPage = 6;
        let currentPage = 1;

        const productGrid = document.getElementById("product-grid");
        const paginationEl = document.getElementById("product-pagination");
        const searchInput = document.getElementById("product-search");

        function renderProducts(page = 1, search = "") {
            let filtered = products.filter(p =>
                p.name.toLowerCase().includes(search.toLowerCase())
            );

            const start = (page - 1) * perPage;
            const list = filtered.slice(start, start + perPage);

            productGrid.innerHTML = "";

            list.forEach(p => {
                const image = p.image ?
                    `/uploads/images/product/${p.image}` :
                    "{{ asset('images/default.jpg') }}";

                const isSelected = cartItems.some(ci => ci.id == p.id);

                let div = document.createElement("div");
                div.className = "col-md-4 mb-3 d-flex justify-content-center";

                div.innerHTML = `
                <div class="text-center product-card p-2 ${isSelected ? "selected-product" : ""}"
                    data-id="${p.id}"
                    data-name="${p.name}"
                    data-image="${image}"
                    style="cursor:pointer;">

                    <img src="${image}"
                         class="mb-2 img-fluid product-img"
                         style="width:80px;height:80px;object-fit:cover;">
                    
                    <small class="d-block text-truncate" style="max-width:100px;">
                        ${p.name}
                    </small>

                    <button class="btn btn-outline-primary btn-sm add-btn mt-1">
                        ${isSelected ? "Added" : "Add"}
                    </button>
                </div>
            `;

                productGrid.appendChild(div);
            });

            renderPagination(page, filtered.length);
            bindProductEvents();
            bindZoomEvents();
        }

        function renderPagination(page, total) {
            const pages = Math.ceil(total / perPage);
            paginationEl.innerHTML = "";

            for (let i = 1; i <= pages; i++) {
                let li = document.createElement("li");
                li.className = `page-item ${i === page ? "active" : ""}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;

                li.onclick = e => {
                    e.preventDefault();
                    currentPage = i;
                    renderProducts(i, searchInput.value);
                };

                paginationEl.appendChild(li);
            }
        }

        searchInput.addEventListener("input", function() {
            renderProducts(1, this.value);
        });

        /* ============================================================
           CART HANDLER
        ============================================================ */
        const cartTable = document.querySelector("#challan-cart tbody");
        const totalQtyEl = document.getElementById("total-qty");
        const itemsInput = document.getElementById("challan-items");

        function bindProductEvents() {
            document.querySelectorAll(".add-btn").forEach(btn => {
                btn.onclick = function(e) {
                    e.stopPropagation();

                    let card = this.closest(".product-card");
                    let id = card.dataset.id;
                    let name = card.dataset.name;

                    let exists = cartItems.find(i => i.id == id);

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
                            warranty_period: 0
                        });
                    }

                    renderCart();
                    renderProducts(currentPage, searchInput.value);
                };
            });
        }

        function renderCart() {
            cartTable.innerHTML = "";
            let totalQty = 0;

            cartItems.forEach((item, index) => {
                totalQty += item.challan_total;

                cartTable.innerHTML += `
                <tr>
                    <td>${item.name}</td>

                    <td><input type="number" min="1" value="${item.challan_total}"
                        class="form-control form-control-sm cart-qty" data-index="${index}"></td>

                    <td><input type="number" min="0" value="${item.challan_bill}"
                        class="form-control form-control-sm bill-qty" data-index="${index}"></td>

                    <td><input type="number" min="0" value="${item.challan_unbill}"
                        class="form-control form-control-sm unbill-qty" data-index="${index}"></td>

                    <td><input type="number" min="0" value="${item.challan_foc}"
                        class="form-control form-control-sm foc-qty" data-index="${index}"></td>

                    <td>
                        <select class="form-control form-control-sm warranty-select" data-index="${index}">
                            ${loadWarrantyOptions()}
                        </select>
                    </td>

                    <td>
                        <button class="btn btn-danger btn-sm remove-btn" data-index="${index}">✕</button>
                    </td>
                </tr>
            `;
            });

            // SET WARRANTY VALUES
            cartItems.forEach((item, i) => {
                let sel = document.querySelector(`.warranty-select[data-index="${i}"]`);
                if (sel) sel.value = item.warranty_id ?? "";
            });

            totalQtyEl.innerText = totalQty;

            itemsInput.value = JSON.stringify(cartItems);
        }

        cartTable.addEventListener("input", function(e) {
            let i = e.target.dataset.index;

            if (e.target.classList.contains("cart-qty"))
                cartItems[i].challan_total = parseInt(e.target.value);

            if (e.target.classList.contains("bill-qty"))
                cartItems[i].challan_bill = parseInt(e.target.value);

            if (e.target.classList.contains("unbill-qty"))
                cartItems[i].challan_unbill = parseInt(e.target.value);

            if (e.target.classList.contains("foc-qty"))
                cartItems[i].challan_foc = parseInt(e.target.value);

            itemsInput.value = JSON.stringify(cartItems);
            renderCart();
        });

        cartTable.addEventListener("change", function(e) {
            if (!e.target.classList.contains("warranty-select")) return;

            let i = e.target.dataset.index;
            let opt = e.target.selectedOptions[0];

            cartItems[i].warranty_id = opt.value;
            cartItems[i].warranty_period = opt.dataset.days ?? 0;

            itemsInput.value = JSON.stringify(cartItems);
        });

        cartTable.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-btn")) {
                let index = e.target.dataset.index;
                let removed = cartItems[index].id;

                cartItems.splice(index, 1);

                renderCart();
                renderProducts(currentPage, searchInput.value);
            }
        });

        /* ============================================================
           WARRANTY OPTIONS
        ============================================================ */
        function loadWarrantyOptions() {
            let list = @json($warranties);
            let html = `<option value="">None</option>`;

            list.forEach(w => {
                html += `<option value="${w.id}" data-days="${w.day_count}">${w.name}</option>`;
            });

            return html;
        }

        /* ============================================================
           IMAGE ZOOM
        ============================================================ */
        function bindZoomEvents() {
            document.querySelectorAll(".product-img").forEach(img => {
                img.onclick = () => {
                    document.getElementById("zoomed-image").src = img.src;
                    document.getElementById("zoomed-name").innerText = img.closest(".product-card")
                        .dataset.name;
                    new bootstrap.Modal(document.getElementById("imageModal")).show();
                };
            });
        }

        /* ============================================================
           INITIAL LOAD
        ============================================================ */
        renderProducts();
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
