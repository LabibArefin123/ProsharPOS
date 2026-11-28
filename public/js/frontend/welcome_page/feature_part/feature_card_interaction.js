/* ==========================================
   FEATURE CARD INTERACTIONS
========================================== */

(function (window, document) {
    "use strict";

    window.FeatureCardInteraction = {
        init: function () {
            const cards = document.querySelectorAll(
                ".features-section .feature-card",
            );

            if (!cards.length) return;

            const reducedMotion = window.matchMedia(
                "(prefers-reduced-motion: reduce)",
            ).matches;

            const finePointer = window.matchMedia(
                "(hover: hover) and (pointer: fine)",
            ).matches;

            if (reducedMotion || !finePointer) return;

            cards.forEach((card) => {
                let animationFrame = null;

                card.addEventListener("pointermove", (event) => {
                    if (animationFrame) {
                        cancelAnimationFrame(animationFrame);
                    }

                    animationFrame = requestAnimationFrame(() => {
                        const rect = card.getBoundingClientRect();

                        const x = event.clientX - rect.left;
                        const y = event.clientY - rect.top;

                        const centerX = rect.width / 2;
                        const centerY = rect.height / 2;

                        const rotateY = ((x - centerX) / centerX) * 2.5;
                        const rotateX = ((centerY - y) / centerY) * 2.5;

                        card.style.setProperty("--mouse-x", `${x}px`);
                        card.style.setProperty("--mouse-y", `${y}px`);

                        card.style.transform = `
                            translateY(-7px)
                            perspective(1000px)
                            rotateX(${rotateX}deg)
                            rotateY(${rotateY}deg)
                        `;
                    });
                });

                card.addEventListener("pointerleave", () => {
                    if (animationFrame) {
                        cancelAnimationFrame(animationFrame);
                        animationFrame = null;
                    }

                    card.style.transform = "";

                    card.style.setProperty("--mouse-x", "50%");
                    card.style.setProperty("--mouse-y", "50%");
                });
            });
        },
    };
})(window, document);
