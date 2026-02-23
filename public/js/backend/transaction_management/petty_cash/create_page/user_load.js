document.addEventListener("DOMContentLoaded", function () {
    // ---------------------
    // users Data
    // ---------------------

    const userSelect = document.getElementById("user_id");
    const userEmail = document.getElementById("user-email");
    const userPhone = document.getElementById("user-phone");
    const userUsername = document.getElementById("user-username");

    userSelect.addEventListener("change", function () {
        const selected = users.find((c) => c.id == this.value);
        if (selected) {
            userEmail.value = selected.email;
            userPhone.value = selected.phone;
            userUsername.value = selected.username;
        } else {
            userEmail.value = "";
            userPhone.value = "";
            userUsername.value = "";
        }
    });
});
