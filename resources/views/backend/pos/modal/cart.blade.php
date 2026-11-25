
<div class="modal fade pp-pos-modal" id="cartModal" tabindex="-1"
    role="dialog" aria-labelledby="cartModalTitle" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="cartModalTitle">
                        <i class="fas fa-shopping-cart"></i>
                        Shopping Cart
                    </h5>
                    <small>Review your selected products</small>
                </div>

                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table pp-cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="pos-cart-modal"></tbody>
                    </table>
                </div>

                <div class="pp-modal-total">
                    <span>Grand Total</span>
                    <strong>৳ <span id="modal-grand-total">0.00</span></strong>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light"
                    data-dismiss="modal">
                    Continue Shopping
                </button>

                <button type="button" class="btn btn-primary"
                    id="checkout-btn-modal">
                    <i class="fas fa-credit-card"></i>
                    Checkout
                </button>
            </div>

        </div>
    </div>
</div>
