/* =========================================================
   GLOBAL IMAGE MODAL - INFO PANEL
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("global_image");

    if (!modal) return;

    const modalContent = modal.querySelector(".global-image-modal-content");
    const toggleButton = modal.querySelector("#globalImageInfoToggle");
    const closeButton = modal.querySelector("#globalImageInfoClose");
    const panel = modal.querySelector("#globalImageInfoPanel");

    if (!modalContent || !toggleButton || !closeButton || !panel) return;

    let isAnimating = false;
    let isOpen = false;
    let animationTimer = null;

    function updateButtonState(open) {
        isOpen = open;

        toggleButton.classList.toggle("active", open);

        toggleButton.setAttribute("aria-expanded", String(open));
        toggleButton.setAttribute(
            "aria-label",
            open ? "Hide image information" : "Show image information",
        );

        panel.setAttribute("aria-hidden", String(!open));

        modalContent.classList.toggle("info-panel-open", open);
    }

    function clearAnimationTimer() {
        if (animationTimer) {
            clearTimeout(animationTimer);
            animationTimer = null;
        }
    }

    function finishAnimation() {
        clearAnimationTimer();

        panel.classList.remove("is-hiding");

        isAnimating = false;
    }

    function showPanel() {
        if (isOpen || isAnimating) return;

        clearAnimationTimer();
        isAnimating = true;

        panel.classList.remove("is-hiding");
        panel.classList.add("is-visible");

        updateButtonState(true);

        animationTimer = setTimeout(function () {
            if (isAnimating && isOpen) {
                isAnimating = false;
            }
        }, 450);
    }

    function hidePanel() {
        if (!isOpen || isAnimating) return;

        clearAnimationTimer();
        isAnimating = true;

        panel.classList.remove("is-visible");
        panel.classList.add("is-hiding");

        updateButtonState(false);

        animationTimer = setTimeout(function () {
            finishAnimation();
        }, 350);
    }

    function togglePanel() {
        if (isAnimating) return;

        if (isOpen) {
            hidePanel();
        } else {
            showPanel();
        }
    }

    toggleButton.addEventListener("click", function (event) {
        event.preventDefault();
        event.stopPropagation();

        togglePanel();
    });

    closeButton.addEventListener("click", function (event) {
        event.preventDefault();
        event.stopPropagation();

        hidePanel();
    });

    panel.addEventListener("animationend", function (event) {
        if (event.target !== panel) return;

        if (panel.classList.contains("is-hiding")) {
            finishAnimation();
        }

        if (panel.classList.contains("is-visible")) {
            clearAnimationTimer();
            isAnimating = false;
        }
    });

    modal.addEventListener("show.bs.modal", function () {
        clearAnimationTimer();

        panel.classList.remove("is-visible", "is-hiding");

        isAnimating = false;

        updateButtonState(false);
    });

    modal.addEventListener("hidden.bs.modal", function () {
        clearAnimationTimer();

        panel.classList.remove("is-visible", "is-hiding");

        isAnimating = false;

        updateButtonState(false);
    });
});
