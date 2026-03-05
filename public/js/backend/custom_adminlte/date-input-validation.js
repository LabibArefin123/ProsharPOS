document.addEventListener("DOMContentLoaded", function () {
    const dateInputs = document.querySelectorAll('input[type="date"]');

    dateInputs.forEach((input) => {
        // Trigger on typing AND leaving field
        input.addEventListener("blur", validateDate);
        input.addEventListener("input", validateDate);
    });

    function validateDate(e) {
        const element = e.target;
        const value = element.value;

        if (!value) return;

        const [yearStr, monthStr, dayStr] = value.split("-");
        const year = parseInt(yearStr);
        const month = parseInt(monthStr);
        const day = parseInt(dayStr);

        // YEAR CHECK
        if (!/^\d{4}$/.test(yearStr) || year >= 2100 || year <= 0) {
            return showError(
                element,
                "Year must be a valid 4-digit number less than 2100.",
            );
        }

        // MONTH CHECK
        if (month < 1 || month > 12) {
            return showError(element, "Invalid month selected.");
        }

        // FEBRUARY CHECKS
        if (month === 2) {
            const isLeap =
                (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0;

            if (day > 29) {
                return showError(element, "February never has 30 or 31 days.");
            }

            if (day === 29 && !isLeap) {
                return showError(
                    element,
                    `This year (${year}) is not a leap year. February has only 28 days.`,
                );
            }
        }

        // GENERAL MONTH CHECK
        const maxDays = new Date(year, month, 0).getDate();
        if (day < 1 || day > maxDays) {
            return showError(
                element,
                `${monthName(month)} ${year} has only ${maxDays} days.`,
            );
        }
    }

    function showError(element, message) {
        element.value = "";

        Swal.fire({
            icon: "error",
            title: "Invalid Date",
            text: message,
            confirmButtonColor: "#d33",
            confirmButtonText: "OK",
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
    }

    function monthName(month) {
        return [
            "",
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ][month];
    }
});
