/* =========================================
   PROBLEM UPLOAD SUBMISSION HELPERS
   Actual submit handler: file_progress.js
========================================= */

(function (PU) {
    "use strict";

    PU.setUploadingState = function (isUploading) {
        PU.isUploading = isUploading;

        if (!PU.submitButton) return;

        PU.submitButton.disabled = isUploading;
        PU.submitButton.setAttribute(
            "aria-busy",
            isUploading ? "true" : "false",
        );

        const label = PU.submitButton.querySelector("span");
        const icon = PU.submitButton.querySelector("i");

        if (label) {
            label.textContent = isUploading
                ? "Submitting..."
                : "Submit Problem";
        } else if (!icon) {
            PU.submitButton.textContent = isUploading
                ? "Submitting..."
                : "Submit Problem";
        }

        if (icon) {
            icon.className = isUploading
                ? "fas fa-spinner fa-spin"
                : "fas fa-paper-plane";
        }

        if (PU.input) {
            PU.input.disabled = isUploading;
        }

        if (PU.preview) {
            PU.preview
                .querySelectorAll(".problem-file-remove")
                .forEach(function (button) {
                    button.disabled = isUploading;
                });
        }
    };

    PU.resetProgress = function () {
        if (PU.progressBar) {
            PU.progressBar.style.width = "0%";
            PU.progressBar.style.background = "";
            PU.progressBar.setAttribute("aria-valuenow", "0");
        }

        if (PU.progressPercent) {
            PU.progressPercent.textContent = "0%";
        }

        if (PU.progressStatus) {
            PU.progressStatus.textContent = "Waiting for upload";
        }

        if (PU.progressSize) {
            PU.progressSize.textContent = "0 B / 0 B";
        }
    };

    PU.setProgress = function (percent, loaded, total, message) {
        const safePercent = Math.max(0, Math.min(100, percent));

        if (PU.progressBar) {
            PU.progressBar.style.width = safePercent + "%";
            PU.progressBar.setAttribute("aria-valuenow", String(safePercent));
        }

        if (PU.progressPercent) {
            PU.progressPercent.textContent = safePercent + "%";
        }

        if (PU.progressStatus) {
            PU.progressStatus.textContent =
                message || "Uploading attachments...";
        }

        if (PU.progressSize) {
            PU.progressSize.textContent =
                PU.formatSize(loaded) + " / " + PU.formatSize(total);
        }
    };
})(window.ProblemUpload);
