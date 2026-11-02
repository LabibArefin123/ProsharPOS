/* =========================================
   PROBLEM UPLOAD CONFIGURATION
========================================= */

window.ProblemUpload = window.ProblemUpload || {};

(function (PU) {
    "use strict";

    PU.MAX_FILES = 8;
    PU.IMAGE_MAX_SIZE = 5 * 1024 * 1024;
    PU.PDF_MAX_SIZE = 10 * 1024 * 1024;

    PU.ALLOWED_IMAGES = ["image/jpeg", "image/png", "image/webp"];

    PU.ALLOWED_PDF = "application/pdf";

    PU.MIN_WIDTH = 300;
    PU.MIN_HEIGHT = 200;
    PU.MAX_WIDTH = 5000;
    PU.MAX_HEIGHT = 5000;

    PU.selectedFiles = [];
    PU.isUploading = false;
    PU.isAddingFiles = false;

    PU.init = function () {
        PU.form = document.getElementById("problemReportForm");
        PU.input = document.getElementById("problem_attachments");
        PU.uploadZone = document.querySelector(".problem-upload-zone");

        PU.preview = document.getElementById("problemFilePreview");
        PU.fileCount = document.getElementById("problemFileCount");

        PU.progressSection = document.getElementById("problemProgressSection");
        PU.progressBar = document.getElementById("problemProgressBar");
        PU.progressPercent = document.getElementById("problemProgressPercent");
        PU.progressStatus = document.getElementById("problemProgressStatus");
        PU.progressSize = document.getElementById("problemProgressSize");
        PU.progressList = document.getElementById("problemProgressList");

        PU.submitButton = document.getElementById("problemSubmitButton");
        PU.formMessage = document.getElementById("problemFormMessage");

        if (!PU.form) {
            console.warn("Problem Upload: #problemReportForm was not found.");
            return;
        }

        const requiredElements = [
            ["File input", PU.input],
            ["Upload preview", PU.preview],
            ["File count", PU.fileCount],
            ["Progress bar", PU.progressBar],
            ["Progress percentage", PU.progressPercent],
            ["Progress status", PU.progressStatus],
            ["Progress size", PU.progressSize],
            ["Progress list", PU.progressList],
            ["Submit button", PU.submitButton],
            ["Form message", PU.formMessage],
        ];

        requiredElements.forEach(function ([name, element]) {
            if (!element) {
                console.warn("Problem Upload: Missing element - " + name);
            }
        });

        if (
            !PU.input ||
            !PU.preview ||
            !PU.fileCount ||
            !PU.progressBar ||
            !PU.progressPercent ||
            !PU.progressStatus ||
            !PU.progressSize ||
            !PU.progressList ||
            !PU.submitButton ||
            !PU.formMessage
        ) {
            return;
        }

        if (typeof PU.bindFileSelection === "function") {
            PU.bindFileSelection();
        }

        if (typeof PU.renderPreview === "function") {
            PU.renderPreview();
        }

        if (typeof PU.resetProgress === "function") {
            PU.resetProgress();
        }
    };

    PU.formatSize = function (bytes) {
        bytes = Number(bytes) || 0;

        if (bytes < 1024) {
            return bytes + " B";
        }

        if (bytes < 1024 * 1024) {
            return (bytes / 1024).toFixed(1) + " KB";
        }

        return (bytes / (1024 * 1024)).toFixed(2) + " MB";
    };

    PU.showMessage = function (message, type) {
        if (!PU.formMessage) return;

        PU.formMessage.textContent = message || "";
        PU.formMessage.className =
            "problem-form-message" + (type ? " " + type : "");
    };

    PU.clearMessage = function () {
        PU.showMessage("", "");
    };

    PU.clearErrors = function () {
        if (!PU.form) return;

        PU.form.querySelectorAll(".problem-error").forEach(function (element) {
            element.textContent = "";
        });

        PU.form.querySelectorAll(".problem-field").forEach(function (element) {
            element.classList.remove("has-error");
        });
    };

    PU.showErrors = function (errors) {
        PU.clearErrors();

        Object.entries(errors || {}).forEach(function ([key, messages]) {
            const field = key.split(".")[0];

            const errorElement = Array.from(
                PU.form.querySelectorAll("[data-error]"),
            ).find(function (element) {
                return element.dataset.error === field;
            });

            if (errorElement) {
                errorElement.textContent = Array.isArray(messages)
                    ? messages[0]
                    : String(messages);
            }

            const fieldInput = Array.from(
                PU.form.querySelectorAll("[name]"),
            ).find(function (element) {
                return element.name === field || element.name === field + "[]";
            });

            const wrapper = fieldInput
                ? fieldInput.closest(".problem-field")
                : null;

            if (wrapper) {
                wrapper.classList.add("has-error");
            }
        });
    };

    PU.syncInputFiles = function () {
        if (!PU.input) return;

        if (typeof DataTransfer === "undefined") {
            console.warn("Problem Upload: DataTransfer is not supported.");
            return;
        }

        try {
            const transfer = new DataTransfer();

            PU.selectedFiles.forEach(function (item) {
                transfer.items.add(item.file);
            });

            PU.input.files = transfer.files;
        } catch (error) {
            console.error(
                "Problem Upload: Unable to synchronize files.",
                error,
            );
        }
    };

    PU.clearSelectedFiles = function () {
        PU.selectedFiles.forEach(function (item) {
            if (item.previewUrl) {
                URL.revokeObjectURL(item.previewUrl);
            }
        });

        PU.selectedFiles = [];

        if (PU.input) {
            PU.input.value = "";
        }

        PU.syncInputFiles();

        if (typeof PU.renderPreview === "function") {
            PU.renderPreview();
        }
    };

    PU.validateImageDimensions = function (file) {
        return new Promise(function (resolve) {
            const objectUrl = URL.createObjectURL(file);
            const image = new Image();

            image.onload = function () {
                const width = image.naturalWidth;
                const height = image.naturalHeight;

                URL.revokeObjectURL(objectUrl);

                if (width < PU.MIN_WIDTH || height < PU.MIN_HEIGHT) {
                    resolve({
                        valid: false,
                        message: "Minimum image dimensions: 300 × 200 pixels.",
                    });
                    return;
                }

                if (width > PU.MAX_WIDTH || height > PU.MAX_HEIGHT) {
                    resolve({
                        valid: false,
                        message:
                            "Maximum image dimensions: 5000 × 5000 pixels.",
                    });
                    return;
                }

                resolve({ valid: true });
            };

            image.onerror = function () {
                URL.revokeObjectURL(objectUrl);

                resolve({
                    valid: false,
                    message: "Unable to read this image.",
                });
            };

            image.src = objectUrl;
        });
    };

    PU.validateFile = async function (file) {
        if (PU.ALLOWED_IMAGES.includes(file.type)) {
            if (file.size > PU.IMAGE_MAX_SIZE) {
                return {
                    valid: false,
                    message: "Image size cannot exceed 5 MB.",
                };
            }

            return PU.validateImageDimensions(file);
        }

        if (file.type === PU.ALLOWED_PDF) {
            if (file.size > PU.PDF_MAX_SIZE) {
                return {
                    valid: false,
                    message: "PDF size cannot exceed 10 MB.",
                };
            }

            return { valid: true };
        }

        return {
            valid: false,
            message: "Only JPG, PNG, WEBP and PDF files are allowed.",
        };
    };

    document.addEventListener("DOMContentLoaded", function () {
        PU.init();
    });
})(window.ProblemUpload);
