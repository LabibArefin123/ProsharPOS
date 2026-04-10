{{-- CART MODAL --}}
<div class="modal fade" id="cartModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-right">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">🛒 Cart</h5>

                {{-- ✅ FIXED BUTTON --}}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <table class="table">
                    <tbody id="pos-cart"></tbody>
                </table>

                <div class="text-end">
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
