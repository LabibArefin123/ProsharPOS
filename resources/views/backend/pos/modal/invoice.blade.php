<div class="modal fade pp-pos-modal" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalTitle"
    aria-hidden="true">

    <div class="modal-dialog modal-md modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="checkoutModalTitle">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        Complete Sale
                    </h5>
                    <small>Enter payment information</small>
                </div>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-user"></i>
                        Customer
                    </label>

                    <select class="form-control select2" id="customer_id" style="width: 100%">
                        <option value="">Walk-in Customer</option>

                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" data-phone="{{ $customer->phone_number }}">
                                {{ $customer->name }} ({{ $customer->phone_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-money-check-dollar"></i>
                        Payment Status
                    </label>

                    <select class="form-control" id="payment_status">
                        <option value="paid">Paid</option>
                        <option value="due">Due</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-wallet"></i>
                        Payment Method
                    </label>

                    <select class="form-control" id="payment_method">
                        <option value="cash">Cash</option>
                        <option value="bkash">bKash</option>
                        <option value="nagad">Nagad</option>
                        <option value="bank">Bank</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-money-bill-wave"></i>
                        Paid Amount (৳)
                    </label>

                    <input type="number" class="form-control" id="paid_amount" min="0" step="0.01"
                        placeholder="Enter paid amount">
                </div>

                <div class="pp-checkout-summary">

                    <div>
                        <span>
                            <i class="fa-solid fa-receipt"></i>
                            Grand Total
                        </span>
                        <strong>৳ <span id="checkout-total">0.00</span></strong>
                    </div>

                    <div>
                        <span>
                            <i class="fa-solid fa-circle-check"></i>
                            Paid Amount
                        </span>
                        <strong>৳ <span id="checkout-paid-preview">0.00</span></strong>
                    </div>

                    <div>
                        <span>
                            <i class="fa-solid fa-clock"></i>
                            Due Amount
                        </span>
                        <strong>৳ <span id="checkout-due-preview">0.00</span></strong>
                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-light" data-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                    Cancel
                </button>

                <button type="button" class="btn btn-success" id="confirm-checkout">
                    <i class="fa-solid fa-circle-check"></i>
                    Confirm Sale
                </button>

            </div>

        </div>
    </div>
</div>
