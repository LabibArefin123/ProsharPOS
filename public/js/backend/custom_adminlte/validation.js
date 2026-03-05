document.addEventListener("DOMContentLoaded", function () {
    let isDirty = false;
    let lastBackHref = null;

    // Track changes on all forms
    document.querySelectorAll("form").forEach((form) => {
        form.querySelectorAll("input, textarea, select").forEach((input) => {
            input.addEventListener("change", () => {
                isDirty = true;
            });
        });

        // Reset dirty flag on submit
        form.addEventListener("submit", () => {
            isDirty = false;
        });
    });

    // Handle all back buttons
    document.querySelectorAll(".back-btn").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            const href = btn.getAttribute("href");
            if (isDirty) {
                e.preventDefault();
                lastBackHref = href; // save the target URL
                $("#backConfirmModal").modal("show");
            } else {
                window.location.href = href;
            }
        });
    });

    // Leave page from modal
    const leaveBtn = document.querySelector("#backConfirmModal .leave-page");
    leaveBtn.addEventListener("click", function () {
        if (lastBackHref) {
            isDirty = false;
            window.location.href = lastBackHref; // go to correct index page dynamically
        }
    });

    // Warn user if leaving by browser navigation
    window.addEventListener("beforeunload", function (e) {
        if (isDirty) {
            e.preventDefault();
            e.returnValue = "";
        }
    });
});
