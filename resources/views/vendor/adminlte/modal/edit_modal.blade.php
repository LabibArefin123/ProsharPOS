<div class="modal fade pp-confirm-modal pp-confirm-modal--edit" id="editConfirmModal" tabindex="-1"
    aria-labelledby="editConfirmLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {{-- Close Button --}}
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>

            {{-- Edit Icon --}}
            <div class="pp-confirm-modal__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
                    <path
                        d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-9.193 9.193a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l9.193-9.193zM11.207 2L3.5 9.707l-.793 2.121 2.121-.793L13.293 3 11.207 2z" />
                </svg>
            </div>

            {{-- Message --}}
            <h5 class="pp-confirm-modal__title" id="editConfirmLabel">
                Confirm Changes
            </h5>

            <div class="pp-confirm-modal__message">
                Are you sure you want to <strong>update</strong> this record?
            </div>

            {{-- Footer --}}
            <div class="modal-footer">

                <button type="button" class="btn pp-confirm-cancel" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button type="submit" class="btn pp-confirm-action">
                    Confirm
                </button>

            </div>

        </div>
    </div>
</div>
