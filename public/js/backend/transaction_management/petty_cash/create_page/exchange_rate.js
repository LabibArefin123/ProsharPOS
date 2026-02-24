document.addEventListener("DOMContentLoaded", function () {
    console.log("Stage 1: DOM Loaded, JS is supported.");

    const amountBDT = document.querySelector('input[name="amount"]');
    const amountUSD = document.querySelector('input[name="amount_in_dollar"]');
    const exchangeInput = document.querySelector('input[name="exchange_rate"]');

    if (!amountBDT || !amountUSD || !exchangeInput) {
        console.error("Stage 1 Error: Required input fields not found in DOM.");
        return;
    }

    let exchangeRate = parseFloat(exchangeInput.value) || 108.5; // fallback

    // Safe function to calculate values
    function calculateBDTtoUSD(value) {
        return exchangeRate > 0
            ? (parseFloat(value) / exchangeRate).toFixed(2)
            : "";
    }

    function calculateUSDtoBDT(value) {
        return exchangeRate > 0
            ? (parseFloat(value) * exchangeRate).toFixed(2)
            : "";
    }

    // BDT -> USD
    amountBDT.addEventListener("input", function () {
        console.log("Stage 3: BDT input changed:", this.value);
        if (this.value) {
            amountUSD.value = calculateBDTtoUSD(this.value);
            amountUSD.disabled = true;
            amountBDT.disabled = false;
        } else {
            amountUSD.value = "";
            amountUSD.disabled = false;
        }
    });

    // USD -> BDT
    amountUSD.addEventListener("input", function () {
        console.log("Stage 3: USD input changed:", this.value);
        if (this.value) {
            amountBDT.value = calculateUSDtoBDT(this.value);
            amountBDT.disabled = true;
            amountUSD.disabled = false;
        } else {
            amountBDT.value = "";
            amountBDT.disabled = false;
        }
    });

    // Exchange rate change
    exchangeInput.addEventListener("input", function () {
        exchangeRate = parseFloat(this.value) || 108.5;
        console.log("Stage 4: Exchange rate updated:", exchangeRate);

        if (amountBDT.value && !amountBDT.disabled) {
            amountUSD.value = calculateBDTtoUSD(amountBDT.value);
        } else if (amountUSD.value && !amountUSD.disabled) {
            amountBDT.value = calculateUSDtoBDT(amountUSD.value);
        }
    });
});
