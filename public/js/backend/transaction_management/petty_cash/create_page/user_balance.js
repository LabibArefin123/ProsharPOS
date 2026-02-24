document.addEventListener("DOMContentLoaded", function () {
    const userSelect = document.getElementById("user_id");
    const bankSelect = document.getElementById("bank_balance_id");

    function filterBankBalances(autoSelect = true) {
        const selectedUserId = userSelect.value;
        let firstVisibleOption = null;

        Array.from(bankSelect.options).forEach((option) => {
            if (option.value === "") {
                option.hidden = false;
                return;
            }

            if (option.dataset.user === selectedUserId) {
                option.hidden = false;

                if (!firstVisibleOption) {
                    firstVisibleOption = option;
                }
            } else {
                option.hidden = true;
            }
        });

        const currentSelected = bankSelect.options[bankSelect.selectedIndex];

        // Keep old value if exists
        if (currentSelected && !currentSelected.hidden) {
            return;
        }

        // Auto select first valid bank
        if (autoSelect && firstVisibleOption) {
            bankSelect.value = firstVisibleOption.value;
        }

        // If no user selected
        if (!selectedUserId) {
            bankSelect.value = "";
        }
    }

    // When user changes
    userSelect.addEventListener("change", function () {
        filterBankBalances(true);
    });

    // 🔥 VERY IMPORTANT → Handles validation old() case
    if (userSelect.value) {
        filterBankBalances(false);
    }
});
