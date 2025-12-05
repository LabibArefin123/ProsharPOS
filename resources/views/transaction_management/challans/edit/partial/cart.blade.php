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
    document.addEventListener('DOMContentLoaded', function() {

        // -------------------------------------------
        // 1. PRODUCT LOGIC (Same as create)
        // -------------------------------------------
        const toggleFilterBtn = document.getElementById('toggle-filter');
        const filterBox = document.getElementById('filter-box');
        const productSearch = document.getElementById('product-search');

        toggleFilterBtn.onclick = () => {
            filterBox.style.display = filterBox.style.display === 'block' ? 'none' : 'block';
        };

        document.addEventListener('click', function(e) {
            if (!filterBox.contains(e.target) && e.target !== toggleFilterBtn) {
                filterBox.style.display = 'none';
            }
        });

        let products = @json($products);
        const perPage = 6;
        let currentPage = 1;

        const productGrid = document.getElementById('product-grid');
        const paginationEl = document.getElementById('product-pagination');

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
                         style="width:80px; height:80px; object-fit:cover;">
                    <small class="d-block text-truncate" style="max-width:100px;">${product.name}</small>
                    <button type="button" class="btn btn-outline-primary btn-sm add-to-cart">Add</button>
                </div>
            `;

                productGrid.appendChild(card);
            });

            renderPagination(page, filtered.length);
            attachProductEvents();
        }

        function renderPagination(page, total) {
            const totalPages = Math.ceil(total / perPage);
            paginationEl.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === page ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.onclick = (e) => {
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

        // -------------------------------------------
        // 2. LOAD EXISTING CHALLAN ITEMS
        // -------------------------------------------
        const cartTable = document.querySelector('#challan-cart tbody');
        const totalQtyEl = document.getElementById('total-qty');
        const itemsInput = document.getElementById('challan-items');

        let cartItems = @json(
            $challan->items->map(function ($i) {
                return [
                    'id' => $i->product_id,
                    'name' => $i->product->name,
                    'qty' => $i->quantity,
                    'bill_qty' => $i->bill_qty,
                    'unbill_qty' => $i->unbill_qty,
                    'foc_qty' => $i->foc_qty,
                    'warranty_id' => $i->warranty_id,
                    'warranty_period' => $i->warranty_period,
                ];
            }));

        // -------------------------------------------
        // 3. ADD PRODUCT TO CART
        // -------------------------------------------
        function attachProductEvents() {
            document.querySelectorAll('.add-to-cart').forEach(btn => {
                btn.onclick = function() {
                    const card = this.closest('.product-card');
                    const id = card.dataset.id;
                    const name = card.dataset.name;

                    const exists = cartItems.find(item => item.id == id);

                    if (exists) exists.qty++;
                    else cartItems.push({
                        id,
                        name,
                        qty: 1,
                        bill_qty: 1,
                        unbill_qty: 0,
                        foc_qty: 0,
                        warranty_id: null,
                        warranty_period: 0
                    });

                    renderCart();
                };
            });
        }

        // -------------------------------------------
        // 4. RENDER CART UI
        // -------------------------------------------
        function renderCart() {
            cartTable.innerHTML = '';
            let totalQty = 0;

            cartItems.forEach((item, index) => {
                totalQty += item.qty;

                cartTable.innerHTML += `
                <tr>
                    <td>${item.name}</td>

                    <td><input type="number" min="1" value="${item.qty}"
                        class="form-control form-control-sm cart-qty" data-index="${index}"></td>

                    <td><input type="number" min="0" value="${item.bill_qty}"
                        class="form-control form-control-sm bill-qty" data-index="${index}"></td>

                    <td><input type="number" min="0" value="${item.unbill_qty}"
                        class="form-control form-control-sm unbill-qty" data-index="${index}"></td>

                    <td><input type="number" min="0" value="${item.foc_qty}"
                        class="form-control form-control-sm foc-qty" data-index="${index}"></td>

                    <td>
                        <select class="form-control form-control-sm warranty-select" data-index="${index}">
                            <option value="">None</option>
                            @foreach ($warranties as $w)
                                <option value="{{ $w->id }}" {{ $w->id == '${item.warranty_id}' ? 'selected' : '' }} data-days="{{ $w->days }}">
                                    {{ $w->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td><button class="btn btn-danger btn-sm remove-btn" data-index="${index}">✕</button></td>
                </tr>
            `;
            });

            totalQtyEl.innerText = totalQty;

            itemsInput.value = JSON.stringify({
                items: cartItems,
                challan_total: totalQty
            });
        }

        // -------------------------------------------
        // 5. CART INPUT EVENTS
        // -------------------------------------------
        cartTable.addEventListener('input', function(e) {
            const index = e.target.dataset.index;
            if (!cartItems[index]) return;

            if (e.target.classList.contains('cart-qty'))
                cartItems[index].qty = parseInt(e.target.value);

            if (e.target.classList.contains('bill-qty'))
                cartItems[index].bill_qty = parseInt(e.target.value);

            if (e.target.classList.contains('unbill-qty'))
                cartItems[index].unbill_qty = parseInt(e.target.value);

            if (e.target.classList.contains('foc-qty'))
                cartItems[index].foc_qty = parseInt(e.target.value);

            renderCart();
        });

        cartTable.addEventListener('change', function(e) {
            if (e.target.classList.contains('warranty-select')) {
                const index = e.target.dataset.index;
                const selected = e.target.selectedOptions[0];
                cartItems[index].warranty_id = selected.value;
                cartItems[index].warranty_period = selected.dataset.days ?? 0;
                renderCart();
            }
        });

        cartTable.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-btn')) {
                const index = e.target.dataset.index;
                cartItems.splice(index, 1);
                renderCart();
            }
        });

        // Initial render
        renderProducts(currentPage);
        renderCart();
    });
</script>
