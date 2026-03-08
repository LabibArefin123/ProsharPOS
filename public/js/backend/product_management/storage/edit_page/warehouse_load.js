document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("warehouse_id");
    if (!select) return;

    function fillWarehouse() {
        const selected = select.options[select.selectedIndex];
        if (!selected || !selected.value) return;

        const code = selected.dataset.code || "";
        const location = selected.dataset.location || "";
        const manager = selected.dataset.manager || "";

        document.getElementById("warehouse_code").value = code;
        document.getElementById("warehouse_location").value = location;
        document.getElementById("warehouse_manager_name").value = manager;
    }

    // change event
    select.addEventListener("change", fillWarehouse);

    // load for edit page
    fillWarehouse();
});
