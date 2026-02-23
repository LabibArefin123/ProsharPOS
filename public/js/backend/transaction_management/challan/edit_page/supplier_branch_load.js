document.addEventListener("DOMContentLoaded", function () {
    /* -------------------------
               SUPPLIERS DATA
            -------------------------- */
    const supplierSelect = document.getElementById("supplier_id");
    const supplierEmail = document.getElementById("supplier_email");
    const supplierPhone = document.getElementById("supplier_phone");
    const supplierLocation = document.getElementById("supplier_location");

    function loadSupplierInfo(id) {
        const selected = suppliers.find((s) => s.id == id);
        if (selected) {
            supplierEmail.value = selected.email ?? "";
            supplierPhone.value = selected.phone_number ?? "";
            supplierLocation.value = selected.location ?? "";
        }
    }

    supplierSelect.addEventListener("change", function () {
        loadSupplierInfo(this.value);
    });

    // Auto-load for edit
    if (supplierSelect.value) {
        loadSupplierInfo(supplierSelect.value);
    }

    /* -------------------------
               BRANCHES DATA
            -------------------------- */

    const branchSelect = document.getElementById("branch_id");
    const branchCode = document.getElementById("branch_code");
    const branchPhone = document.getElementById("branch_phone");
    const branchLocation = document.getElementById("branch_location");

    function loadBranchInfo(id) {
        const selected = branches.find((b) => b.id == id);
        if (selected) {
            branchCode.value = selected.branch_code ?? "";
            branchPhone.value = selected.phone ?? "";
            branchLocation.value = selected.address ?? "";
        }
    }

    branchSelect.addEventListener("change", function () {
        loadBranchInfo(this.value);
    });

    // Auto-load for edit
    if (branchSelect.value) {
        loadBranchInfo(branchSelect.value);
    }
});
