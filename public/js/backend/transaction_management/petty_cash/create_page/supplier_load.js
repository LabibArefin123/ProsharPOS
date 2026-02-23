document.addEventListener("DOMContentLoaded", function () {
    // ---------------------
    // suppliers Data
    // ---------------------
    const supplierSelect = document.getElementById("supplier_id");
    const supplierEmail = document.getElementById("supplier-email");
    const supplierPhone = document.getElementById("supplier-phone");
    const supplierLicense = document.getElementById("supplier-license");

    supplierSelect.addEventListener("change", function () {
        const selected = suppliers.find((c) => c.id == this.value);
        if (selected) {
            supplierEmail.value = selected.email;
            supplierPhone.value = selected.phone_number;
            supplierLicense.value = selected.license_number;
        } else {
            supplierEmail.value = "";
            supplierPhone.value = "";
            supplierLicense.value = "";
        }
    });
});
