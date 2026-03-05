document.addEventListener("DOMContentLoaded", function () {
    // ===== DATA FROM BLADE =====
    let products = window.invoiceProducts || [];
    let cartItems = (window.invoiceItems || []).map((i) => ({
        id: i.id || i.product_id,
        name: i.name || i.product_name,
        price: parseFloat(i.price),
        qty: parseFloat(i.qty || 1),
        discount: parseFloat(i.discount || 0),
    }));

    const exchangeRate = parseFloat(window.invoiceExchangeRate || 122.2);

    // ===== SETTINGS =====
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
    const totalAfterDiscountDisplay = document.getElementById(
        "total-after-discount",
    );
    const flatTotalDisplay = document.getElementById("flat-total");

    const subTotalDisplay = document.getElementById("sub-total");
    const subTotalBDTDisplay = document.getElementById("sub-total-bdt");

    const discountAmountDollar = document.getElementById(
        "discount-amount-dollar",
    );
    const totalAfterDiscountDollar = document.getElementById(
        "total-after-discount-dollar",
    );

    const defaultImage = window.defaultProductImage;

    // ===== FILTER TOGGLE =====
    toggleFilter.onclick = () => {
        filterBox.style.display =
            filterBox.style.display === "none" ? "block" : "none";
    };

    document.addEventListener("click", (e) => {
        if (!filterBox.contains(e.target) && e.target !== toggleFilter) {
            filterBox.style.display = "none";
        }
    });

    productSearch.addEventListener("input", function () {
        currentPage = 1;
        renderProducts(currentPage, this.value);
    });

    // ===== RENDER PRODUCTS =====
    function renderProducts(page, filter = "") {
        let filtered = products.filter((p) =>
            p.name.toLowerCase().includes(filter.toLowerCase()),
        );

        let start = (page - 1) * perPage;
        let end = start + perPage;

        let paginated = filtered.slice(start, end);

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
                    data-price="${product.purchase_price}"
                    data-image="${image}">

                    <img src="${image}" class="mb-2 img-fluid product-img"
                        style="width:80px;height:80px;object-fit:cover;cursor:pointer;">

                    <small class="d-block text-truncate" style="max-width:100px;">
                        ${product.name}
                    </small>

                    <p class="mb-1">৳${product.purchase_price}</p>

                    <button type="button"
                        class="btn btn-outline-primary btn-sm add-to-invoice">
                        Add
                    </button>
                </div>
            `;

            productGrid.appendChild(card);
        });

        // highlight selected
        cartItems.forEach((ci) => {
            const cardEl = document.querySelector(
                `.product-card[data-id="${ci.id}"]`,
            );
            if (cardEl) cardEl.classList.add("selected-product");
        });

        renderPagination(page, filtered.length);
        attachAddEvents();
        attachZoom();
    }

    // ===== PAGINATION =====
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

    // ===== ADD TO CART =====
    function attachAddEvents() {
        document.querySelectorAll(".add-to-invoice").forEach((btn) => {
            btn.onclick = () => {
                const card = btn.closest(".product-card");

                const id = card.dataset.id;
                const name = card.dataset.name;
                const price = parseFloat(card.dataset.price);

                const exist = cartItems.find((i) => i.id == id);

                if (exist) {
                    exist.qty++;
                } else {
                    cartItems.push({
                        id,
                        name,
                        price,
                        qty: 1,
                        discount: 0,
                    });
                }

                updateProductHighlight();
                renderCart();
            };
        });
    }

    // ===== PRODUCT HIGHLIGHT =====
    function updateProductHighlight() {
        document.querySelectorAll(".product-card").forEach((c) => {
            c.classList.remove("selected-product");
        });

        cartItems.forEach((ci) => {
            const cardEl = document.querySelector(
                `.product-card[data-id="${ci.id}"]`,
            );
            if (cardEl) cardEl.classList.add("selected-product");
        });
    }

    // ===== IMAGE ZOOM =====
    function attachZoom() {
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

    // ===== RENDER CART =====
    function renderCart(internal = false) {
        cartTable.innerHTML = "";
        let subTotal = 0;

        cartItems.forEach((item, index) => {
            let amount = item.qty * item.price - item.discount;
            subTotal += amount;

            const row = document.createElement("tr");

            row.innerHTML = `
                <td>${item.name}</td>
                <td>৳${item.price}</td>

                <td>
                    <input type="number" min="1"
                        value="${item.qty}"
                        class="form-control form-control-sm qty-input"
                        data-index="${index}">
                </td>

                <td>
                    <input type="number" min="0"
                        value="${item.discount}"
                        class="form-control form-control-sm disc-input"
                        data-index="${index}">
                </td>

                <td>৳${(item.qty * item.price).toFixed(2)}</td>
                <td>৳${amount.toFixed(2)}</td>

                <td>
                    <button class="btn btn-danger btn-sm remove-btn"
                        data-index="${index}">
                        ✕
                    </button>
                </td>
            `;

            cartTable.appendChild(row);
        });

        subTotalDisplay.innerText = subTotal.toFixed(2);
        subTotalBDTDisplay.innerText = subTotal.toFixed(2);

        if (!internal) updateDiscounts();

        let discountValue = 0;
        let totalAfterDiscount = subTotal;

        if (discountType.value === "percentage") {
            discountValue =
                subTotal * ((parseFloat(discountPercent.value) || 0) / 100);
            totalAfterDiscount = subTotal - discountValue;
        } else {
            discountValue = parseFloat(flatDiscount.value) || 0;
            totalAfterDiscount = subTotal - discountValue;
        }

        itemsInput.value = JSON.stringify({
            items: cartItems,
            sub_total: subTotal,
            discount_value: discountValue,
            total: totalAfterDiscount,
            discount_value_dollar: discountValue / exchangeRate,
            total_dollar: totalAfterDiscount / exchangeRate,
        });
    }

    // ===== CART INPUT EVENTS =====
    cartTable.addEventListener("input", function (e) {
        const index = e.target.dataset.index;

        if (e.target.classList.contains("qty-input"))
            cartItems[index].qty = parseFloat(e.target.value);

        if (e.target.classList.contains("disc-input"))
            cartItems[index].discount = parseFloat(e.target.value);

        renderCart();
    });

    cartTable.addEventListener("click", function (e) {
        if (e.target.classList.contains("remove-btn")) {
            const removed = cartItems.splice(e.target.dataset.index, 1);

            removed.forEach((r) => {
                const cardEl = document.querySelector(
                    `.product-card[data-id="${r.id}"]`,
                );
                if (cardEl) cardEl.classList.remove("selected-product");
            });

            renderCart();
        }
    });

    // ===== DISCOUNT EVENTS =====
    discountType.onchange = toggleDiscountType;
    discountPercent.oninput = updateDiscounts;
    flatDiscount.oninput = updateDiscounts;

    function toggleDiscountType() {
        if (discountType.value === "percentage") {
            percentSection.style.display = "block";
            flatSection.style.display = "none";
        } else {
            percentSection.style.display = "none";
            flatSection.style.display = "block";
        }

        updateDiscounts();
    }

    function updateDiscounts() {
        let subTotal = cartItems.reduce(
            (sum, item) => sum + (item.qty * item.price - item.discount),
            0,
        );

        let discountValue = 0;
        let totalAfterDiscount = subTotal;

        if (discountType.value === "percentage") {
            let percent = parseFloat(discountPercent.value) || 0;

            discountValue = subTotal * (percent / 100);
            totalAfterDiscount = subTotal - discountValue;

            discountAmountDisplay.innerText = discountValue.toFixed(2);
            totalAfterDiscountDisplay.innerText = Math.max(
                totalAfterDiscount,
                0,
            ).toFixed(2);
        } else {
            discountValue = parseFloat(flatDiscount.value) || 0;
            totalAfterDiscount = subTotal - discountValue;

            flatTotalDisplay.innerText = Math.max(
                totalAfterDiscount,
                0,
            ).toFixed(2);
        }

        let discountDollar = (discountValue / exchangeRate).toFixed(2);
        let totalDollar = (
            Math.max(totalAfterDiscount, 0) / exchangeRate
        ).toFixed(2);

        discountAmountDollar.innerText = discountDollar;
        totalAfterDiscountDollar.innerText = totalDollar;
    }

    // ===== INITIAL LOAD =====
    renderProducts(currentPage);
    renderCart();
});
