document.addEventListener("DOMContentLoaded", function () {
    const userSelect = document.getElementById("user_id");
    const userEmail = document.getElementById("user-email");
    const userPhone = document.getElementById("user-phone");
    const userUsername = document.getElementById("user-username");

    function loadUserData() {
        const selected = window.users.find((c) => c.id == userSelect.value);
        if (selected) {
            userEmail.value = selected.email ?? "";
            userPhone.value = selected.phone ?? "";
            userUsername.value = selected.username ?? "";
        } else {
            userEmail.value = "";
            userPhone.value = "";
            userUsername.value = "";
        }
    }

    userSelect.addEventListener("change", loadUserData);

    // 🔥 THIS IS IMPORTANT FOR EDIT PAGE
    if (userSelect.value) {
        loadUserData();
    }
});
