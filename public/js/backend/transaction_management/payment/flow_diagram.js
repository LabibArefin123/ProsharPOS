document.addEventListener("DOMContentLoaded", () => {
    document.documentElement.classList.add("flow-diagram-ready");

    if (typeof window.initializeFlowDiagramToggle === "function") {
        window.initializeFlowDiagramToggle();
    }

    if (typeof window.initializeHistoryTooltips === "function") {
        window.initializeHistoryTooltips();
    }
});
