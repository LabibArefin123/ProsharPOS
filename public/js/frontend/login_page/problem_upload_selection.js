/* =========================================
   PROBLEM UPLOAD SELECTION
========================================= */

(function (PU) {
    "use strict";

    PU.removeFile = function (index) {
        if (PU.isUploading) return;

        const item = PU.selectedFiles[index];

        if (!item) return;

        if (item.previewUrl) {
            URL.revokeObjectURL(item.previewUrl);
        }

        PU.selectedFiles.splice(index, 1);

        PU.syncInputFiles();
        PU.renderPreview();
        PU.clearMessage();
    };

    PU.addFiles = async function (files) {
        if (PU.isUploading || PU.isAddingFiles) return;

        PU.isAddingFiles = true;
        PU.clearMessage();

        try {
            for (const file of Array.from(files || [])) {
                if (PU.selectedFiles.length >= PU.MAX_FILES) {
                    PU.showMessage(
                        "You can upload a maximum of 8 files.",
                        "error",
                    );
                    break;
                }

                const duplicate = PU.selectedFiles.some(function (item) {
                    return (
                        item.file.name === file.name &&
                        item.file.size === file.size &&
                        item.file.lastModified === file.lastModified
                    );
                });

                if (duplicate) {
                    continue;
                }

                const result = await PU.validateFile(file);

                if (!result.valid) {
                    PU.showMessage(file.name + ": " + result.message, "error");
                    continue;
                }

                PU.selectedFiles.push({
                    file: file,
                    previewUrl: PU.ALLOWED_IMAGES.includes(file.type)
                        ? URL.createObjectURL(file)
                        : null,
                });
            }
        } catch (error) {
            console.error("Problem Upload: File selection failed.", error);
            PU.showMessage("Unable to process the selected files.", "error");
        } finally {
            PU.isAddingFiles = false;

            PU.syncInputFiles();
            PU.renderPreview();
        }
    };

    PU.bindFileSelection = function () {
        if (!PU.input || PU.input.dataset.uploadBound === "true") {
            return;
        }

        PU.input.dataset.uploadBound = "true";

        PU.input.addEventListener("change", async function () {
            const files = Array.from(PU.input.files || []);

            await PU.addFiles(files);

            PU.syncInputFiles();
        });

        if (!PU.uploadZone) return;

        ["dragenter", "dragover"].forEach(function (eventName) {
            PU.uploadZone.addEventListener(eventName, function (event) {
                event.preventDefault();

                if (PU.isUploading) return;

                PU.uploadZone.classList.add("drag-over");
            });
        });

        ["dragleave", "drop"].forEach(function (eventName) {
            PU.uploadZone.addEventListener(eventName, function (event) {
                event.preventDefault();
                PU.uploadZone.classList.remove("drag-over");
            });
        });

        PU.uploadZone.addEventListener("drop", async function (event) {
            if (PU.isUploading) return;

            const files = event.dataTransfer ? event.dataTransfer.files : [];

            await PU.addFiles(files);
        });
    };
})(window.ProblemUpload);
