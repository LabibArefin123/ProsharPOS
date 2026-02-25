document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("imageInput"); // inside modal
    const preview = document.getElementById("mainImagePreview");
    const sizeEl = document.getElementById("mainImageSize");
    const formatEl = document.getElementById("mainImageFormat");
    const dimEl = document.getElementById("mainImageDimension");
    const shapeEl = document.getElementById("mainImageShape");

    /* =====================================
               FUNCTION: Detect Image Info
            ===================================== */
    function detectImageInfo(imgSrc, file = null) {
        const img = new Image();
        img.onload = function () {
            // Dimension
            const width = img.width;
            const height = img.height;
            dimEl.textContent = width + " x " + height;

            // Shape Detection
            if (width === height) {
                shapeEl.innerHTML =
                    '<span class="badge badge-success">Square (50 x 50)</span>';
            } else if (width > height) {
                shapeEl.innerHTML =
                    '<span class="badge badge-info">Landscape (150 x 50)</span>';
            } else {
                shapeEl.innerHTML =
                    '<span class="badge badge-warning">Portrait (50 x 150)</span>';
            }
        };

        img.src = imgSrc;

        // File info (only if new upload)
        if (file) {
            // Size Format
            let size = file.size / 1024;
            if (size > 1024) {
                sizeEl.textContent = (size / 1024).toFixed(2) + " MB";
            } else {
                sizeEl.textContent = size.toFixed(1) + " KB";
            }

            // Format
            let format = file.type.split("/")[1]?.toUpperCase() ?? "Unknown";
            formatEl.textContent = format;
        }
    }

    /* =====================================
               LOAD EXISTING IMAGE INFO (ON PAGE LOAD)
            ===================================== */
    if (preview && preview.src && !preview.classList.contains("d-none")) {
        // Try to detect format from URL
        const urlParts = preview.src.split(".");
        const extension = urlParts[urlParts.length - 1].toUpperCase();

        formatEl.textContent = extension;
        sizeEl.textContent = "Saved Image";

        detectImageInfo(preview.src);
    }

    /* =====================================
               NEW IMAGE SELECT
            ===================================== */
    if (input) {
        input.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const imageURL = URL.createObjectURL(file);

            preview.src = imageURL;
            preview.classList.remove("d-none");

            detectImageInfo(imageURL, file);
        });
    }

    /* =====================================
               IMAGE ZOOM
            ===================================== */
    preview?.addEventListener("click", function () {
        const zoom = document.getElementById("zoomedImage");
        zoom.src = preview.src;
        $("#imageZoomModal").modal("show");
    });
});
