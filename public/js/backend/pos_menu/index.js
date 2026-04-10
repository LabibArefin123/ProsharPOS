let cart = {};

// 👉 Add Product
$(document).on("click", ".add-product", function () {
    let id = $(this).data("id");
    let name = $(this).data("name");
    let price = parseFloat($(this).data("price"));
    let stock = parseInt($(this).data("stock"));

    if (stock <= 0) {
        toastr.warning("Out of stock!");
        return;
    }

    if (cart[id]) {
        if (cart[id].qty >= stock) {
            toastr.error("Stock limit reached!");
            return;
        }
        cart[id].qty++;
    } else {
        cart[id] = {
            name,
            price,
            qty: 1,
            stock,
        };
    }

    updateCartCount();
    renderCart();
});

// 🔴 UPDATE BADGE COUNT
function updateCartCount() {
    let count = 0;

    $.each(cart, function (id, item) {
        count += item.qty;
    });

    if (count > 0) {
        $("#cart-count").text(count).show();
    } else {
        $("#cart-count").hide();
    }
}

// 🛒 OPEN MODAL
$("#open-cart").click(function () {
    $("#cartModal").modal("show");
});

// 👉 Render Cart
function renderCart() {
    let html = "";
    let total = 0;

    $.each(cart, function (id, item) {
        let sub = item.qty * item.price;
        total += sub;

        html += `
        <tr>
            <td>
                <strong>${item.name}</strong><br>
                ৳ ${item.price}
            </td>

            <td>
                <input type="number"
                       class="form-control form-control-sm qty-input"
                       value="${item.qty}"
                       min="1"
                       max="${item.stock}"
                       data-id="${id}">
            </td>

            <td>৳ ${sub.toFixed(2)}</td>

            <td>
                <button class="btn btn-danger btn-sm remove-item"
                        data-id="${id}">
                    ✕
                </button>
            </td>
        </tr>`;
    });

    $("#pos-cart").html(html);
    $("#grand-total").text(total.toFixed(2));
}

// 👉 Quantity change
$(document).on("change", ".qty-input", function () {
    let id = $(this).data("id");
    let qty = parseInt($(this).val());

    if (qty <= 0) {
        delete cart[id];
    } else {
        cart[id].qty = qty;
    }

    updateCartCount();
    renderCart();
});

// 👉 Remove item
$(document).on("click", ".remove-item", function () {
    delete cart[$(this).data("id")];

    updateCartCount();
    renderCart();
});

// 🔍 SEARCH
$("#search-product").on("keyup", function () {
    let value = $(this).val().toLowerCase();

    $(".product-item").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
});

// 💳 Checkout
$("#checkout-btn").click(function () {
    if (Object.keys(cart).length === 0) {
        toastr.warning("Cart is empty!");
        return;
    }

    console.log(cart);
    alert("Next: Payment system 💳");
});
