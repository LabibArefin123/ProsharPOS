document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("supplier_id");
    if (!select) return;

    function fillSupplier() {
        const selected = select.options[select.selectedIndex];
        if (!selected || !selected.value) return;

        document.getElementById("supplier_location").value =
            selected.dataset.location || "";
        document.getElementById("supplier_email").value =
            selected.dataset.email || "";
        document.getElementById("supplier_phone_number").value =
            selected.dataset.phone || "";
        document.getElementById("supplier_license_no").value =
            selected.dataset.license || "";
    }

    select.addEventListener("change", fillSupplier);

    // ✅ Force load for edit + old()
    window.requestAnimationFrame(fillSupplier);
});
