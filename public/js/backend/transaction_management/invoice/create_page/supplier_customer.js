document.addEventListener("DOMContentLoaded", function () {
    // ---------------------
    // Customers Data
    // ---------------------

    const customerSelect = document.getElementById("customer_id");
    const customerEmail = document.getElementById("customer_email");
    const customerPhone = document.getElementById("customer_phone");
    const customerLocation = document.getElementById("customer_location");

    customerSelect.addEventListener("change", function () {
        const selected = customers.find((c) => c.id == this.value);
        if (selected) {
            customerEmail.value = selected.email;
            customerPhone.value = selected.phone;
            customerLocation.value = selected.location;
        } else {
            customerEmail.value = "";
            customerPhone.value = "";
            customerLocation.value = "";
        }
    });

    // ---------------------
    // Branches Data
    // ---------------------

    const branchSelect = document.getElementById("branch_id");
    const branchCode = document.getElementById("branch_code");
    const branchPhone = document.getElementById("branch_phone");
    const branchLocation = document.getElementById("branch_location");

    branchSelect.addEventListener("change", function () {
        const selected = branches.find((b) => b.id == this.value);
        if (selected) {
            branchCode.value = selected.branch_code;
            branchPhone.value = selected.phone;
            branchLocation.value = selected.address;
        } else {
            branchCode.value = "";
            branchPhone.value = "";
            branchLocation.value = "";
        }
    });
});
