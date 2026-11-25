<div class="modal fade pp-confirm-modal pp-confirm-modal--create" id="createConfirmModal" tabindex="-1"
    aria-labelledby="createConfirmLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {{-- Close Button --}}
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            </button>

            {{-- Create Icon --}}
            <div class="pp-confirm-modal__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm3.5 7.5h-3v3h-1v-3h-3v-1h3v-3h1v3h3v1z" />
                </svg>
            </div>

            {{-- Message --}}
            <h5 class="pp-confirm-modal__title" id="createConfirmLabel">
                Confirm Creation
            </h5>

            <div class="pp-confirm-modal__message">
                Are you sure you want to <strong>create</strong> this record?
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
