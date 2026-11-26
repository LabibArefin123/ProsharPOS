document.addEventListener("DOMContentLoaded", () => {
    document.documentElement.classList.add("transaction-history-ready");

    if (typeof window.initializeHistoryTooltips === "function") {
        window.initializeHistoryTooltips();
    }
});
