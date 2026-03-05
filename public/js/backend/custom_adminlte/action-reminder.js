document.addEventListener("DOMContentLoaded", () => {
    let pendingAction = null;

    // ✅ CREATE CONFIRMATION HANDLER
    document.querySelectorAll('form[data-confirm="create"]').forEach((form) => {
        form.addEventListener("submit", function (e) {
            if (!form.dataset.confirmed) {
                e.preventDefault();
                pendingAction = form;
                $("#createConfirmModal").modal("show");
            }
        });
    });

    // ✅ EDIT CONFIRMATION HANDLER
    document.querySelectorAll('form[data-confirm="edit"]').forEach((form) => {
        form.addEventListener("submit", function (e) {
            if (!form.dataset.confirmed) {
                e.preventDefault();
                pendingAction = form;
                $("#editConfirmModal").modal("show");
            }
        });
    });

    // ✅ DELETE CONFIRMATION HANDLER
    window.triggerDeleteModal = function (url) {
        const form = document.getElementById("deleteForm");
        form.action = url;
        $("#deleteConfirmModal").modal("show");
    };

    // ✅ ON MODAL CONFIRM CLICKS
    document
        .querySelectorAll(
            "#createConfirmModal .btn-success, #editConfirmModal .btn-info",
        )
        .forEach((button) => {
            button.addEventListener("click", function () {
                if (pendingAction) {
                    pendingAction.dataset.confirmed = true;
                    pendingAction.submit();
                    pendingAction = null;
                }
            });
        });
});
