document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".productCheckbox");
    const selectAll = document.getElementById("selectAll");

    const actionBar = document.getElementById("bulkActionBar");
    const selectedCount = document.getElementById("selectedCount");

    const deleteBtn = document.getElementById("bulkDeleteBtn");
    const exportBtn = document.getElementById("bulkExportBtn");
    const cancelBtn = document.getElementById("bulkCancelBtn");

    const config = document.getElementById("bulkConfig");

    const deleteUrl = config.dataset.delete;
    const exportUrl = config.dataset.export;
    const csrfToken = config.dataset.token;

    let lastChecked = null;

    function getSelectedIds() {
        return [...document.querySelectorAll(".productCheckbox:checked")].map(
            (cb) => cb.value,
        );
    }

    function updateBulkBar() {
        const selected = getSelectedIds().length;

        if (selected > 0) {
            actionBar.classList.remove("d-none");
            selectedCount.innerText = selected;
        } else {
            actionBar.classList.add("d-none");
        }
    }

    // SHIFT CLICK SELECT
    checkboxes.forEach((checkbox, index) => {
        checkbox.addEventListener("click", function (e) {
            if (!lastChecked) {
                lastChecked = this;
            }

            if (e.shiftKey) {
                const boxes = [...checkboxes];

                let start = boxes.indexOf(this);
                let end = boxes.indexOf(lastChecked);

                let min = Math.min(start, end);
                let max = Math.max(start, end);

                for (let i = min; i <= max; i++) {
                    boxes[i].checked = lastChecked.checked;
                }
            }

            lastChecked = this;

            updateBulkBar();
        });
    });

    // SELECT ALL
    if (selectAll) {
        selectAll.addEventListener("change", function () {
            checkboxes.forEach((cb) => (cb.checked = this.checked));

            updateBulkBar();
        });
    }

    // CANCEL SELECTION
    cancelBtn.addEventListener("click", function () {
        checkboxes.forEach((cb) => (cb.checked = false));

        if (selectAll) {
            selectAll.checked = false;
        }

        updateBulkBar();
    });

    // DELETE SELECTED
    deleteBtn.addEventListener("click", function () {
        const ids = getSelectedIds();

        if (ids.length === 0) return;

        if (!confirm("Delete selected products?")) return;

        fetch(deleteUrl, {
            method: "POST",

            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },

            body: JSON.stringify({
                ids: ids,
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    location.reload();
                }
            });
    });

    // EXPORT SELECTED
    exportBtn.addEventListener("click", function () {
        const ids = getSelectedIds();

        if (ids.length === 0) return;

        const form = document.createElement("form");

        form.method = "POST";
        form.action = exportUrl;

        const token = document.createElement("input");
        token.type = "hidden";
        token.name = "_token";
        token.value = csrfToken;

        form.appendChild(token);

        ids.forEach((id) => {
            const input = document.createElement("input");

            input.type = "hidden";
            input.name = "ids[]";
            input.value = id;

            form.appendChild(input);
        });

        document.body.appendChild(form);

        form.submit();
    });
});
