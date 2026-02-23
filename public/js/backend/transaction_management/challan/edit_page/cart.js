document.addEventListener("DOMContentLoaded", function () {
    /* ============================================================
       LOAD DATA FROM BLADE
    ============================================================ */
    let products = window.products || [];
    let warranties = window.warranties || [];
    let oldItems = window.oldItems || [];
    let editItems = window.editItems || [];
    let defaultImage = window.defaultProductImage || "";

    // If validation error -> use oldItems
    // Else -> use editItems
    let cartItems = oldItems.length > 0 ? oldItems : editItems;

    /* ============================================================
       DOM ELEMENTS
    ============================================================ */
    const productGrid = document.getElementById("product-grid");
    const paginationEl = document.getElementById("product-pagination");
    const searchInput = document.getElementById("product-search");
    const cartTable = document.querySelector("#challan-cart tbody");
    const totalQtyEl = document.getElementById("total-qty");
    const itemsInput = document.getElementById("challan-items");

    const perPage = 6;
    let currentPage = 1;

    /* ============================================================
       RENDER PRODUCTS + PAGINATION
    ============================================================ */
    function renderProducts(page = 1, search = "") {
        let filtered = products.filter((p) =>
            p.name.toLowerCase().includes(search.toLowerCase()),
        );

        const start = (page - 1) * perPage;
        const list = filtered.slice(start, start + perPage);

        productGrid.innerHTML = "";

        list.forEach((p) => {
            const image = p.image
                ? `/uploads/images/product/${p.image}`
                : defaultImage;
            const isSelected = cartItems.some((ci) => ci.id == p.id);

            let div = document.createElement("div");
            div.className = "col-md-4 mb-3 d-flex justify-content-center";

            div.innerHTML = `
                <div class="text-center product-card p-2 ${isSelected ? "selected-product" : ""}"
                     data-id="${p.id}"
                     data-name="${p.name}"
                     data-image="${image}"
                     style="cursor:pointer;">

                    <img src="${image}" class="mb-2 img-fluid product-img"
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
            li.onclick = (e) => {
                e.preventDefault();
                currentPage = i;
                renderProducts(i, searchInput.value);
            };
            paginationEl.appendChild(li);
        }
    }

    if (searchInput) {
        searchInput.addEventListener("input", () =>
            renderProducts(1, searchInput.value),
        );
    }

    /* ============================================================
       BIND PRODUCT EVENTS (ADD TO CART)
    ============================================================ */
    function bindProductEvents() {
        document.querySelectorAll(".add-btn").forEach((btn) => {
            btn.onclick = (e) => {
                e.stopPropagation();

                let card = btn.closest(".product-card");
                let id = card.dataset.id;
                let name = card.dataset.name;

                let exists = cartItems.find((i) => i.id == id);

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
                        warranty_period: 0,
                    });
                }

                renderCart();
                renderProducts(currentPage, searchInput.value);
            };
        });
    }

    /* ============================================================
       RENDER CART
    ============================================================ */
    function renderCart() {
        cartTable.innerHTML = "";
        let totalQty = 0;

        cartItems.forEach((item, index) => {
            totalQty += parseInt(item.challan_total || 0);

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
                        <select class="form-control form-control-sm warranty-select"
                                data-index="${index}">
                            ${loadWarrantyOptions(item.warranty_id)}
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm remove-btn" data-index="${index}">✕</button>
                    </td>
                </tr>
            `;
        });

        totalQtyEl.innerText = totalQty;
        itemsInput.value = JSON.stringify(cartItems);

        // Attach change event for newly added warranty selects
        cartTable.querySelectorAll(".warranty-select").forEach((sel, idx) => {
            sel.onchange = () => {
                let opt = sel.selectedOptions[0];
                cartItems[idx].warranty_id = opt.value;
                cartItems[idx].warranty_period = opt.dataset.days || 0;
                itemsInput.value = JSON.stringify(cartItems);
            };
        });
    }

    /* ============================================================
       CART INPUT EVENTS
    ============================================================ */
    cartTable.addEventListener("input", (e) => {
        let i = e.target.dataset.index;
        if (i === undefined) return;

        if (e.target.classList.contains("cart-qty"))
            cartItems[i].challan_total = parseInt(e.target.value) || 0;
        if (e.target.classList.contains("bill-qty"))
            cartItems[i].challan_bill = parseInt(e.target.value) || 0;
        if (e.target.classList.contains("unbill-qty"))
            cartItems[i].challan_unbill = parseInt(e.target.value) || 0;
        if (e.target.classList.contains("foc-qty"))
            cartItems[i].challan_foc = parseInt(e.target.value) || 0;

        renderCart();
    });

    cartTable.addEventListener("click", (e) => {
        if (!e.target.classList.contains("remove-btn")) return;
        let index = e.target.dataset.index;
        cartItems.splice(index, 1);
        renderCart();
        renderProducts(currentPage, searchInput.value);
    });

    /* ============================================================
       LOAD WARRANTY OPTIONS
    ============================================================ */
    function loadWarrantyOptions(selectedId = null) {
        let html = `<option value="">None</option>`;
        warranties.forEach((w) => {
            html += `<option value="${w.id}" data-days="${w.day_count}" ${selectedId == w.id ? "selected" : ""}>${w.name}</option>`;
        });
        return html;
    }

    /* ============================================================
       IMAGE ZOOM
    ============================================================ */
    function bindZoomEvents() {
        document.querySelectorAll(".product-img").forEach((img) => {
            img.onclick = () => {
                document.getElementById("zoomed-image").src = img.src;
                document.getElementById("zoomed-name").innerText =
                    img.closest(".product-card").dataset.name;

                new bootstrap.Modal(
                    document.getElementById("imageModal"),
                ).show();
            };
        });
    }

    /* ============================================================
       INITIAL LOAD
    ============================================================ */
    renderProducts();
    renderCart();
});
