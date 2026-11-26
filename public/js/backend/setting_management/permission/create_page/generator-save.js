document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    const saveButton = document.getElementById("saveAllPermissions");
    const saveForm = document.getElementById("permissionSaveForm");

    if (!saveButton || !saveForm) return;

    saveButton.addEventListener("click", savePermissionsAjax);

    async function savePermissionsAjax() {
        const permissions = window.selectedPermissions || [];

        if (!permissions.length) {
            toastr.warning("Please select permissions first.");
            return;
        }

        const originalHTML = saveButton.innerHTML;

        saveButton.disabled = true;
        saveButton.innerHTML =
            '<i class="fas fa-spinner fa-spin mr-1"></i> Saving...';

        try {
            const response = await fetch(saveForm.action, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": saveForm.querySelector(
                        'input[name="_token"]',
                    ).value,
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
                body: JSON.stringify({
                    permissions: permissions,
                }),
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || "Unable to save permissions.");
            }

            (data.permissions || permissions).forEach((permission) => {
                toastr.success(permission + " created successfully.");
            });

            window.selectedPermissions = [];

            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } catch (error) {
            console.error("Permission save error:", error);

            toastr.error(error.message || "Server error occurred.");

            saveButton.disabled = false;
            saveButton.innerHTML = originalHTML;
        }
    }
});
