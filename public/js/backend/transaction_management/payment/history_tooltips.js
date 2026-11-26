(function () {
    "use strict";

    window.initializeHistoryTooltips = function () {
        if (typeof bootstrap === "undefined" || !bootstrap.Tooltip) {
            return;
        }

        document
            .querySelectorAll('[data-bs-toggle="tooltip"]')
            .forEach((element) => {
                bootstrap.Tooltip.getOrCreateInstance(element);
            });
    };
})();
