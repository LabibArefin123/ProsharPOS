document.addEventListener("DOMContentLoaded", function () {
    const manufacturerSelect = document.getElementById("manufacturer_id");

    function loadManufacturerData() {
        const selected = manufacturerSelect.querySelector("option:checked");
        if (!selected) return;

        document.getElementById("country").value =
            selected.dataset.country || "";
        document.getElementById("location").value =
            selected.dataset.location || "";
        document.getElementById("email").value = selected.dataset.email || "";
        document.getElementById("phone").value = selected.dataset.phone || "";
    }

    manufacturerSelect.addEventListener("change", loadManufacturerData);

    // ✅ Delay trigger so old()/edit value is applied
    setTimeout(loadManufacturerData, 0);
});
