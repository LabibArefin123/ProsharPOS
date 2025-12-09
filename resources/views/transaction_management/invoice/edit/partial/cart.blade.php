<div class="row">
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
                        <p class="mt-2 mb-0">Discount Amount: <span id="discount-amount">0</span></p>
                        <p>Total After Discount: <span id="total-after-discount">0</span></p>
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

{{-- ========================= --}}
{{-- JS SECTION --}}
{{-- ========================= --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // All Products from Controller
        let products = @json($products);

        // ===== PRELOAD CART FROM DATABASE =====
        // PRELOAD CART FROM DATABASE (ensure proper keys for JS)
        let cartItems = (@json($invoice->items) || []).map(i => ({
            id: i.id || i.product_id, // product ID
            name: i.name || i.product_name, // product name
            price: parseFloat(i.price),
            qty: parseFloat(i.qty || 1),
            discount: parseFloat(i.discount || 0)
        }));


        // ===== SAME LOGIC FROM CREATE PAGE =====
        const perPage = 6;
        let currentPage = 1;

        const productGrid = document.getElementById("product-grid");
        const paginationEl = document.getElementById("product-pagination");
        const productSearch = document.getElementById("product-search");
        const toggleFilter = document.getElementById("toggle-filter");
        const filterBox = document.getElementById("filter-box");

        const cartTable = document.querySelector("#invoice-cart tbody");
        const itemsInput = document.getElementById("invoice-items");

        const discountType = document.getElementById("discount-type");
        const discountPercent = document.getElementById("discount-percent");
        const flatDiscount = document.getElementById("flat-discount");

        const percentSection = document.getElementById("percent-section");
        const flatSection = document.getElementById("flat-section");

        const discountAmountDisplay = document.getElementById("discount-amount");
        const totalAfterDiscountDisplay = document.getElementById("total-after-discount");
        const flatTotalDisplay = document.getElementById("flat-total");

        const subTotalDisplay = document.getElementById("sub-total");
        const subTotalBDTDisplay = document.getElementById("sub-total-bdt");

        toggleFilter.onclick = () => {
            filterBox.style.display = filterBox.style.display === "none" ? "block" : "none";
        };

        document.addEventListener("click", (e) => {
            if (!filterBox.contains(e.target) && e.target !== toggleFilter) {
                filterBox.style.display = "none";
            }
        });

        productSearch.addEventListener("input", function() {
            currentPage = 1;
            renderProducts(currentPage, this.value);
        });

        function renderProducts(page, filter = "") {
            let filtered = products.filter(p => p.name.toLowerCase().includes(filter.toLowerCase()));

            let start = (page - 1) * perPage;
            let end = start + perPage;

            let paginated = filtered.slice(start, end);

            productGrid.innerHTML = "";

            paginated.forEach(product => {
                const image = product.image ? `/uploads/images/product/${product.image}` :
                    "{{ asset('images/default.jpg') }}";

                // Check if product is already in cart
                const isSelected = cartItems.find(i => i.id == product.id) ? 'selected-product' : '';

                const card = document.createElement("div");
                card.className = "col-md-4 mb-3 d-flex justify-content-center";
                card.innerHTML = `
            <div class="text-center product-card p-2 ${isSelected}"
                data-id="${product.id}"
                data-name="${product.name}"
                data-price="${product.purchase_price}"
                data-image="${image}">
                <img src="${image}" class="mb-2 img-fluid product-img" style="width:80px;height:80px;object-fit:cover;cursor:pointer;"> 
                <small class="d-block text-truncate" style="max-width:100px;">${product.name}</small>
                <p class="mb-1">৳${product.purchase_price}</p>
                <button type="button" class="btn btn-outline-primary btn-sm add-to-invoice">Add</button>
            </div>
        `;
                productGrid.appendChild(card);
            });

            renderPagination(page, filtered.length);
            attachAddEvents();
            attachZoom();
        }

        function renderPagination(page, totalFiltered) {
            const totalPages = Math.ceil(totalFiltered / perPage);
            paginationEl.innerHTML = "";

            for (let i = 1; i <= totalPages; i++) {
                let li = document.createElement("li");
                li.className = "page-item " + (i === page ? "active" : "");
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;

                li.onclick = (e) => {
                    e.preventDefault();
                    currentPage = i;
                    renderProducts(currentPage, productSearch.value);
                };

                paginationEl.appendChild(li);
            }
        }

        function attachAddEvents() {
            document.querySelectorAll(".add-to-invoice").forEach(btn => {
                btn.onclick = () => {
                    const card = btn.closest(".product-card");
                    const id = card.dataset.id;
                    const name = card.dataset.name;
                    const price = parseFloat(card.dataset.price);

                    const exist = cartItems.find(i => i.id == id);

                    if (exist) {
                        exist.qty++;
                    } else {
                        cartItems.push({
                            id,
                            name,
                            price,
                            qty: 1,
                            discount: 0
                        });
                    }

                    // Update card selection highlight
                    document.querySelectorAll('.product-card').forEach(c => {
                        c.classList.remove('selected-product');
                    });
                    cartItems.forEach(ci => {
                        const cardEl = document.querySelector(
                            `.product-card[data-id="${ci.id}"]`);
                        if (cardEl) cardEl.classList.add('selected-product');
                    });

                    renderCart();
                };
            });
        }


        function attachZoom() {
            document.querySelectorAll(".product-img").forEach(img => {
                img.onclick = () => {
                    document.getElementById("zoomed-image").src = img.src;
                    document.getElementById("zoomed-name").innerText = img.closest(".product-card")
                        .dataset.name;
                    new bootstrap.Modal(document.getElementById("imageModal")).show();
                };
            });
        }

        function renderCart(internal = false) {

            cartTable.innerHTML = "";
            let subTotal = 0;

            cartItems.forEach((item, index) => {
                let amount = (item.qty * item.price) - item.discount;
                subTotal += amount;

                const row = document.createElement("tr");
                row.innerHTML = `
                <td>${item.name}</td>
                <td>৳${item.price}</td>
                <td><input type="number" min="1" value="${item.qty}" class="form-control form-control-sm qty-input" data-index="${index}"></td>
                <td><input type="number" min="0" value="${item.discount}" class="form-control form-control-sm disc-input" data-index="${index}"></td>
                <td>৳${(item.qty * item.price).toFixed(2)}</td>
                <td>৳${amount.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm remove-btn" data-index="${index}">✕</button></td>
            `;
                cartTable.appendChild(row);
            });

            subTotalDisplay.innerText = subTotal.toFixed(2);
            subTotalBDTDisplay.innerText = subTotal.toFixed(2);

            if (!internal) updateDiscounts();

            let discountValue = 0;
            let totalAfterDiscount = subTotal;

            if (discountType.value === "percentage") {
                discountValue = subTotal * ((parseFloat(discountPercent.value) || 0) / 100);
                totalAfterDiscount = subTotal - discountValue;
            } else {
                discountValue = parseFloat(flatDiscount.value) || 0;
                totalAfterDiscount = subTotal - discountValue;
            }

            itemsInput.value = JSON.stringify({
                items: cartItems,
                sub_total: subTotal,
                discount_value: discountValue,
                total: totalAfterDiscount
            });
        }

        cartTable.addEventListener("input", function(e) {
            const index = e.target.dataset.index;

            if (e.target.classList.contains("qty-input"))
                cartItems[index].qty = parseFloat(e.target.value);

            if (e.target.classList.contains("disc-input"))
                cartItems[index].discount = parseFloat(e.target.value);

            renderCart();
        });

        cartTable.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-btn")) {
                const removed = cartItems.splice(e.target.dataset.index, 1);

                // Remove highlight from product grid
                removed.forEach(r => {
                    const cardEl = document.querySelector(`.product-card[data-id="${r.id}"]`);
                    if (cardEl) cardEl.classList.remove('selected-product');
                });

                renderCart();
            }
        });

        discountType.onchange = () => {
            if (discountType.value === "percentage") {
                percentSection.style.display = "block";
                flatSection.style.display = "none";
            } else {
                percentSection.style.display = "none";
                flatSection.style.display = "block";
            }

            updateDiscounts();
        };

        discountPercent.oninput = updateDiscounts;
        flatDiscount.oninput = updateDiscounts;

        function updateDiscounts() {
            let subTotal = cartItems.reduce((sum, item) => sum + (item.qty * item.price - item.discount), 0);

            if (discountType.value === "percentage") {
                let percent = parseFloat(discountPercent.value) || 0;
                let amount = subTotal * (percent / 100);

                discountAmountDisplay.innerText = amount.toFixed(2);
                totalAfterDiscountDisplay.innerText = (subTotal - amount).toFixed(2);

            } else {
                let flat = parseFloat(flatDiscount.value) || 0;
                flatTotalDisplay.innerText = (subTotal - flat).toFixed(2);
            }

            renderCart(true);
        }

        // INITIAL LOAD
        renderProducts(currentPage);
        renderCart();

    });
</script>
