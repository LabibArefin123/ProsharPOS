document
    .getElementById("imageInputCreate")
    .addEventListener("change", async function (e) {
        const file = e.target.files[0];
        const status = document.getElementById("uploadStatusCreate");
        const sizeEl = document.getElementById("imageSizeCreate");
        const formatEl = document.getElementById("imageFormatCreate");
        const dimensionEl = document.getElementById("imageDimensionCreate");
        const progressText = document.getElementById("progressTextCreate");
        const progressCircle = document.getElementById(
            "progressCircleBarCreate",
        );
        const preview = document.getElementById("imagePreviewCreate");

        if (!file) return;

        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ["image/jpeg", "image/png", "image/webp"];

        // Reset preview
        preview.classList.add("d-none");
        preview.src = "#";

        // Circular progress helper
        const setProgress = (stage) => {
            const stages = 4;
            const percent = Math.round((stage / stages) * 100);
            const dashOffset = 314 - (314 * percent) / 100; // circle circumference 2πr ≈ 314
            progressCircle.style.strokeDashoffset = dashOffset;
            progressText.innerText = percent + "%";
        };

        // Stage 1: Uploading Image
        status.innerHTML = "Uploading image...";
        setProgress(1);
        await new Promise((r) => setTimeout(r, 400));

        // Stage 2: Validate Size
        const sizeMB = (file.size / 1024 / 1024).toFixed(2);
        sizeEl.innerText = sizeMB + " MB";

        if (file.size > maxSize) {
            status.innerHTML =
                '<span class="text-danger">Failed: File too large</span>';
            setProgress(0);
            return;
        }
        status.innerHTML = "Validating size...";
        setProgress(2);
        await new Promise((r) => setTimeout(r, 400));

        // Stage 3: Validate format & dimension
        formatEl.innerText = file.type;
        if (!allowedTypes.includes(file.type)) {
            status.innerHTML =
                '<span class="text-danger">Failed: Invalid format</span>';
            setProgress(0);
            return;
        }
        status.innerHTML = "Validating format & dimension...";

        const img = new Image();
        img.onload = function () {
            dimensionEl.innerText = img.width + " x " + img.height;

            // Stage 4: Supported & preview
            status.innerHTML =
                '<span class="text-success">Image is safe to upload ✔</span>';
            setProgress(4);

            preview.src = img.src;
            preview.classList.remove("d-none");
        };
        img.src = URL.createObjectURL(file);

        // Save temporary image object
        window.uploadedImageFile = file;
    });

// Use this image in hidden input on modal confirm
document.getElementById("useImageBtn").addEventListener("click", function () {
    if (window.uploadedImageFile) {
        const formData = new FormData();
        formData.append("image", window.uploadedImageFile);

        const hiddenInput = document.getElementById("hiddenImagePath");
        hiddenInput.files = window.uploadedImageFile
            ? window.uploadedImageFile
            : null;

        // Also update small preview
        const smallPreview = document.getElementById("createImagePreview");
        smallPreview.src = URL.createObjectURL(window.uploadedImageFile);
        smallPreview.classList.remove("d-none");
    }
});
