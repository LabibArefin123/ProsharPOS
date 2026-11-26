/* =========================================================
   GLOBAL IMAGE MODAL
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
    const modalElement = document.getElementById("global_image");

    if (!modalElement || typeof bootstrap === "undefined") {
        return;
    }

    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

    const image = modalElement.querySelector("#globalImagePreview");
    const loading = modalElement.querySelector("#globalImageLoading");
    const error = modalElement.querySelector("#globalImageError");
    const caption = modalElement.querySelector("#globalImageCaption");

    if (!image || !loading || !error || !caption) {
        return;
    }

    window.globalImageModalData = null;

    function resetImage() {
        image.onload = null;
        image.onerror = null;

        image.classList.remove("is-loaded");
        image.removeAttribute("src");

        loading.style.display = "flex";
        error.classList.remove("visible");
        caption.textContent = "";

        window.globalImageModalData = null;

        modalElement.classList.remove("show-info");

        document.dispatchEvent(new CustomEvent("global-image:reset"));
    }

    function openGlobalImage(url, imageCaption = "") {
        if (!url) {
            return;
        }

        resetImage();

        const imageUrl = new URL(url, window.location.href).href;

        window.globalImageModalData = {
            url: imageUrl,
            caption: imageCaption,
        };

        caption.textContent = imageCaption;

        image.onload = function () {
            loading.style.display = "none";
            error.classList.remove("visible");

            image.classList.add("is-loaded");

            window.globalImageModalData = {
                ...window.globalImageModalData,
                width: image.naturalWidth,
                height: image.naturalHeight,
            };

            document.dispatchEvent(
                new CustomEvent("global-image:loaded", {
                    detail: window.globalImageModalData,
                }),
            );
        };

        image.onerror = function () {
            loading.style.display = "none";
            error.classList.add("visible");

            image.classList.remove("is-loaded");

            document.dispatchEvent(
                new CustomEvent("global-image:error", {
                    detail: window.globalImageModalData,
                }),
            );
        };

        image.src = imageUrl;

        modal.show();
    }

    /* GLOBAL OPEN FUNCTION */
    window.openGlobalImage = openGlobalImage;

    /* CLICK IMAGE TRIGGERS */
    document.addEventListener("click", function (event) {
        const trigger = event.target.closest("[data-global-image]");

        if (!trigger) {
            return;
        }

        event.preventDefault();

        const url = trigger.getAttribute("data-global-image");

        const imageCaption =
            trigger.getAttribute("data-caption") ||
            trigger.getAttribute("alt") ||
            "";

        openGlobalImage(url, imageCaption);
    });

    /* RESET WHEN MODAL CLOSES */
    modalElement.addEventListener("hidden.bs.modal", resetImage);
});
