/* Selected file cards and upload-list rendering */
(function (PU) {
    PU.renderPreview = function () {
        PU.preview.innerHTML = "";
        PU.fileCount.textContent = PU.selectedFiles.length +
            (PU.selectedFiles.length === 1 ? " file" : " files");

        if (PU.selectedFiles.length === 0) {
            PU.preview.innerHTML = `
                <div class="problem-empty-files">
                    <i class="far fa-folder-open"></i>
                    <p>No attachments selected</p>
                </div>`;
            PU.progressList.innerHTML = "";
            return;
        }

        PU.selectedFiles.forEach(function (item, index) {
            const file = item.file;
            const isImage = PU.ALLOWED_IMAGES.includes(file.type);
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
            size.textContent = PU.formatSize(file.size);
            info.appendChild(name);
            info.appendChild(size);

            const remove = document.createElement("button");
            remove.type = "button";
            remove.className = "problem-file-remove";
            remove.innerHTML = '<i class="fas fa-times"></i>';
            remove.title = "Remove file";
            remove.addEventListener("click", function () {
                PU.removeFile(index);
            });

            card.appendChild(thumb);
            card.appendChild(info);
            card.appendChild(remove);
            PU.preview.appendChild(card);
        });

        PU.renderProgressList("Ready");
    };

    PU.renderProgressList = function (status) {
        PU.progressList.innerHTML = "";
        PU.selectedFiles.forEach(function (item) {
            const row = document.createElement("div");
            row.className = "problem-progress-item";
            const icon = document.createElement("i");
            icon.className = PU.ALLOWED_IMAGES.includes(item.file.type)
                ? "far fa-image" : "far fa-file-pdf";

            const info = document.createElement("div");
            const name = document.createElement("strong");
            name.textContent = item.file.name;
            const size = document.createElement("small");
            size.textContent = PU.formatSize(item.file.size);
            info.appendChild(name);
            info.appendChild(size);

            const state = document.createElement("span");
            state.className = "progress-state";
            state.textContent = status || "Ready";

            row.appendChild(icon);
            row.appendChild(info);
            row.appendChild(state);
            PU.progressList.appendChild(row);
        });
    };
})(window.ProblemUpload);
