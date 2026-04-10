{{-- CHECKOUT MODAL --}}
<div class="modal fade" id="checkoutModal" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-right">
        <div class="modal-content">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">💳 Checkout</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                {{-- Customer --}}
                <div class="mb-2">
                    <label>Customer</label>

                    <select class="form-control select2" id="customer_id" style="width:100%">
                        <option value="">Walk-in Customer</option>

                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" data-phone="{{ $customer->phone_number }}">
                                {{ $customer->name }} ({{ $customer->phone_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Payment Status --}}
                <div class="mb-2">
                    <label>Payment Status</label>
                    <select class="form-control" id="payment_status">
                        <option value="paid">Paid</option>
                        <option value="due">Due</option>
                    </select>
                </div>

                {{-- Payment Method --}}
                <div class="mb-2">
                    <label>Payment Method</label>
                    <select class="form-control" id="payment_method">
                        <option value="cash">Cash</option>
                        <option value="bkash">bKash</option>
                        <option value="nagad">Nagad</option>
                        <option value="bank">Bank</option>
                    </select>
                </div>

                {{-- Paid Amount --}}
                <div class="mb-2">
                    <label>Paid Amount</label>
                    <input type="number" class="form-control" id="paid_amount" placeholder="Enter amount">
                </div>

                {{-- Total --}}
                <div class="text-end">
                    <h4>Total: ৳ <span id="checkout-total">0</span></h4>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="confirm-checkout">
                    ✅ Confirm Sale
                </button>
            </div>

        </div>
    </div>
</div>
