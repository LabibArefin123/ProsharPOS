document.addEventListener("DOMContentLoaded", function () {
    const problemModal = document.getElementById("problemModal");

    // Open problem modal.
    window.openProblemModal = function () {
        if (problemModal) {
            problemModal.classList.add("active");
            document.body.classList.add("problem-modal-open");
        }
    };

    // Close problem modal.
    window.closeProblemModal = function () {
        if (problemModal) {
            problemModal.classList.remove("active");
            document.body.classList.remove("problem-modal-open");
        }
    };

    // Close when clicking outside the modal.
    if (problemModal) {
        problemModal.addEventListener("click", function (event) {
            if (event.target === problemModal) {
                window.closeProblemModal();
            }
        });
    }

    // Escape key.
    document.addEventListener("keydown", function (event) {
        if (
            event.key === "Escape" &&
            problemModal?.classList.contains("active")
        ) {
            window.closeProblemModal();
        }
    });

    // Password visibility.
    document.querySelectorAll(".toggle-password").forEach(function (button) {
        button.addEventListener("click", function () {
            const input = document.getElementById(
                button.getAttribute("data-target"),
            );

            if (!input) return;

            const isPassword = input.type === "password";

            input.type = isPassword ? "text" : "password";

            const icon = button.querySelector("i");

            if (icon) {
                icon.classList.toggle("fa-eye", !isPassword);
                icon.classList.toggle("fa-eye-slash", isPassword);
            }
        });
    });

    // Description character counter.
    const description = document.getElementById("problem_description");
    const descriptionCount = document.getElementById("problemDescriptionCount");

    if (description && descriptionCount) {
        description.addEventListener("input", function () {
            descriptionCount.textContent = description.value.length;
        });
    }
});
