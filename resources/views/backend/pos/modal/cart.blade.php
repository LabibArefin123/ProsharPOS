{{-- CART MODAL --}}
<div class="modal fade" id="cartModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-right">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">🛒 Cart</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <table class="table">
                    <tbody id="pos-cart"></tbody>
                </table>

                <div class="text-right">
                    <h4>Total: ৳ <span id="grand-total">0</span></h4>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="checkout-btn">
                    💳 Checkout
                </button>
            </div>

        </div>
    </div>
</div>
