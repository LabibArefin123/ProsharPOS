document.addEventListener("DOMContentLoaded", function () {
    const productSelect = document.getElementById("product_id");

    productSelect.addEventListener("change", function () {
        const selected = this.options[this.selectedIndex];

        document.getElementById("sku").value = selected.dataset.sku || "";
        document.getElementById("part_number").value =
            selected.dataset.part_number || "";
        document.getElementById("type_model").value =
            selected.dataset.type_model || "";
        document.getElementById("origin").value = selected.dataset.origin || "";
        document.getElementById("using_place").value =
            selected.dataset.using_place || "";
    });

    // Trigger change on page load (for edit page)
    if (productSelect.value) {
        productSelect.dispatchEvent(new Event("change"));
    }
});
