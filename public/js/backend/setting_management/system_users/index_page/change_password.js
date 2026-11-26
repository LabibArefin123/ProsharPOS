document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("changePasswordModal");
    const form = document.getElementById("changePasswordForm");

    if (!modal || !form) return;

    const modalUserName = document.getElementById("modalUserName");
    const modalUserEmail = document.getElementById("modalUserEmail");
    const modalUserUsername = document.getElementById("modalUserUsername");
    const modalUserPicture = document.getElementById("modalUserPicture");

    const defaultPicture = "{{ asset('uploads/images/default.jpg') }}";

    /* =====================================
       OPEN CHANGE PASSWORD MODAL
    ===================================== */

    document.querySelectorAll(".change-password-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;
            const userEmail = this.dataset.userEmail;
            const userUsername = this.dataset.userUsername;
            const userPicture = this.dataset.userPicture;

            // Reset form
            form.reset();

            // Reset visibility icons
            document.querySelectorAll(".toggle-password").forEach((toggle) => {
                const icon = toggle.querySelector("i");

                if (icon) {
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            });

            // Load selected user details
            modalUserName.textContent = userName;
            modalUserEmail.textContent = userEmail;
            modalUserUsername.textContent = userUsername;

            // Load profile picture
            modalUserPicture.onerror = function () {
                this.onerror = null;
                this.src = defaultPicture;
            };

            modalUserPicture.src = userPicture || defaultPicture;

            // Set form action
            form.action = `/system-users/${encodeURIComponent(userId)}/change-password`;

            // Open modal
            if (window.jQuery && typeof window.jQuery.fn.modal === "function") {
                window.jQuery(modal).modal("show");
            }
        });
    });

    /* =====================================
       PASSWORD VISIBILITY TOGGLE
    ===================================== */

    document.addEventListener("click", function (event) {
        const toggle = event.target.closest(".toggle-password");

        if (!toggle) return;

        const input = document.getElementById(toggle.dataset.target);
        const icon = toggle.querySelector("i");

        if (!input || !icon) return;

        const isPassword = input.type === "password";

        input.type = isPassword ? "text" : "password";

        icon.classList.toggle("fa-eye", !isPassword);
        icon.classList.toggle("fa-eye-slash", isPassword);

        toggle.setAttribute(
            "aria-label",
            isPassword ? "Hide password" : "Show password",
        );
    });

    /* =====================================
       RESET MODAL WHEN CLOSED
    ===================================== */

    if (window.jQuery) {
        window.jQuery(modal).on("hidden.bs.modal", function () {
            form.reset();

            modalUserName.textContent = "User Name";
            modalUserEmail.textContent = "Email";
            modalUserUsername.textContent = "Username";

            modalUserPicture.onerror = null;
            modalUserPicture.src = defaultPicture;

            form.removeAttribute("action");

            document.querySelectorAll(".toggle-password").forEach((toggle) => {
                const input = document.getElementById(toggle.dataset.target);
                const icon = toggle.querySelector("i");

                if (input) input.type = "password";

                if (icon) {
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            });
        });
    }
});
