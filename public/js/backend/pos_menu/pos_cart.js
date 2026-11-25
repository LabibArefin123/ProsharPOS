/* ==========================================
   ProsharPOS - Cart Management
========================================== */

window.posCart = window.posCart || {};

posCart.items = {};

posCart.formatMoney = function (amount) {
    return Number(amount).toLocaleString("en-BD", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
};

posCart.total = function () {
    return Object.values(posCart.items).reduce(function (sum, item) {
        return sum + item.qty * item.price;
    }, 0);
};

posCart.count = function () {
    return Object.values(posCart.items).reduce(function (sum, item) {
        return sum + item.qty;
    }, 0);
};

// Add Product
posCart.add = function (product) {
    const id = String(product.id);

    if (product.stock <= 0) {
        toastr.warning("This product is out of stock.");
        return;
    }

    if (posCart.items[id]) {
        if (posCart.items[id].qty >= posCart.items[id].stock) {
            toastr.warning("Maximum available stock reached.");
            return;
        }

        posCart.items[id].qty++;
    } else {
        posCart.items[id] = {
            id: id,
            name: product.name,
            price: product.price,
            qty: 1,
            stock: product.stock,
        };
    }

    posCart.render();

    toastr.success(product.name + " added to cart.");
};

// Change Quantity
posCart.changeQuantity = function (id, quantity) {
    const item = posCart.items[id];

    if (!item) return;

    quantity = parseInt(quantity, 10);

    if (isNaN(quantity) || quantity < 1) {
        quantity = 1;
    }

    if (quantity > item.stock) {
        quantity = item.stock;
        toastr.warning("Available stock: " + item.stock);
    }

    item.qty = quantity;

    posCart.render();
};

// Remove Product
posCart.remove = function (id) {
    if (!posCart.items[id]) return;

    delete posCart.items[id];

    posCart.render();

    toastr.info("Product removed from cart.");
};

// Clear Cart
posCart.clear = function () {
    posCart.items = {};

    posCart.render();
};

// Build Cart HTML
posCart.buildItems = function () {
    let html = "";

    Object.values(posCart.items).forEach(function (item) {
        const subtotal = item.qty * item.price;

        html += `
            <div class="pp-cart-item">

                <div class="pp-cart-item-info">

                    <strong>${posCart.escapeHtml(item.name)}</strong>

                    <small>
                        ৳ ${posCart.formatMoney(item.price)} each
                    </small>

                    <div class="pp-cart-item-controls">

                        <button type="button"
                            class="pp-qty-btn"
                            data-action="decrease"
                            data-id="${item.id}">
                            <i class="fas fa-minus"></i>
                        </button>

                        <span class="pp-qty-value">${item.qty}</span>

                        <button type="button"
                            class="pp-qty-btn"
                            data-action="increase"
                            data-id="${item.id}">
                            <i class="fas fa-plus"></i>
                        </button>

                    </div>

                </div>

                <div class="text-right">

                    <div class="pp-cart-item-price">
                        ৳ ${posCart.formatMoney(subtotal)}
                    </div>

                    <button type="button"
                        class="pp-cart-remove"
                        data-id="${item.id}">
                        <i class="fas fa-trash-alt"></i>
                    </button>

                </div>

            </div>
        `;
    });

    return html;
};

// Escape Product Names
posCart.escapeHtml = function (value) {
    return String(value).replace(/[&<>"']/g, function (char) {
        return {
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#039;",
        }[char];
    });
};

// Render Cart
posCart.render = function () {
    const count = posCart.count();
    const total = posCart.total();

    const emptyHtml = `
        <div class="pp-cart-empty">
            <i class="fas fa-shopping-basket"></i>
            <h6>Your cart is empty</h6>
            <p>Add products to start a sale</p>
        </div>
    `;

    const cartHtml = count > 0 ? posCart.buildItems() : emptyHtml;

    // Desktop cart
    $("#pos-cart").html(cartHtml);

    // Modal cart
    let modalHtml = "";

    Object.values(posCart.items).forEach(function (item) {
        const subtotal = item.qty * item.price;

        modalHtml += `
            <tr>
                <td>${posCart.escapeHtml(item.name)}</td>

                <td>৳ ${posCart.formatMoney(item.price)}</td>

                <td>
                    <input type="number"
                        class="form-control form-control-sm qty-input"
                        min="1"
                        max="${item.stock}"
                        value="${item.qty}"
                        data-id="${item.id}">
                </td>

                <td>
                    <strong>৳ ${posCart.formatMoney(subtotal)}</strong>
                </td>

                <td>
                    <button type="button"
                        class="btn btn-sm btn-outline-danger remove-item"
                        data-id="${item.id}">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            </tr>
        `;
    });

    $("#pos-cart-modal").html(modalHtml);

    if (count === 0) {
        $("#pos-cart-modal").html(`
            <tr>
                <td colspan="5" class="text-center text-muted py-4">
                    Your cart is empty.
                </td>
            </tr>
        `);
    }

    $("#cart-count").text(count);
    $("#cart-panel-count").text(count + (count === 1 ? " Item" : " Items"));

    $("#grand-total").text(posCart.formatMoney(total));
    $("#modal-grand-total").text(posCart.formatMoney(total));

    $("#checkout-btn, #checkout-btn-modal").prop("disabled", count === 0);

    // Keep checkout total updated
    $("#checkout-total").text(posCart.formatMoney(total));
};

// Desktop Quantity Controls
$(document).on("click", ".pp-qty-btn", function () {
    const id = String($(this).data("id"));
    const action = $(this).data("action");

    const item = posCart.items[id];

    if (!item) return;

    let quantity = item.qty;

    if (action === "increase") {
        quantity++;
    }

    if (action === "decrease") {
        quantity--;
    }

    if (quantity <= 0) {
        posCart.remove(id);
        return;
    }

    posCart.changeQuantity(id, quantity);
});

// Modal Quantity Controls
$(document).on("change", ".qty-input", function () {
    const id = String($(this).data("id"));

    posCart.changeQuantity(id, $(this).val());
});

// Remove Item
$(document).on("click", ".remove-item, .pp-cart-remove", function () {
    posCart.remove(String($(this).data("id")));
});

// Clear Cart
$(document).on("click", "#clear-cart", function () {
    if (posCart.count() === 0) return;

    if (confirm("Are you sure you want to clear the cart?")) {
        posCart.clear();
    }
});

// Open Cart
$(document).on("click", "#open-cart", function () {
    $("#cartModal").modal("show");
});

// Initial Render
$(document).ready(function () {
    posCart.render();
});
