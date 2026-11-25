/* ==========================================
   ProsharPOS - Checkout Management
========================================== */

$(document).ready(function () {
    // Select2 Customer Search
    if ($.fn.select2) {
        $("#customer_id").select2({
            placeholder: "Search customer by name or phone...",
            allowClear: true,
            width: "100%",
            dropdownParent: $("#checkoutModal"),

            matcher: function (params, data) {
                if ($.trim(params.term) === "") {
                    return data;
                }

                if (!data.id) {
                    return data;
                }

                const search = params.term.toLowerCase();
                const text = (data.text || "").toLowerCase();

                const phone =
                    $(data.element).data("phone")?.toString().toLowerCase() ||
                    "";

                return text.includes(search) || phone.includes(search)
                    ? data
                    : null;
            },
        });
    }

    // Open Checkout
    function openCheckout() {
        if (posCart.count() === 0) {
            toastr.warning("Your cart is empty.");
            return;
        }

        const total = posCart.total();

        $("#checkout-total").text(posCart.formatMoney(total));

        $("#payment_status").val("paid");
        $("#paid_amount").val(total.toFixed(2));

        updatePaymentSummary();

        $("#cartModal").modal("hide");
        $("#checkoutModal").modal("show");
    }

    $("#checkout-btn, #checkout-btn-modal").on("click", function () {
        openCheckout();
    });

    // Payment Summary
    function updatePaymentSummary() {
        const total = posCart.total();

        let paid = parseFloat($("#paid_amount").val()) || 0;

        paid = Math.max(0, Math.min(paid, total));

        const due = Math.max(0, total - paid);

        $("#checkout-paid-preview").text(posCart.formatMoney(paid));
        $("#checkout-due-preview").text(posCart.formatMoney(due));
    }

    $("#paid_amount, #payment_status").on("input change", function () {
        const total = posCart.total();

        if ($("#payment_status").val() === "paid") {
            $("#paid_amount").val(total.toFixed(2));
        }

        updatePaymentSummary();
    });

    // Submit Checkout
    $("#confirm-checkout").on("click", function () {
        if (posCart.count() === 0) {
            toastr.warning("Your cart is empty.");
            return;
        }

        const total = posCart.total();

        const paymentStatus = $("#payment_status").val();

        let paidAmount = parseFloat($("#paid_amount").val());

        if (isNaN(paidAmount) || paidAmount < 0) {
            toastr.warning("Please enter a valid paid amount.");
            return;
        }

        if (paidAmount > total) {
            toastr.warning("Paid amount cannot exceed the sale total.");
            return;
        }

        if (paymentStatus === "paid" && paidAmount !== total) {
            toastr.warning("Paid amount must equal the total.");
            return;
        }

        const data = {
            customer_id: $("#customer_id").val(),
            payment_status: paymentStatus,
            payment_method: $("#payment_method").val(),
            paid_amount: paidAmount,
            total: total,
            items: posCart.items,
        };

        const button = $("#confirm-checkout");

        button
            .prop("disabled", true)
            .html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        $.ajax({
            url: "/pos/checkout",
            method: "POST",

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            data: data,

            success: function (response) {
                toastr.success(
                    response.message || "Sale completed successfully.",
                );

                posCart.clear();

                $("#checkoutModal").modal("hide");

                $("#customer_id").val("").trigger("change");

                $("#payment_status").val("paid");
                $("#payment_method").val("cash");
                $("#paid_amount").val("");

                // Refresh product stock from the server.
                setTimeout(function () {
                    window.location.reload();
                }, 800);
            },

            error: function (xhr) {
                let message = "Unable to complete the sale. Please try again.";

                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    if (xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors)
                            .flat()
                            .join("\n");
                    }
                }

                toastr.error(message);
            },

            complete: function () {
                button
                    .prop("disabled", false)
                    .html('<i class="fas fa-check-circle"></i> Confirm Sale');
            },
        });
    });
});
