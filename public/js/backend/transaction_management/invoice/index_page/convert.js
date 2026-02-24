document.addEventListener("DOMContentLoaded", function () {
    const exchangeRate = 108; // 1 USD = 120 Taka

    function formatDollar(value) {
        return "$" + value.toFixed(2);
    }

    // Discount
    document.querySelectorAll(".discount-dollar").forEach((td) => {
        let taka = parseFloat(td.dataset.taka);
        td.textContent = formatDollar(taka / exchangeRate);
    });

    // Sub Total
    document.querySelectorAll(".sub_total-dollar").forEach((td) => {
        let taka = parseFloat(td.dataset.taka);
        td.textContent = formatDollar(taka / exchangeRate);
    });

    // Total
    document.querySelectorAll(".total-dollar").forEach((td) => {
        let taka = parseFloat(td.dataset.taka);
        td.textContent = formatDollar(taka / exchangeRate);
    });
});
