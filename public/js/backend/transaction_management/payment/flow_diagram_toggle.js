(function () {
    "use strict";

    window.initializeFlowDiagramToggle = function () {
        document.querySelectorAll(".flow-return-toggle").forEach((button) => {
            button.addEventListener("click", () => {
                const targetId = button.dataset.target;
                const content = targetId
                    ? document.getElementById(targetId)
                    : null;

                if (!content) {
                    return;
                }

                const collapsed = content.classList.toggle("is-collapsed");

                button.setAttribute("aria-expanded", String(!collapsed));

                const icon = button.querySelector("i");
                const label = button.querySelector(".toggle-label");

                if (icon) {
                    icon.classList.toggle("fa-chevron-down", collapsed);
                    icon.classList.toggle("fa-chevron-up", !collapsed);
                }

                if (label) {
                    label.textContent = collapsed
                        ? "Show Details"
                        : "Hide Details";
                }
            });
        });
    };
})();
