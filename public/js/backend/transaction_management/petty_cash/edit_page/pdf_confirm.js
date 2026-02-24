document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("attachmentInputEdit");
    const chooseBtn = document.getElementById("chooseFileBtnEdit");
    const displayInput = document.getElementById("attachmentDisplayEdit");
    const fileInfo = document.getElementById("fileInfoEdit");
    const previewArea = document.getElementById("previewAreaEdit");
    const progressCircle = document.getElementById("progressCircleEdit");
    const progressText = document.getElementById("progressTextEdit");

    const maxSize = 5 * 1024 * 1024; // 5MB

    chooseBtn.addEventListener("click", () => input.click());

    input.addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;

        const sizeMB = (file.size / 1024 / 1024).toFixed(2);

        // Reset progress
        progressCircle.style.strokeDashoffset = 408;
        progressText.innerText = "0%";

        if (file.type !== "application/pdf") {
            fileInfo.innerHTML = `
                [ Size: ${sizeMB} MB ] <br>
                <span class="text-danger">Only PDF allowed</span>
            `;
            input.value = "";
            displayInput.value = "";
            return;
        }

        if (file.size > maxSize) {
            fileInfo.innerHTML = `
                [ Size: ${sizeMB} MB ] <br>
                <span class="text-danger">File must be under 5MB</span>
            `;
            input.value = "";
            displayInput.value = "";
            return;
        }

        // Valid
        fileInfo.innerHTML = `
            [ Size: ${sizeMB} MB ] <br>
            <span class="text-success">Safe to upload</span>
        `;

        displayInput.value = file.name;

        // Animate progress
        let progress = 0;
        const circumference = 408;

        const interval = setInterval(() => {
            progress += 5;
            let offset = circumference - (progress / 100) * circumference;
            progressCircle.style.strokeDashoffset = offset;
            progressText.innerText = progress + "%";
            if (progress >= 100) clearInterval(interval);
        }, 40);

        // Preview PDF
        const reader = new FileReader();
        reader.onload = function (e) {
            previewArea.innerHTML = `
                <embed src="${e.target.result}"
                       type="application/pdf"
                       width="100%"
                       height="280px"/>
            `;
        };
        reader.readAsDataURL(file);
    });
});
