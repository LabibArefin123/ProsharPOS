/* ==========================================
   FEATURE ANIMATION CONTROLLER
========================================== */

(function (window, document) {
    "use strict";

    function initializeFeatures() {
        const section = document.querySelector(".features-section");

        if (!section) return;

        if (window.FeatureScrollAnimation) {
            window.FeatureScrollAnimation.init();
        }

        if (window.FeatureCardInteraction) {
            window.FeatureCardInteraction.init();
        }

        console.log("[Features] Premium animations initialized.");
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initializeFeatures, {
            once: true,
        });
    } else {
        initializeFeatures();
    }
})(window, document);
