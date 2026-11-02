document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("problemReportForm");
    const input = document.getElementById("problem_attachments");
    const uploadZone = document.querySelector(".problem-upload-zone");

    if (!form || !input || !uploadZone) return;

    const preview = document.getElementById("problemFilePreview");
    const fileCount = document.getElementById("problemFileCount");
    const progressSection = document.getElementById("problemProgressSection");
    const progressBar = document.getElementById("problemProgressBar");
    const progressPercent = document.getElementById("problemProgressPercent");
    const progressStatus = document.getElementById("problemProgressStatus");
    const progressSize = document.getElementById("problemProgressSize");
    const progressList = document.getElementById("problemProgressList");
    const submitButton = document.getElementById("problemSubmitButton");
    const formMessage = document.getElementById("problemFormMessage");

    const MAX_FILES = 8;
    const IMAGE_MAX_SIZE = 5 * 1024 * 1024;
    const PDF_MAX_SIZE = 10 * 1024 * 1024;

    const ALLOWED_IMAGES = ["image/jpeg", "image/png", "image/webp"];

    const ALLOWED_PDF = "application/pdf";

    const MIN_WIDTH = 300;
    const MIN_HEIGHT = 200;
    const MAX_WIDTH = 5000;
    const MAX_HEIGHT = 5000;

    let selectedFiles = [];

    // ---------------------------------
    // HELPERS
    // ---------------------------------

    function formatSize(bytes) {
        return bytes >= 1024 * 1024
            ? (bytes / (1024 * 1024)).toFixed(2) + " MB"
            : (bytes / 1024).toFixed(1) + " KB";
    }

    function showMessage(message, type) {
        formMessage.textContent = message;
        formMessage.className = "problem-form-message " + type;
    }

    function clearMessage() {
        formMessage.textContent = "";
        formMessage.className = "problem-form-message";
    }

    function clearErrors() {
        document.querySelectorAll(".problem-error").forEach(function (element) {
            element.textContent = "";
        });

        document.querySelectorAll(".problem-field").forEach(function (element) {
            element.classList.remove("has-error");
        });
    }

    function showErrors(errors) {
        clearErrors();

        Object.keys(errors).forEach(function (key) {
            let field = key.split(".")[0];

            let errorElement = document.querySelector(
                '[data-error="' + field + '"]',
            );

            if (errorElement) {
                errorElement.textContent = errors[key][0];
            }

            const inputElement = form.querySelector(
                '[name="' + field + '"], [name="' + field + '[]"]',
            );

            if (inputElement) {
                const fieldWrapper = inputElement.closest(".problem-field");

                if (fieldWrapper) {
                    fieldWrapper.classList.add("has-error");
                }
            }
        });
    }

    function syncInputFiles() {
        const dataTransfer = new DataTransfer();

        selectedFiles.forEach(function (item) {
            dataTransfer.items.add(item.file);
        });

        input.files = dataTransfer.files;
    }

    // ---------------------------------
    // IMAGE DIMENSION VALIDATION
    // ---------------------------------

    function validateImageDimensions(file) {
        return new Promise(function (resolve) {
            const objectUrl = URL.createObjectURL(file);
            const image = new Image();

            image.onload = function () {
                const width = image.naturalWidth;
                const height = image.naturalHeight;

                URL.revokeObjectURL(objectUrl);

                if (width < MIN_WIDTH || height < MIN_HEIGHT) {
                    resolve({
                        valid: false,
                        message: "Minimum image dimensions: 300 × 200 pixels.",
                    });

                    return;
                }

                if (width > MAX_WIDTH || height > MAX_HEIGHT) {
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
    }

    async function validateFile(file) {
        if (ALLOWED_IMAGES.includes(file.type)) {
            if (file.size > IMAGE_MAX_SIZE) {
                return {
                    valid: false,
                    message: "Image size cannot exceed 5 MB.",
                };
            }

            return await validateImageDimensions(file);
        }

        if (file.type === ALLOWED_PDF) {
            if (file.size > PDF_MAX_SIZE) {
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
    }

    // ---------------------------------
    // FILE PREVIEW
    // ---------------------------------

    function renderPreview() {
        preview.innerHTML = "";

        fileCount.textContent =
            selectedFiles.length +
            (selectedFiles.length === 1 ? " file" : " files");

        if (selectedFiles.length === 0) {
            preview.innerHTML = `
                <div class="problem-empty-files">
                    <i class="far fa-folder-open"></i>
                    <p>No attachments selected</p>
                </div>
            `;

            progressList.innerHTML = "";
            return;
        }

        selectedFiles.forEach(function (item, index) {
            const file = item.file;
            const isImage = ALLOWED_IMAGES.includes(file.type);

            const card = document.createElement("div");
            card.className = "problem-file-card";

            const thumb = document.createElement("div");
            thumb.className = "problem-file-thumb";

            if (isImage) {
                const image = document.createElement("img");
                image.src = item.previewUrl;
                image.alt = file.name;
                thumb.appendChild(image);
            } else {
                const icon = document.createElement("i");
                icon.className = "fas fa-file-pdf";
                thumb.appendChild(icon);
            }

            const info = document.createElement("div");
            info.className = "problem-file-info";

            const name = document.createElement("span");
            name.className = "problem-file-name";
            name.textContent = file.name;
            name.title = file.name;

            const size = document.createElement("span");
            size.className = "problem-file-size";
            size.textContent = formatSize(file.size);

            info.appendChild(name);
            info.appendChild(size);

            const remove = document.createElement("button");
            remove.type = "button";
            remove.className = "problem-file-remove";
            remove.innerHTML = '<i class="fas fa-times"></i>';
            remove.title = "Remove file";

            remove.addEventListener("click", function () {
                removeFile(index);
            });

            card.appendChild(thumb);
            card.appendChild(info);
            card.appendChild(remove);

            preview.appendChild(card);
        });

        renderProgressList();
    }

    function renderProgressList() {
        progressList.innerHTML = "";

        selectedFiles.forEach(function (item) {
            const row = document.createElement("div");
            row.className = "problem-progress-item";

            const icon = document.createElement("i");

            icon.className = ALLOWED_IMAGES.includes(item.file.type)
                ? "far fa-image"
                : "far fa-file-pdf";

            const info = document.createElement("div");

            const name = document.createElement("strong");
            name.textContent = item.file.name;

            const size = document.createElement("small");
            size.textContent = formatSize(item.file.size);

            info.appendChild(name);
            info.appendChild(size);

            const state = document.createElement("span");
            state.className = "progress-state";
            state.textContent = "Ready";

            row.appendChild(icon);
            row.appendChild(info);
            row.appendChild(state);

            progressList.appendChild(row);
        });
    }

    // ---------------------------------
    // REMOVE FILE
    // ---------------------------------

    function removeFile(index) {
        const item = selectedFiles[index];

        if (item && item.previewUrl) {
            URL.revokeObjectURL(item.previewUrl);
        }

        selectedFiles.splice(index, 1);

        syncInputFiles();
        renderPreview();
        clearMessage();
    }

    // ---------------------------------
    // ADD FILES
    // ---------------------------------

    async function addFiles(files) {
        clearMessage();

        for (const file of Array.from(files)) {
            if (selectedFiles.length >= MAX_FILES) {
                showMessage("You can upload a maximum of 8 files.", "error");
                break;
            }

            const duplicate = selectedFiles.some(function (item) {
                return (
                    item.file.name === file.name &&
                    item.file.size === file.size &&
                    item.file.lastModified === file.lastModified
                );
            });

            if (duplicate) {
                continue;
            }

            const result = await validateFile(file);

            if (!result.valid) {
                showMessage(file.name + ": " + result.message, "error");
                continue;
            }

            selectedFiles.push({
                file: file,
                previewUrl: ALLOWED_IMAGES.includes(file.type)
                    ? URL.createObjectURL(file)
                    : null,
            });
        }

        syncInputFiles();
        renderPreview();
    }

    input.addEventListener("change", async function () {
        await addFiles(input.files);
        syncInputFiles();
    });

    // ---------------------------------
    // DRAG AND DROP
    // ---------------------------------

    ["dragenter", "dragover"].forEach(function (eventName) {
        uploadZone.addEventListener(eventName, function (event) {
            event.preventDefault();
            uploadZone.classList.add("drag-over");
        });
    });

    ["dragleave", "drop"].forEach(function (eventName) {
        uploadZone.addEventListener(eventName, function (event) {
            event.preventDefault();
            uploadZone.classList.remove("drag-over");
        });
    });

    uploadZone.addEventListener("drop", async function (event) {
        await addFiles(event.dataTransfer.files);
        syncInputFiles();
    });

    // ---------------------------------
    // UPLOAD PROGRESS
    // ---------------------------------

    function resetProgress() {
        progressBar.style.width = "0%";
        progressPercent.textContent = "0%";
        progressStatus.textContent = "Waiting for upload";
        progressSize.textContent = "0 / 0 MB";
    }

    function setUploadingState(isUploading) {
        submitButton.disabled = isUploading;

        submitButton.querySelector("span").textContent = isUploading
            ? "Submitting..."
            : "Submit Problem";

        submitButton.querySelector("i").className = isUploading
            ? "fas fa-spinner fa-spin"
            : "fas fa-paper-plane";
    }

    // ---------------------------------
    // FORM SUBMISSION
    // ---------------------------------

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        clearMessage();
        clearErrors();

        if (selectedFiles.length > MAX_FILES) {
            showMessage("Maximum 8 attachments are allowed.", "error");
            return;
        }

        const formData = new FormData(form);

        // Replace the input file list with the validated selection.
        formData.delete("attachments[]");

        selectedFiles.forEach(function (item) {
            formData.append("attachments[]", item.file);
        });

        const xhr = new XMLHttpRequest();

        xhr.open("POST", form.action, true);

        xhr.setRequestHeader("Accept", "application/json");
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

        setUploadingState(true);

        progressSection.style.display = "block";
        progressList.innerHTML = "";

        const totalSize = selectedFiles.reduce(function (total, item) {
            return total + item.file.size;
        }, 0);

        // Show each selected file in the upload list.
        selectedFiles.forEach(function (item) {
            const row = document.createElement("div");
            row.className = "problem-progress-item";

            const icon = document.createElement("i");
            icon.className = ALLOWED_IMAGES.includes(item.file.type)
                ? "far fa-image"
                : "far fa-file-pdf";

            const info = document.createElement("div");

            const name = document.createElement("strong");
            name.textContent = item.file.name;

            const size = document.createElement("small");
            size.textContent = formatSize(item.file.size);

            info.appendChild(name);
            info.appendChild(size);

            const state = document.createElement("span");
            state.className = "progress-state";
            state.textContent = "Queued";

            row.appendChild(icon);
            row.appendChild(info);
            row.appendChild(state);

            progressList.appendChild(row);
        });

        xhr.upload.addEventListener("progress", function (event) {
            if (!event.lengthComputable) return;

            const percent = Math.round((event.loaded / event.total) * 100);

            progressBar.style.width = percent + "%";
            progressPercent.textContent = percent + "%";

            progressStatus.textContent = "Uploading attachments...";

            progressSize.textContent =
                formatSize(event.loaded) + " / " + formatSize(event.total);

            // The browser reports total request progress, not separate
            // per-file progress. Update the list consistently.
            const rows = progressList.querySelectorAll(
                ".problem-progress-item",
            );

            rows.forEach(function (row) {
                row.querySelector(".progress-state").textContent =
                    percent === 100 ? "Processing" : "Uploading";
            });
        });

        xhr.onload = function () {
            setUploadingState(false);

            let response;

            try {
                response = JSON.parse(xhr.responseText);
            } catch (error) {
                showMessage(
                    "Unexpected server response. Please try again.",
                    "error",
                );
                progressStatus.textContent = "Upload failed";
                return;
            }

            if (xhr.status >= 200 && xhr.status < 300 && response.success) {
                progressBar.style.width = "100%";
                progressPercent.textContent = "100%";
                progressStatus.textContent = "Upload completed";

                progressList
                    .querySelectorAll(".progress-state")
                    .forEach(function (state) {
                        state.textContent = "Completed";
                    });

                showMessage(
                    response.message +
                        (response.problem_uid
                            ? " Reference: " + response.problem_uid
                            : ""),
                    "success",
                );

                form.reset();

                selectedFiles.forEach(function (item) {
                    if (item.previewUrl) {
                        URL.revokeObjectURL(item.previewUrl);
                    }
                });

                selectedFiles = [];
                syncInputFiles();
                renderPreview();

                document.getElementById("problemDescriptionCount").textContent =
                    "0";

                return;
            }

            if (xhr.status === 422 && response.errors) {
                showErrors(response.errors);
                showMessage(
                    response.message ||
                        "Please correct the highlighted errors.",
                    "error",
                );
            } else {
                showMessage(
                    response.message || "Unable to submit your problem report.",
                    "error",
                );
            }

            progressStatus.textContent = "Upload failed";
            progressBar.style.background = "#dc5353";
        };

        xhr.onerror = function () {
            setUploadingState(false);
            showMessage(
                "Network error. Please check your connection.",
                "error",
            );
            progressStatus.textContent = "Upload failed";
        };

        xhr.onabort = function () {
            setUploadingState(false);
            showMessage("Upload was cancelled.", "error");
            progressStatus.textContent = "Cancelled";
        };

        xhr.send(formData);
    });

    // Initial state.
    resetProgress();
    renderPreview();
});
