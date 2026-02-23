document.addEventListener("DOMContentLoaded", function () {
    /* ============================================================
       RESTORE OLD DATA
    ============================================================ */
    let cartItems = window.oldItems || [];

    /* ============================================================
       PRODUCT LIST
    ============================================================ */
    let products = window.products || [];
    let warranties = window.warranties || [];
    const defaultImage = window.defaultProductImage || "";

    const perPage = 6;
    let currentPage = 1;

    const productGrid = document.getElementById("product-grid");
    const paginationEl = document.getElementById("product-pagination");
    const productSearch = document.getElementById("product-search");

    function renderProducts(page, filter = "") {
        let filtered = products.filter((p) =>
            p.name.toLowerCase().includes(filter.toLowerCase()),
        );

        const start = (page - 1) * perPage;
        const paginated = filtered.slice(start, start + perPage);

        productGrid.innerHTML = "";

        paginated.forEach((product) => {
            const image = product.image
                ? `/uploads/images/product/${product.image}`
                : defaultImage;

            const card = document.createElement("div");
            card.className = "col-md-4 mb-3 d-flex justify-content-center";

            card.innerHTML = `
                <div class="text-center product-card p-2"
                    data-id="${product.id}"
                    data-name="${product.name}"
                    data-image="${image}">
                    
                    <img src="${image}" 
                         class="mb-2 img-fluid product-img"
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

    function attachImageZoomEvents() {
        document.querySelectorAll(".product-img").forEach((img) => {
            img.addEventListener("click", function () {
                const card = this.closest(".product-card");
                document.getElementById("zoomed-image").src =
                    card.dataset.image;
                document.getElementById("zoomed-name").innerText =
                    card.dataset.name;

                $("#imageModal").modal("show"); // If using Bootstrap 4
            });
        });
    }

    function renderPagination(page, total) {
        const totalPages = Math.ceil(total / perPage);
        paginationEl.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = `page-item ${i === page ? "active" : ""}`;
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.onclick = (e) => {
                e.preventDefault();
                currentPage = i;
                renderProducts(i, productSearch.value);
            };
            paginationEl.appendChild(li);
        }
    }

    if (productSearch) {
        productSearch.addEventListener("input", function () {
            currentPage = 1;
            renderProducts(1, this.value);
        });
    }

    /* ============================================================
       WARRANTY OPTIONS
    ============================================================ */
    function getWarrantyOptions() {
        let options = '<option value="">None</option>';
        warranties.forEach((w) => {
            options += `<option value="${w.id}">${w.name}</option>`;
        });
        return options;
    }

    /* ============================================================
        ADD PRODUCT TO CART
    ============================================================ */
    function attachProductEvents() {
        document.querySelectorAll(".add-to-cart").forEach((button) => {
            button.addEventListener("click", function () {
                const card = this.closest(".product-card");

                const id = card.dataset.id;
                const name = card.dataset.name;
                const image = card.dataset.image;

                // Check if already exists
                const existing = cartItems.find((item) => item.id == id);

                if (existing) {
                    existing.challan_total += 1;
                } else {
                    cartItems.push({
                        id: id,
                        name: name,
                        image: image,
                        challan_total: 1,
                        challan_bill: 0,
                        challan_unbill: 0,
                        challan_foc: 0,
                        warranty_id: "",
                    });
                }

                renderCart();
            });
        });
    }

    /* ============================================================
       CART RENDER
    ============================================================ */
    const cartTable = document.querySelector("#challan-cart tbody");
    const totalQtyEl = document.getElementById("total-qty");
    const itemsInput = document.getElementById("challan-items");

    function renderCart() {
        if (!cartTable) return;

        cartTable.innerHTML = "";
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

        totalQtyEl.innerText = totalQty;
        itemsInput.value = JSON.stringify(cartItems);
    }

    /* ============================================================
     CART EVENTS
    ============================================================ */
    document.addEventListener("input", function (e) {
        const index = e.target.dataset.index;
        if (typeof index === "undefined") return;

        if (e.target.classList.contains("cart-qty")) {
            cartItems[index].challan_total = parseInt(e.target.value) || 1;
        }

        if (e.target.classList.contains("bill-qty")) {
            cartItems[index].challan_bill = parseInt(e.target.value) || 0;
        }

        if (e.target.classList.contains("unbill-qty")) {
            cartItems[index].challan_unbill = parseInt(e.target.value) || 0;
        }

        if (e.target.classList.contains("foc-qty")) {
            cartItems[index].challan_foc = parseInt(e.target.value) || 0;
        }

        renderCart();
    });

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-btn")) {
            const index = e.target.dataset.index;
            cartItems.splice(index, 1);
            renderCart();
        }
    });

    /* ============================================================
       INITIAL LOAD
    ============================================================ */
    renderProducts(currentPage);
    renderCart();

    setTimeout(() => {
        document.querySelectorAll(".warranty-select").forEach((select) => {
            const index = select.dataset.index;

            // restore selected value
            select.value = cartItems[index].warranty_id || "";

            // update cart when changed
            select.addEventListener("change", function () {
                cartItems[index].warranty_id = this.value;
            });
        });
    });
});
