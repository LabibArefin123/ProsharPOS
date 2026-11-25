/* ==========================================
   ProsharPOS - Product Management
========================================== */

// Add Product
$(document).on("click", ".add-product", function () {
    const product = {
        id: $(this).data("id"),
        name: $(this).data("name"),
        price: parseFloat($(this).data("price")),
        stock: parseInt($(this).data("stock"), 10),
    };

    posCart.add(product);
});

// Product Search
$("#search-product").on("input", function () {
    const search = $(this).val().toLowerCase().trim();

    let visibleCount = 0;

    $(".product-item").each(function () {
        const productText = $(this).text().toLowerCase();

        const productName = String(
            $(this).find(".add-product").data("name") || "",
        ).toLowerCase();

        const productSku = String(
            $(this).find(".pp-product-sku").text(),
        ).toLowerCase();

        const matches =
            productText.includes(search) ||
            productName.includes(search) ||
            productSku.includes(search);

        $(this).toggle(matches);

        if (matches) {
            visibleCount++;
        }
    });

    $("#product-grid .pp-search-empty").remove();

    if (visibleCount === 0) {
        $("#product-grid").append(`
            <div class="col-12 pp-search-empty">
                <div class="pp-empty-products">
                    <i class="fas fa-search"></i>
                    <h5>No matching products</h5>
                    <p>Try another product name or SKU.</p>
                </div>
            </div>
        `);
    }
});

// Clear Search When Navigating Pagination
$(document).on("click", ".pp-product-pagination .page-link", function () {
    $("#search-product").val("");
});
