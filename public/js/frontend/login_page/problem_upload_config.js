/* File upload constants and shared utilities */
window.ProblemUpload = window.ProblemUpload || {};

(function (PU) {
    PU.MAX_FILES = 8;
    PU.IMAGE_MAX_SIZE = 5 * 1024 * 1024;
    PU.PDF_MAX_SIZE = 10 * 1024 * 1024;
    PU.ALLOWED_IMAGES = ["image/jpeg", "image/png", "image/webp"];
    PU.ALLOWED_PDF = "application/pdf";
    PU.MIN_WIDTH = 300;
    PU.MIN_HEIGHT = 200;
    PU.MAX_WIDTH = 5000;
    PU.MAX_HEIGHT = 5000;

    PU.formatSize = function (bytes) {
        return bytes >= 1024 * 1024
            ? (bytes / (1024 * 1024)).toFixed(2) + " MB"
            : (bytes / 1024).toFixed(1) + " KB";
    };

    PU.showMessage = function (message, type) {
        PU.formMessage.textContent = message;
        PU.formMessage.className = "problem-form-message " + type;
    };

    PU.clearMessage = function () {
        PU.formMessage.textContent = "";
        PU.formMessage.className = "problem-form-message";
    };

    PU.clearErrors = function () {
        document.querySelectorAll(".problem-error").forEach(function (element) {
            element.textContent = "";
        });
        document.querySelectorAll(".problem-field").forEach(function (element) {
            element.classList.remove("has-error");
        });
    };

    PU.showErrors = function (errors) {
        PU.clearErrors();
        Object.keys(errors).forEach(function (key) {
            const field = key.split(".")[0];
            const errorElement = document.querySelector('[data-error="' + field + '"]');
            if (errorElement) errorElement.textContent = errors[key][0];

            const inputElement = PU.form.querySelector(
                '[name="' + field + '"], [name="' + field + '[]"]'
            );
            if (inputElement) {
                const fieldWrapper = inputElement.closest(".problem-field");
                if (fieldWrapper) fieldWrapper.classList.add("has-error");
            }
        });
    };

    PU.syncInputFiles = function () {
        const dataTransfer = new DataTransfer();
        PU.selectedFiles.forEach(function (item) {
            dataTransfer.items.add(item.file);
        });
        PU.input.files = dataTransfer.files;
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
                    resolve({ valid: false, message: "Minimum image dimensions: 300 × 200 pixels." });
                    return;
                }
                if (width > PU.MAX_WIDTH || height > PU.MAX_HEIGHT) {
                    resolve({ valid: false, message: "Maximum image dimensions: 5000 × 5000 pixels." });
                    return;
                }
                resolve({ valid: true });
            };

            image.onerror = function () {
                URL.revokeObjectURL(objectUrl);
                resolve({ valid: false, message: "Unable to read this image." });
            };
            image.src = objectUrl;
        });
    };

    PU.validateFile = async function (file) {
        if (PU.ALLOWED_IMAGES.includes(file.type)) {
            if (file.size > PU.IMAGE_MAX_SIZE) {
                return { valid: false, message: "Image size cannot exceed 5 MB." };
            }
            return await PU.validateImageDimensions(file);
        }
        if (file.type === PU.ALLOWED_PDF) {
            if (file.size > PU.PDF_MAX_SIZE) {
                return { valid: false, message: "PDF size cannot exceed 10 MB." };
            }
            return { valid: true };
        }
        return { valid: false, message: "Only JPG, PNG, WEBP and PDF files are allowed." };
    };
})(window.ProblemUpload);
