document.addEventListener("DOMContentLoaded", function () {
    if (!window.sweetAlertData) return;

    const alerts = window.sweetAlertData;

    if (alerts.success) {
        Swal.fire({
            icon: "success",
            title: "Success",
            text: alerts.success,
            timer: 2000,
            showConfirmButton: false,
        });
    }

    if (alerts.error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: alerts.error,
            timer: 2500,
            showConfirmButton: false,
        });
    }

    if (alerts.warning) {
        Swal.fire({
            icon: "warning",
            title: "Warning",
            text: alerts.warning,
            timer: 2500,
            showConfirmButton: false,
        });
    }

    if (alerts.info) {
        Swal.fire({
            icon: "info",
            title: "Info",
            text: alerts.info,
            timer: 2500,
            showConfirmButton: false,
        });
    }
});
