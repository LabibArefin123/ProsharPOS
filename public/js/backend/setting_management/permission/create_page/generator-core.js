document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    window.selectedPermissions = [];
    window.generatedPermissions = [];

    const resourceInput = document.getElementById("permissionResourceInput");
    const generatedPermissionList = document.getElementById(
        "generatedPermissionList",
    );
    const selectedPermissionWrapper = document.getElementById(
        "selectedPermissionWrapper",
    );
    const selectedCount = document.getElementById("permissionSelectedCount");
    const saveAllButton = document.getElementById("saveAllPermissions");
    const modalElement = document.getElementById("permissionGeneratorModal");

    if (!resourceInput || !generatedPermissionList || !modalElement) return;

    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

    const resourceActions = [
        "index",
        "create",
        "store",
        "show",
        "edit",
        "update",
        "destroy",
        "delete",
        "status",
        "manage",
    ];

    let searchTimer = null;
    let lastGeneratedValue = "";
    let modalOpen = false;

    const existingPermissions = (window.existingPermissions || []).map(
        (permission) => String(permission).toLowerCase(),
    );

    /* =========================================
       VALIDATE INPUT
    ========================================= */

    function getPermissionData(value) {
        const input = value.trim().toLowerCase();

        if (!input || !input.endsWith("s")) {
            return null;
        }

        // Exact route permission:
        // project-informations.search_items

        if (input.includes(".")) {
            const validRoute = /^[a-z][a-z0-9_-]*\.[a-z][a-z0-9_-]*$/i;

            if (!validRoute.test(input)) {
                return null;
            }

            return {
                type: "single",
                permissions: [input],
            };
        }

        // Plural resource:
        // doctors, tenders, products

        const validResource = /^[a-z][a-z0-9_-]*s$/i;

        if (!validResource.test(input)) {
            return null;
        }

        return {
            type: "resource",
            permissions: resourceActions.map((action) => `${input}.${action}`),
        };
    }

    /* =========================================
       INPUT LISTENER
    ========================================= */

    resourceInput.addEventListener("input", function () {
        clearTimeout(searchTimer);

        const value = this.value.trim().toLowerCase();

        if (!value) {
            lastGeneratedValue = "";
            window.generatedPermissions = [];
            return;
        }

        const permissionData = getPermissionData(value);

        if (!permissionData) {
            lastGeneratedValue = "";
            return;
        }

        if (lastGeneratedValue === value) return;

        searchTimer = setTimeout(function () {
            const currentValue = resourceInput.value.trim().toLowerCase();

            // Ensure the input has not changed during debounce.
            if (currentValue !== value) return;

            const validatedData = getPermissionData(currentValue);

            if (!validatedData) return;

            lastGeneratedValue = currentValue;

            window.generatedPermissions = validatedData.permissions.filter(
                (permission) =>
                    !existingPermissions.includes(permission.toLowerCase()),
            );

            renderGeneratedPermissions(validatedData);

            if (!modalOpen) {
                modal.show();
            }
        }, 500);
    });

    /* =========================================
       RENDER GENERATED PERMISSIONS
    ========================================= */

    function renderGeneratedPermissions(data) {
        generatedPermissionList.replaceChildren();

        if (window.generatedPermissions.length === 0) {
            const message = document.createElement("div");

            message.className = "alert alert-warning mb-0";
            message.textContent = "All permissions already exist.";

            generatedPermissionList.appendChild(message);
            return;
        }

        window.generatedPermissions.forEach((permission) => {
            const label = document.createElement("label");
            label.className = "generated-permission-item";

            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.className = "generated-checkbox";
            checkbox.value = permission;
            checkbox.checked = true;

            const content = document.createElement("div");
            content.className = "generated-permission-content";

            const circle = document.createElement("div");
            circle.className = "generated-circle";

            const group = document.createElement("div");
            group.className = "permission-text-group";

            const title = document.createElement("strong");
            title.textContent = permission;

            group.appendChild(title);
            content.append(circle, group);
            label.append(checkbox, content);

            generatedPermissionList.appendChild(label);
        });

        const heading = modalElement.querySelector(".modal-title");

        if (heading) {
            heading.innerHTML =
                data.type === "single"
                    ? '<i class="fas fa-route text-primary me-1"></i> Single Route Permission'
                    : '<i class="fas fa-shield-alt text-primary me-1"></i> Generated Permissions';
        }
    }

    /* =========================================
       MODAL EVENTS
    ========================================= */

    modalElement.addEventListener("show.bs.modal", function () {
        modalOpen = true;
    });

    modalElement.addEventListener("hidden.bs.modal", function () {
        modalOpen = false;
    });

    /* =========================================
       EXPORT RENDER FUNCTION
    ========================================= */

    window.renderSelectedPermissions = function () {
        if (!selectedPermissionWrapper || !selectedCount || !saveAllButton)
            return;

        selectedPermissionWrapper.replaceChildren();

        selectedCount.textContent = window.selectedPermissions.length;

        saveAllButton.classList.toggle(
            "d-none",
            window.selectedPermissions.length === 0,
        );

        window.selectedPermissions.forEach((permission) => {
            const badge = document.createElement("div");
            badge.className = "selected-permission-badge";
            badge.dataset.name = permission;

            const text = document.createElement("span");
            text.textContent = permission;

            const remove = document.createElement("button");
            remove.type = "button";
            remove.className = "remove-permission";
            remove.setAttribute("aria-label", "Remove permission");
            remove.innerHTML = '<i class="fas fa-times"></i>';

            remove.addEventListener("click", function () {
                window.selectedPermissions = window.selectedPermissions.filter(
                    (item) => item !== permission,
                );

                window.renderSelectedPermissions();
            });

            badge.append(text, remove);
            selectedPermissionWrapper.appendChild(badge);
        });
    };

    /* =========================================
       ADD SELECTED PERMISSIONS
    ========================================= */

    const addButton = document.getElementById("addSelectedPermissions");

    if (addButton) {
        addButton.addEventListener("click", function () {
            const selected = generatedPermissionList.querySelectorAll(
                ".generated-checkbox:checked",
            );

            selected.forEach((checkbox) => {
                if (!window.selectedPermissions.includes(checkbox.value)) {
                    window.selectedPermissions.push(checkbox.value);
                }
            });

            window.renderSelectedPermissions();
            modal.hide();
        });
    }
});
