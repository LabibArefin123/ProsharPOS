/* File selection, validation, removal and drag/drop */
(function (PU) {
    PU.removeFile = function (index) {
        const item = PU.selectedFiles[index];
        if (item && item.previewUrl) URL.revokeObjectURL(item.previewUrl);

        PU.selectedFiles.splice(index, 1);
        PU.syncInputFiles();
        PU.renderPreview();
        PU.clearMessage();
    };

    PU.addFiles = async function (files) {
        PU.clearMessage();

        for (const file of Array.from(files)) {
            if (PU.selectedFiles.length >= PU.MAX_FILES) {
                PU.showMessage("You can upload a maximum of 8 files.", "error");
                break;
            }

            const duplicate = PU.selectedFiles.some(function (item) {
                return item.file.name === file.name &&
                    item.file.size === file.size &&
                    item.file.lastModified === file.lastModified;
            });
            if (duplicate) continue;

            const result = await PU.validateFile(file);
            if (!result.valid) {
                PU.showMessage(file.name + ": " + result.message, "error");
                continue;
            }

            PU.selectedFiles.push({
                file: file,
                previewUrl: PU.ALLOWED_IMAGES.includes(file.type)
                    ? URL.createObjectURL(file) : null
            });
        }

        PU.syncInputFiles();
        PU.renderPreview();
    };

    PU.bindFileSelection = function () {
        PU.input.addEventListener("change", async function () {
            await PU.addFiles(PU.input.files);
            PU.syncInputFiles();
        });

        ["dragenter", "dragover"].forEach(function (eventName) {
            PU.uploadZone.addEventListener(eventName, function (event) {
                event.preventDefault();
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
            await PU.addFiles(event.dataTransfer.files);
            PU.syncInputFiles();
        });
    };
})(window.ProblemUpload);
