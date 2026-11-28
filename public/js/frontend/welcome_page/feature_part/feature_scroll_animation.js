/* ==========================================
   FEATURE SCROLL REVEAL
========================================== */

(function (window, document) {
    "use strict";

    window.FeatureScrollAnimation = {
        init: function () {
            const section = document.querySelector(".features-section");

            if (!section) return;

            const elements = section.querySelectorAll("[data-feature-reveal]");

            if (!elements.length) return;

            const reducedMotion = window.matchMedia(
                "(prefers-reduced-motion: reduce)",
            ).matches;

            if (reducedMotion || !("IntersectionObserver" in window)) {
                elements.forEach((element) => {
                    element.classList.add("is-visible");
                });

                return;
            }

            section.classList.add("features-motion-ready");

            const observer = new IntersectionObserver(
                (entries, observer) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) return;

                        entry.target.classList.add("is-visible");

                        observer.unobserve(entry.target);
                    });
                },
                {
                    threshold: 0.12,
                    rootMargin: "0px 0px -45px 0px",
                },
            );

            elements.forEach((element, index) => {
                const delay = Math.min(index % 4, 3) * 100;

                element.style.setProperty(
                    "--feature-reveal-delay",
                    `${delay}ms`,
                );

                observer.observe(element);
            });
        },
    };
})(window, document);
