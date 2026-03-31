document.addEventListener("DOMContentLoaded", function () {
    /* ============================
               OPEN MODAL
            ============================ */
    document.querySelectorAll(".change-password-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;

            document.getElementById("modalUserName").innerText = userName;

            const form = document.getElementById("changePasswordForm");
            form.action = `/system-users/${userId}/change-password`;
            form.reset();

            // reset strength UI
            updateStrength("");
            hidePasswordMatchMessage();

            $("#changePasswordModal").modal("show");
        });
    });

    /* ============================
               EYE TOGGLE
            ============================ */
    document.querySelectorAll(".toggle-password").forEach((toggle) => {
        toggle.addEventListener("click", function () {
            const input = document.getElementById(this.dataset.target);
            const icon = this.querySelector("i");

            if (!input) return;

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        });
    });

    /* ============================
               PASSWORD STRENGTH & MATCH
            ============================ */
    const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("password_confirmation");

    passwordInput.addEventListener("keyup", handlePasswordInput);
    confirmInput.addEventListener("keyup", handlePasswordInput);

    function handlePasswordInput() {
        const pwd = passwordInput.value;
        const confirmPwd = confirmInput.value;

        updateStrength(pwd);
        checkPasswordMatch(pwd, confirmPwd);
    }

    function updateStrength(password) {
        let score = 0;
        const rules = {
            length: password.length >= 8,
            upper: /[A-Z]/.test(password),
            lower: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[^A-Za-z0-9]/.test(password),
        };

        Object.values(rules).forEach((val) => val && score++);

        // Update rules UI
        document.getElementById("rule-length").innerText = rules.length
            ? "✅ At least 8 characters"
            : "❌ At least 8 characters";
        document.getElementById("rule-upper").innerText = rules.upper
            ? "✅ Uppercase letter"
            : "❌ Uppercase letter";
        document.getElementById("rule-lower").innerText = rules.lower
            ? "✅ Lowercase letter"
            : "❌ Lowercase letter";
        document.getElementById("rule-number").innerText = rules.number
            ? "✅ Number"
            : "❌ Number";
        document.getElementById("rule-special").innerText = rules.special
            ? "✅ Special character"
            : "❌ Special character";

        // Update bar & text
        const bar = document.getElementById("strengthBar");
        const text = document.getElementById("strengthText");
        let percent = (score / 5) * 100;
        bar.style.width = percent + "%";

        if (score <= 2) {
            bar.className = "progress-bar bg-danger";
            text.innerText = "Weak Password";
        } else if (score <= 4) {
            bar.className = "progress-bar bg-warning";
            text.innerText = "Medium Strength";
        } else {
            bar.className = "progress-bar bg-success";
            text.innerText = "Strong Password";
        }
    }

    function checkPasswordMatch(password, confirmPassword) {
        const messageDiv = document.getElementById("passwordMatchMessage");
        const previewSpan = document.getElementById("newPasswordPreview");

        if (password && confirmPassword && password === confirmPassword) {
            messageDiv.style.display = "block";
            previewSpan.innerText = password;
        } else {
            hidePasswordMatchMessage();
        }
    }

    function hidePasswordMatchMessage() {
        document.getElementById("passwordMatchMessage").style.display = "none";
        document.getElementById("newPasswordPreview").innerText = "";
    }
});
