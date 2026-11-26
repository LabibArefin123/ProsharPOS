/* =========================================================
   GLOBAL IMAGE MODAL - IMAGE INFORMATION
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("global_image");

    if (!modal) return;

    const fields = {
        thumbnail: modal.querySelector("#globalImageInfoThumbnail"),
        name: modal.querySelector("#globalImageInfoName"),
        type: modal.querySelector("#globalImageInfoType"),
        dimensions: modal.querySelector("#globalImageInfoDimensions"),
        orientation: modal.querySelector("#globalImageInfoOrientation"),
        ratio: modal.querySelector("#globalImageInfoRatio"),
        size: modal.querySelector("#globalImageInfoSize"),
        path: modal.querySelector("#globalImageInfoPath"),
        copy: modal.querySelector("#globalImageCopyPath"),
    };

    if (Object.values(fields).some((field) => !field)) {
        return;
    }

    let currentPath = "";
    let requestNumber = 0;

    function getFileName(url) {
        try {
            const pathname = new URL(url).pathname;
            const fileName = pathname.split("/").pop();

            return decodeURIComponent(fileName || "Unknown image");
        } catch {
            return "Unknown image";
        }
    }

    function getExtension(url) {
        const fileName = getFileName(url);
        const match = fileName.match(/\.([^.]+)$/);

        return match ? match[1].toUpperCase() : "Unknown";
    }

    function getOrientation(width, height) {
        if (!width || !height) return "Unknown";

        if (width === height) return "Square";

        if (width > height) return "Landscape";

        return "Portrait";
    }

    function getAspectRatio(width, height) {
        if (!width || !height) return "Unknown";

        function gcd(a, b) {
            return b === 0 ? a : gcd(b, a % b);
        }

        const divisor = gcd(width, height);

        return `${width / divisor}:${height / divisor}`;
    }

    function formatSize(bytes) {
        if (bytes === null || !Number.isFinite(bytes)) {
            return "Unavailable";
        }

        if (bytes < 1024) {
            return `${bytes} Bytes`;
        }

        if (bytes < 1024 * 1024) {
            return `${(bytes / 1024).toFixed(2)} KB`;
        }

        if (bytes < 1024 * 1024 * 1024) {
            return `${(bytes / (1024 * 1024)).toFixed(2)} MB`;
        }

        return `${(bytes / (1024 * 1024 * 1024)).toFixed(2)} GB`;
    }

    function resetInfo() {
        requestNumber++;

        currentPath = "";

        fields.thumbnail.removeAttribute("src");

        fields.name.textContent = "—";
        fields.type.textContent = "—";
        fields.dimensions.textContent = "—";
        fields.orientation.textContent = "—";
        fields.ratio.textContent = "—";
        fields.size.textContent = "—";
        fields.path.textContent = "—";
    }

    async function loadImageInfo(data) {
        if (!data || !data.url) return;

        const currentRequest = ++requestNumber;

        const url = data.url;
        const width = data.width || 0;
        const height = data.height || 0;

        currentPath = url;

        fields.thumbnail.src = url;
        fields.name.textContent = getFileName(url);
        fields.type.textContent = getExtension(url);
        fields.dimensions.textContent =
            width && height ? `${width} × ${height} px` : "Unavailable";

        fields.orientation.textContent = getOrientation(width, height);

        fields.ratio.textContent = getAspectRatio(width, height);

        fields.path.textContent = url;
        fields.size.textContent = "Checking...";

        try {
            const response = await fetch(url, {
                method: "HEAD",
                cache: "no-store",
            });

            if (!response.ok) {
                throw new Error("Unable to retrieve image headers.");
            }

            if (currentRequest !== requestNumber) return;

            const contentType = response.headers.get("content-type");
            const contentLength = response.headers.get("content-length");

            if (contentType) {
                fields.type.textContent = contentType
                    .split("/")
                    .pop()
                    .split(";")[0]
                    .toUpperCase();
            }

            fields.size.textContent = contentLength
                ? formatSize(Number(contentLength))
                : "Unavailable";
        } catch (error) {
            if (currentRequest !== requestNumber) return;

            fields.size.textContent = "Unavailable";
        }
    }

    document.addEventListener("global-image:loaded", function (event) {
        loadImageInfo(event.detail);
    });

    document.addEventListener("global-image:reset", resetInfo);

    fields.copy.addEventListener("click", async function () {
        if (!currentPath) return;

        try {
            await navigator.clipboard.writeText(currentPath);

            const originalIcon = fields.copy.innerHTML;

            fields.copy.innerHTML = '<i class="fas fa-check"></i>';

            setTimeout(() => {
                fields.copy.innerHTML = originalIcon;
            }, 1500);
        } catch (error) {
            window.prompt("Copy image path:", currentPath);
        }
    });
});
