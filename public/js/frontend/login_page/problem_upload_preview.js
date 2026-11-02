/* =========================================
   PROBLEM UPLOAD PREVIEW
========================================= */

(function (PU) {
    "use strict";

    PU.renderPreview = function () {
        if (!PU.preview || !PU.fileCount) return;

        PU.preview.replaceChildren();

        const count = PU.selectedFiles.length;

        PU.fileCount.textContent = count + (count === 1 ? " file" : " files");

        if (count === 0) {
            const empty = document.createElement("div");
            empty.className = "problem-empty-files";

            const icon = document.createElement("i");
            icon.className = "far fa-folder-open";

            const message = document.createElement("p");
            message.textContent = "No attachments selected";

            empty.append(icon, message);
            PU.preview.appendChild(empty);

            if (PU.progressList) {
                PU.progressList.replaceChildren();
            }

            return;
        }

        PU.selectedFiles.forEach(function (item, index) {
            const file = item.file;
            const isImage = PU.ALLOWED_IMAGES.includes(file.type);

            const card = document.createElement("div");
            card.className = "problem-file-card";

            const thumb = document.createElement("div");
            thumb.className = "problem-file-thumb";

            if (isImage && item.previewUrl) {
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
            size.textContent = PU.formatSize(file.size);

            info.append(name, size);

            const remove = document.createElement("button");
            remove.type = "button";
            remove.className = "problem-file-remove";
            remove.innerHTML = '<i class="fas fa-times"></i>';
            remove.title = "Remove file";
            remove.setAttribute("aria-label", "Remove " + file.name);
            remove.disabled = PU.isUploading;

            remove.addEventListener("click", function () {
                PU.removeFile(index);
            });

            card.append(thumb, info, remove);
            PU.preview.appendChild(card);
        });

        PU.renderProgressList("Ready");
    };

    PU.renderProgressList = function (status) {
        if (!PU.progressList) return;

        PU.progressList.replaceChildren();

        PU.selectedFiles.forEach(function (item) {
            const row = document.createElement("div");
            row.className = "problem-progress-item";

            const icon = document.createElement("i");
            icon.className = PU.ALLOWED_IMAGES.includes(item.file.type)
                ? "far fa-image"
                : "far fa-file-pdf";

            const info = document.createElement("div");

            const name = document.createElement("strong");
            name.textContent = item.file.name;

            const size = document.createElement("small");
            size.textContent = PU.formatSize(item.file.size);

            info.append(name, size);

            const state = document.createElement("span");
            state.className = "progress-state";
            state.textContent = status || "Ready";

            row.append(icon, info, state);
            PU.progressList.appendChild(row);
        });
    };
})(window.ProblemUpload);
