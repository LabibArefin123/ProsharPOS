<div class="modal fade pp-confirm-modal pp-confirm-modal--warning" id="backConfirmModal" tabindex="-1"
    aria-labelledby="backConfirmLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {{-- Warning Icon --}}
            <div class="pp-confirm-modal__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
                    <path
                        d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0-12a.905.905 0 0 1 .9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 3.995A.905.905 0 0 1 8 3zm.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0z" />
                </svg>
            </div>

            {{-- Message --}}
            <h5 class="pp-confirm-modal__title" id="backConfirmLabel">
                Leave This Page?
            </h5>

            <div class="pp-confirm-modal__message">
                Please fill up the required fields before leaving the page.
                Do you want to leave?
            </div>

            {{-- Footer --}}
            <div class="modal-footer">

                <button type="button" class="btn pp-confirm-cancel" data-bs-dismiss="modal">
                    Stay
                </button>

                <a href="#" class="btn pp-confirm-action leave-page">
                    Leave
                </a>

            </div>

        </div>
    </div>
</div>
