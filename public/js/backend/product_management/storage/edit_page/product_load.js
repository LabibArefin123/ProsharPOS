document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("product_id");

    function fillProduct() {
        const selected = select.options[select.selectedIndex];
        if (!selected || !selected.value) return;

        document.getElementById("sku").value = selected.dataset.sku || "";
        document.getElementById("part_number").value =
            selected.dataset.part_number || "";
        document.getElementById("type_model").value =
            selected.dataset.type_model || "";
        document.getElementById("origin").value = selected.dataset.origin || "";
        document.getElementById("using_place").value =
            selected.dataset.using_place || "";
    }

    // Change event
    select.addEventListener("change", fillProduct);

    // ✅ FORCE load for edit + old()
    window.requestAnimationFrame(fillProduct);
});
