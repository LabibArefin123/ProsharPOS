/* =========================================
   LOGIN PAGE & PROBLEM MODAL
========================================= */

document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    const problemModal = document.getElementById("problemModal");

    // Open modal.
    window.openProblemModal = function () {
        if (!problemModal) return;

        problemModal.classList.add("active");
        document.body.classList.add("problem-modal-open");
    };

    // Close modal.
    window.closeProblemModal = function () {
        if (!problemModal) return;

        problemModal.classList.remove("active");
        document.body.classList.remove("problem-modal-open");
    };

    // Close when clicking the modal backdrop.
    if (problemModal) {
        problemModal.addEventListener("click", function (event) {
            if (event.target === problemModal) {
                window.closeProblemModal();
            }
        });
    }

    // Close with Escape.
    document.addEventListener("keydown", function (event) {
        if (
            event.key === "Escape" &&
            problemModal &&
            problemModal.classList.contains("active")
        ) {
            window.closeProblemModal();
        }
    });

    // Password visibility.
    document.querySelectorAll(".toggle-password").forEach(function (button) {
        button.addEventListener("click", function () {
            const targetId = button.getAttribute("data-target");
            const input = targetId ? document.getElementById(targetId) : null;

            if (!input) return;

            const showPassword = input.type === "password";

            input.type = showPassword ? "text" : "password";

            const icon = button.querySelector("i");

            if (icon) {
                icon.classList.toggle("fa-eye", !showPassword);
                icon.classList.toggle("fa-eye-slash", showPassword);
            }

            button.setAttribute(
                "aria-label",
                showPassword ? "Hide password" : "Show password",
            );
        });
    });
});
