document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("attachmentInput");
    const chooseBtn = document.getElementById("chooseFileBtn");
    const fileInfo = document.getElementById("fileInfo");
    const previewArea = document.getElementById("previewArea");
    const progressCircle = document.getElementById("progressCircle");
    const progressText = document.getElementById("progressText");
    const displayInput = document.getElementById("attachmentDisplay");

    const maxSize = 5 * 1024 * 1024; // 5MB
    const allowedTypes = [
        "image/jpeg",
        "image/png",
        "image/jpg",
        "application/pdf",
    ];

    chooseBtn.addEventListener("click", () => input.click());

    input.addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;

        const sizeMB = (file.size / 1024 / 1024).toFixed(2);
        const isValidType = allowedTypes.includes(file.type);
        const isValidSize = file.size <= maxSize;

        // File info display
        fileInfo.innerHTML = `
            [ Size: ${sizeMB} MB ] <br>
            [ Type: ${file.type} ] <br>
            [ ${
                isValidType && isValidSize
                    ? '<span class="text-success">Safe to upload</span>'
                    : '<span class="text-danger">Error: Invalid file</span>'
            } ]
        `;

        // Reset progress
        let progress = 0;
        let circumference = 408;
        progressCircle.style.strokeDashoffset = circumference;

        const interval = setInterval(() => {
            progress += 5;
            let offset = circumference - (progress / 100) * circumference;
            progressCircle.style.strokeDashoffset = offset;
            progressText.innerText = progress + "%";

            if (progress >= 100) clearInterval(interval);
        }, 40);

        input.addEventListener("change", function () {
            if (this.files.length > 0) {
                displayInput.value = this.files[0].name;
            } else {
                displayInput.value = "";
            }
        });

        // Preview
        previewArea.innerHTML = "";

        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewArea.innerHTML = `<img src="${e.target.result}" 
                    style="max-width:100%; height:auto;">`;
            };
            reader.readAsDataURL(file);
        } else if (file.type === "application/pdf") {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewArea.innerHTML = `
                    <embed src="${e.target.result}" 
                    type="application/pdf" width="100%" height="280px"/>
                `;
            };
            reader.readAsDataURL(file);
        } else {
            previewArea.innerHTML =
                "<p class='text-danger'>No preview available</p>";
        }
    });
});
