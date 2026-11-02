/* =========================================
   PROBLEM REPORT AJAX SUBMISSION
   Single submission handler
========================================= */

document.addEventListener("DOMContentLoaded", function () {
    const PU = window.ProblemUpload;

    if (!PU || !PU.form || !PU.submitButton) {
        return;
    }

    const form = PU.form;

    if (form.dataset.ajaxSubmitBound === "true") {
        return;
    }

    form.dataset.ajaxSubmitBound = "true";

    let activeRequest = null;
    let lastLoaded = 0;
    let lastTotal = 0;

    function setFileStatuses(status) {
        if (!PU.progressList) return;

        PU.progressList
            .querySelectorAll(".progress-state")
            .forEach(function (element) {
                element.textContent = status;
            });
    }

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');

        if (meta && meta.content) {
            return meta.content;
        }

        const input = form.querySelector('input[name="_token"]');

        return input ? input.value : "";
    }

    function buildFormData() {
        const formData = new FormData(form);

        // Remove any automatic file entries to avoid duplicates.
        formData.delete("attachments[]");
        formData.delete("attachments");

        PU.selectedFiles.forEach(function (item) {
            formData.append("attachments[]", item.file);
        });

        return formData;
    }

    function finishRequest() {
        activeRequest = null;

        PU.setUploadingState(false);
    }

    function showUploadFailure(message) {
        PU.showMessage(message, "error");

        if (PU.progressStatus) {
            PU.progressStatus.textContent = "Upload failed";
        }

        if (PU.progressBar) {
            PU.progressBar.style.background = "#dc5353";
        }

        setFileStatuses("Failed");
    }

    function parseResponse(xhr) {
        try {
            return JSON.parse(xhr.responseText || "{}");
        } catch (error) {
            return null;
        }
    }

    function handleSuccess(response) {
        PU.setProgress(100, lastTotal, lastTotal, "Upload completed");

        setFileStatuses("Completed");

        PU.showMessage(
            (response.message || "Problem report submitted successfully.") +
                (response.problem_uid
                    ? " Reference: " + response.problem_uid
                    : ""),
            "success",
        );

        // Clear form fields.
        form.reset();

        // Clear uploaded files and release preview URLs.
        PU.clearSelectedFiles();

        PU.clearErrors();

        // Reset description editor, if one is installed.
        form.dispatchEvent(new CustomEvent("problemReport:success"));

        // Reset progress after a successful submission.
        window.setTimeout(function () {
            if (!PU.isUploading) {
                PU.resetProgress();
            }
        }, 1200);
    }

    function handleFailure(xhr, response) {
        if (xhr.status === 422 && response && response.errors) {
            PU.showErrors(response.errors);

            PU.showMessage(
                response.message || "Please correct the highlighted fields.",
                "error",
            );

            const firstError = form.querySelector(
                ".problem-field.has-error .form-control, " +
                    ".problem-field.has-error input, " +
                    ".problem-field.has-error textarea",
            );

            if (firstError) {
                firstError.focus();
            }

            if (PU.progressStatus) {
                PU.progressStatus.textContent = "Validation failed";
            }

            setFileStatuses("Not uploaded");
            return;
        }

        if (xhr.status === 419) {
            showUploadFailure(
                "Your session has expired. Refresh the page and try again.",
            );
            return;
        }

        if (xhr.status === 401) {
            showUploadFailure(
                "Your session is no longer authenticated. Please log in again.",
            );
            return;
        }

        if (xhr.status === 413) {
            showUploadFailure(
                "The uploaded files are too large for the server to process.",
            );
            return;
        }

        if (xhr.status === 0) {
            showUploadFailure(
                "Unable to connect to the server. Please check your connection.",
            );
            return;
        }

        showUploadFailure(
            (response && response.message) ||
                "Unable to submit the problem report (HTTP " +
                    xhr.status +
                    ").",
        );
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        // Prevent duplicate requests.
        if (activeRequest || PU.isUploading) {
            return;
        }

        PU.clearMessage();
        PU.clearErrors();

        if (PU.isAddingFiles) {
            PU.showMessage(
                "Please wait while your attachments are being checked.",
                "error",
            );
            return;
        }

        if (PU.selectedFiles.length > PU.MAX_FILES) {
            PU.showMessage("Maximum 8 attachments are allowed.", "error");
            return;
        }

        // Check native HTML constraints.
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const xhr = new XMLHttpRequest();

        activeRequest = xhr;
        lastLoaded = 0;
        lastTotal = 0;

        try {
            const formData = buildFormData();

            xhr.open("POST", form.action, true);

            xhr.setRequestHeader("Accept", "application/json");

            xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

            const csrfToken = getCsrfToken();

            if (csrfToken) {
                xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
            }

            PU.setUploadingState(true);

            if (PU.progressSection) {
                PU.progressSection.style.display = "block";
            }

            PU.resetProgress();
            PU.renderProgressList("Queued");

            if (PU.progressStatus) {
                PU.progressStatus.textContent = "Starting upload...";
            }

            xhr.upload.addEventListener("loadstart", function () {
                if (PU.progressStatus) {
                    PU.progressStatus.textContent = "Uploading attachments...";
                }
            });

            xhr.upload.addEventListener("progress", function (uploadEvent) {
                if (!uploadEvent.lengthComputable) return;

                lastLoaded = uploadEvent.loaded;
                lastTotal = uploadEvent.total;

                const percent = Math.round(
                    (uploadEvent.loaded / uploadEvent.total) * 100,
                );

                PU.setProgress(
                    percent,
                    uploadEvent.loaded,
                    uploadEvent.total,
                    percent >= 100
                        ? "Upload sent. Waiting for server..."
                        : "Uploading attachments...",
                );

                setFileStatuses(percent >= 100 ? "Processing" : "Uploading");
            });

            xhr.addEventListener("load", function () {
                const response = parseResponse(xhr);

                finishRequest();

                if (!response) {
                    showUploadFailure(
                        "The server returned an unexpected response (HTTP " +
                            xhr.status +
                            ").",
                    );
                    return;
                }

                if (
                    xhr.status >= 200 &&
                    xhr.status < 300 &&
                    response.success === true
                ) {
                    handleSuccess(response);
                    return;
                }

                handleFailure(xhr, response);
            });

            xhr.addEventListener("error", function () {
                finishRequest();

                showUploadFailure(
                    "Network error. Please check your internet connection.",
                );
            });

            xhr.addEventListener("abort", function () {
                finishRequest();

                showUploadFailure(
                    "The upload was cancelled. Please try again.",
                );
            });

            xhr.addEventListener("timeout", function () {
                finishRequest();

                showUploadFailure("The upload timed out. Please try again.");
            });

            // 3 minutes; adjust if your server allows longer uploads.
            xhr.timeout = 180000;

            xhr.send(formData);
        } catch (error) {
            console.error("Problem report submission error:", error);

            finishRequest();

            showUploadFailure(
                "Something went wrong while preparing your report.",
            );
        }
    });
});
