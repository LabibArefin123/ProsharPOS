document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("warehouse_id");
    if (!select) return;

    function fillWarehouse() {
        const selected = select.options[select.selectedIndex];
        if (!selected || !selected.value) return;

        document.getElementById("warehouse_code").value =
            selected.dataset.code || "";

        document.getElementById("warehouse_location").value =
            selected.dataset.location || "";

        document.getElementById("warehouse_manager_name").value =
            selected.dataset.manager || "";
    }

    select.addEventListener("change", fillWarehouse);

    // ✅ Auto load when editing or using old()
    window.requestAnimationFrame(fillWarehouse);
});
