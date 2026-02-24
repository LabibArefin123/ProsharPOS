document.addEventListener("DOMContentLoaded", function () {
    const supplierSelect = document.getElementById("supplier_id");
    const supplierEmail = document.getElementById("supplier-email");
    const supplierPhone = document.getElementById("supplier-phone");
    const supplierLicense = document.getElementById("supplier-license");

    function loadSupplierData() {
        const selected = window.suppliers.find(
            (c) => c.id == supplierSelect.value,
        );
        if (selected) {
            supplierEmail.value = selected.email ?? "";
            supplierPhone.value = selected.phone_number ?? "";
            supplierLicense.value = selected.license_number ?? "";
        } else {
            supplierEmail.value = "";
            supplierPhone.value = "";
            supplierLicense.value = "";
        }
    }

    supplierSelect.addEventListener("change", loadSupplierData);

    // 🔥 THIS FIXES EDIT PAGE
    if (supplierSelect.value) {
        loadSupplierData();
    }
});
