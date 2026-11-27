/* =========================================
   PROSHARPOS HERO AUTOPLAY
========================================= */
document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector("[data-hero-slider]");

    if (!slider || typeof slider.prosharNext !== "function") return;

    const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

    if (reducedMotion.matches) return;

    const intervalDuration = 6000;

    let autoplayInterval = null;
    let isHovered = false;
    let isFocused = false;

    function stopAutoplay() {
        if (autoplayInterval) {
            window.clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
    }

    function startAutoplay() {
        stopAutoplay();

        if (isHovered || isFocused || document.hidden) return;

        autoplayInterval = window.setInterval(function () {
            slider.prosharNext();
        }, intervalDuration);
    }

    slider.addEventListener("mouseenter", function () {
        isHovered = true;
        stopAutoplay();
    });

    slider.addEventListener("mouseleave", function () {
        isHovered = false;
        startAutoplay();
    });

    slider.addEventListener("focusin", function () {
        isFocused = true;
        stopAutoplay();
    });

    slider.addEventListener("focusout", function (event) {
        if (!slider.contains(event.relatedTarget)) {
            isFocused = false;
            startAutoplay();
        }
    });

    document.addEventListener("visibilitychange", function () {
        if (document.hidden) {
            stopAutoplay();
        } else {
            startAutoplay();
        }
    });

    reducedMotion.addEventListener?.("change", function (event) {
        if (event.matches) {
            stopAutoplay();
        } else {
            startAutoplay();
        }
    });

    startAutoplay();
});
