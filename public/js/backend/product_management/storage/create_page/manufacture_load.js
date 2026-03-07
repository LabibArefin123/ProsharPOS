document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("manufacturer_id");
    if (!select) return;

    function fillManufacturer() {
        const selected = select.options[select.selectedIndex];
        if (!selected || !selected.value) return;

        document.getElementById("manufacturer_country").value =
            selected.dataset.country || "";
        document.getElementById("manufacturer_location").value =
            selected.dataset.location || "";
        document.getElementById("manufacturer_email").value =
            selected.dataset.email || "";
        document.getElementById("manufacturer_phone").value =
            selected.dataset.phone || "";
    }

    select.addEventListener("change", fillManufacturer);

    // ✅ Force load for edit + old()
    window.requestAnimationFrame(fillManufacturer);
});
