/* XMLHttpRequest submission and upload progress */
(function (PU) {
    PU.resetProgress = function () {
        PU.progressBar.style.width = "0%";
        PU.progressPercent.textContent = "0%";
        PU.progressStatus.textContent = "Waiting for upload";
        PU.progressSize.textContent = "0 / 0 MB";
    };

    PU.setUploadingState = function (isUploading) {
        PU.submitButton.disabled = isUploading;
        PU.submitButton.querySelector("span").textContent =
            isUploading ? "Submitting..." : "Submit Problem";
        PU.submitButton.querySelector("i").className =
            isUploading ? "fas fa-spinner fa-spin" : "fas fa-paper-plane";
    };

    PU.submitForm = function () {
        PU.form.addEventListener("submit", function (event) {
            event.preventDefault();
            PU.clearMessage();
            PU.clearErrors();

            if (PU.selectedFiles.length > PU.MAX_FILES) {
                PU.showMessage("Maximum 8 attachments are allowed.", "error");
                return;
            }

            const formData = new FormData(PU.form);
            formData.delete("attachments[]");
            PU.selectedFiles.forEach(function (item) {
                formData.append("attachments[]", item.file);
            });

            const xhr = new XMLHttpRequest();
            xhr.open("POST", PU.form.action, true);
            xhr.setRequestHeader("Accept", "application/json");
            xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

            PU.setUploadingState(true);
            PU.progressSection.style.display = "block";
            PU.renderProgressList("Queued");

            const totalSize = PU.selectedFiles.reduce(function (total, item) {
                return total + item.file.size;
            }, 0);

            xhr.upload.addEventListener("progress", function (event) {
                if (!event.lengthComputable) return;
                const percent = Math.round((event.loaded / event.total) * 100);
                PU.progressBar.style.width = percent + "%";
                PU.progressPercent.textContent = percent + "%";
                PU.progressStatus.textContent = "Uploading attachments...";
                PU.progressSize.textContent =
                    PU.formatSize(event.loaded) + " / " + PU.formatSize(event.total);

                PU.progressList.querySelectorAll(".problem-progress-item").forEach(function (row) {
                    row.querySelector(".progress-state").textContent =
                        percent === 100 ? "Processing" : "Uploading";
                });
            });

            xhr.onload = function () {
                PU.setUploadingState(false);
                let response;
                try {
                    response = JSON.parse(xhr.responseText);
                } catch (error) {
                    PU.showMessage("Unexpected server response. Please try again.", "error");
                    PU.progressStatus.textContent = "Upload failed";
                    return;
                }

                if (xhr.status >= 200 && xhr.status < 300 && response.success) {
                    PU.progressBar.style.width = "100%";
                    PU.progressPercent.textContent = "100%";
                    PU.progressStatus.textContent = "Upload completed";
                    PU.progressList.querySelectorAll(".progress-state").forEach(function (state) {
                        state.textContent = "Completed";
                    });

                    PU.showMessage(
                        response.message + (response.problem_uid
                            ? " Reference: " + response.problem_uid : ""),
                        "success"
                    );

                    PU.form.reset();
                    PU.selectedFiles.forEach(function (item) {
                        if (item.previewUrl) URL.revokeObjectURL(item.previewUrl);
                    });
                    PU.selectedFiles = [];
                    PU.syncInputFiles();
                    PU.renderPreview();

                    const descriptionCount = document.getElementById("problemDescriptionCount");
                    if (descriptionCount) descriptionCount.textContent = "0";
                    return;
                }

                if (xhr.status === 422 && response.errors) {
                    PU.showErrors(response.errors);
                    PU.showMessage(
                        response.message || "Please correct the highlighted errors.",
                        "error"
                    );
                } else {
                    PU.showMessage(
                        response.message || "Unable to submit your problem report.",
                        "error"
                    );
                }
                PU.progressStatus.textContent = "Upload failed";
                PU.progressBar.style.background = "#dc5353";
            };

            xhr.onerror = function () {
                PU.setUploadingState(false);
                PU.showMessage("Network error. Please check your connection.", "error");
                PU.progressStatus.textContent = "Upload failed";
            };

            xhr.onabort = function () {
                PU.setUploadingState(false);
                PU.showMessage("Upload was cancelled.", "error");
                PU.progressStatus.textContent = "Cancelled";
            };

            xhr.send(formData);
        });
    };
})(window.ProblemUpload);
