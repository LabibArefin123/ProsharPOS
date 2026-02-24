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

                // store first visible bank for auto select
                if (!firstVisibleOption) {
                    firstVisibleOption = option;
                }
            } else {
                option.hidden = true;
            }
        });

        const currentSelected = bankSelect.options[bankSelect.selectedIndex];

        // If selected bank doesn't belong to user → auto select first valid
        if (
            autoSelect &&
            firstVisibleOption &&
            (!currentSelected || currentSelected.hidden)
        ) {
            bankSelect.value = firstVisibleOption.value;
        }

        // If no user selected → reset bank
        if (!selectedUserId) {
            bankSelect.value = "";
        }
    }

    // When user changes manually
    userSelect.addEventListener("change", function () {
        filterBankBalances(true);
    });

    // 🔥 IMPORTANT → For Edit Page Load
    filterBankBalances(false);
});
