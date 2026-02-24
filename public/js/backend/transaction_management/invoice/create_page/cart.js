 document.addEventListener('DOMContentLoaded', function() {
        // ---------------------
        // Filter Box Toggle
        // ---------------------
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

        // ---------------------
        // Product Pagination & Filter
        // ---------------------
        
        const perPage = 6; // 3 columns x 2 rows
        let currentPage = 1;

        const productGrid = document.getElementById('product-grid');
        const paginationEl = document.getElementById('product-pagination');

        function renderProducts(page, filter = '') {
            let filtered = products.filter(p => p.name.toLowerCase().includes(filter.toLowerCase()));

            const start = (page - 1) * perPage;
            const end = start + perPage;
            const paginated = filtered.slice(start, end);

            productGrid.innerHTML = '';

            paginated.forEach(product => {
                const image = product.image
                    ? `/uploads/images/product/${product.image}`
                    : "/images/default.jpg";
                const card = document.createElement('div');
                card.className = 'col-md-4 mb-3 d-flex justify-content-center'; // center image
                card.innerHTML = `
            <div class="text-center product-card p-2" 
                    data-id="${product.id}" 
                    data-name="${product.name}" 
                    data-price="${product.purchase_price}" 
                    data-image="${image}">
                <img src="${image}" class="mb-2 img-fluid product-img" style="width:80px; height:80px; object-fit:cover; cursor:pointer;" alt="${product.name}">
                <small class="d-block text-truncate" style="max-width:100px;">${product.name}</small>
                <p class="mb-1">৳${product.purchase_price}</p>
                <button type="button" class="btn btn-outline-primary btn-sm add-to-invoice">Add</button>
            </div>
        `;
                productGrid.appendChild(card);
            });

            renderPagination(page, filtered.length);
            attachAddToCartEvents();
            attachImageZoomEvents();
        }

        function renderPagination(page, totalFiltered) {
            const totalPages = Math.ceil(totalFiltered / perPage);
            paginationEl.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === page ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                li.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentPage = i;
                    renderProducts(currentPage, productSearch.value);
                });
                paginationEl.appendChild(li);
            }
        }

        productSearch.addEventListener('input', function() {
            currentPage = 1;
            renderProducts(currentPage, this.value);
        });

        // ---------------------
        // Cart JS
        // ---------------------
        const cartTable = document.querySelector('#invoice-cart tbody');
        const itemsInput = document.getElementById('invoice-items');
        const discountType = document.getElementById('discount-type');
        const percentSection = document.getElementById('percent-section');
        const flatSection = document.getElementById('flat-section');
        const discountPercent = document.getElementById('discount-percent');
        const flatDiscount = document.getElementById('flat-discount');
        const discountAmountDisplay = document.getElementById('discount-amount');
        const totalAfterDiscountDisplay = document.getElementById('total-after-discount');
        const flatTotalDisplay = document.getElementById('flat-total');
        const subTotalDisplay = document.getElementById('sub-total');
        const subTotalBDTDisplay = document.getElementById('sub-total-bdt');

        let cartItems = [];

        function attachAddToCartEvents() {
            document.querySelectorAll('.add-to-invoice').forEach(button => {
                button.onclick = function() {
                    const card = this.closest('.product-card');
                    const id = card.dataset.id;
                    const name = card.dataset.name;
                    const price = parseFloat(card.dataset.price);

                    const existing = cartItems.find(item => item.id === id);
                    if (existing) existing.qty += 1;
                    else cartItems.push({
                        id,
                        name,
                        price,
                        qty: 1,
                        discount: 0
                    });

                    renderCart();
                };
            });
        }

        function renderCart(internal = false) {
            cartTable.innerHTML = '';
            let subTotal = 0;

            cartItems.forEach((item, index) => {
                const amount = item.qty * item.price - item.discount;
                subTotal += amount;

                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${item.name}</td>
            <td>৳${item.price.toFixed(2)}</td>
            <td><input type="number" min="1" value="${item.qty}" data-index="${index}" class="form-control form-control-sm qty-input"></td>
            <td><input type="number" min="0" value="${item.discount}" data-index="${index}" class="form-control form-control-sm disc-input"></td>
            <td>৳${(item.qty * item.price).toFixed(2)}</td>
            <td>৳${amount.toFixed(2)}</td>
            <td><button type="button" data-index="${index}" class="btn btn-danger btn-sm remove-btn">✕</button></td>
        `;
                cartTable.appendChild(row);
            });

            subTotalDisplay.innerText = subTotal.toFixed(2);
            subTotalBDTDisplay.innerText = subTotal.toFixed(2);

            // ❗ Prevent recursion loop
            if (!internal) updateDiscounts();

            let discountValue = 0;
            let totalAfterDiscount = subTotal;

            if (discountType.value === 'percentage') {
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


        cartTable.addEventListener('input', function(e) {
            const index = e.target.dataset.index;
            if (e.target.classList.contains('qty-input')) cartItems[index].qty = parseInt(e.target
                .value);
            if (e.target.classList.contains('disc-input')) cartItems[index].discount = parseFloat(e
                .target.value);
            renderCart();
        });

        cartTable.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-btn')) {
                cartItems.splice(e.target.dataset.index, 1);
                renderCart();
            }
        });

        // Prevent Enter from submitting the form when typing in search
        productSearch.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent form submission
            }
        });

        discountType.addEventListener('change', function() {
            if (this.value === 'percentage') {
                percentSection.style.display = 'block';
                flatSection.style.display = 'none';
            } else {
                percentSection.style.display = 'none';
                flatSection.style.display = 'block';
            }
            updateDiscounts();
        });
        discountPercent.addEventListener('input', updateDiscounts);
        flatDiscount.addEventListener('input', updateDiscounts);

        function updateDiscounts() {
            const subTotal = cartItems.reduce((sum, item) => sum + (item.qty * item.price - item.discount), 0);

            if (discountType.value === 'percentage') {
                const percent = parseFloat(discountPercent.value) || 0;
                const amount = subTotal * (percent / 100);
                discountAmountDisplay.innerText = amount.toFixed(2);
                totalAfterDiscountDisplay.innerText = (subTotal - amount).toFixed(2);
            } else {
                const flat = parseFloat(flatDiscount.value) || 0;
                flatTotalDisplay.innerText = (subTotal - flat).toFixed(2);
            }

            // 🔥 IMPORTANT: Update JSON payload
            renderCart(true);
        }


        // ---------------------
        // Image Zoom Modal
        // ---------------------
        function attachImageZoomEvents() {
            document.querySelectorAll('.product-img').forEach(img => {
                img.onclick = function() {
                    const src = this.src;
                    const name = this.closest('.product-card').dataset.name;
                    document.getElementById('zoomed-image').src = src;
                    document.getElementById('zoomed-name').innerText = name;
                    new bootstrap.Modal(document.getElementById('imageModal')).show();
                };
            });
        }

        // Initial Render
        renderProducts(currentPage);
    });