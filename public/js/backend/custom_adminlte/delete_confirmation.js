document.addEventListener("DOMContentLoaded", function () {
    const userRole = window.userRole || null;

    // Hide delete buttons if not authorized
    if (userRole !== "admin" && userRole !== "it_support") {
        document
            .querySelectorAll("button.btn-danger.btn-sm")
            .forEach((button) => {
                const form = button.closest("form");
                if (form) {
                    form.remove();
                } else {
                    button.remove();
                }
            });

        return;
    }

    // Delete confirmation
    window.triggerDeleteModal = function (actionUrl) {
        Swal.fire({
            title: "Are you sure?",
            text: "This record will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = actionUrl;

                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");

                form.innerHTML = `
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="_method" value="DELETE">
                `;

                document.body.appendChild(form);
                form.submit();
            }
        });
    };
});
