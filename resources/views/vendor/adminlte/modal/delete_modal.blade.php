
<div class="modal fade pp-confirm-modal pp-confirm-modal--delete"
    id="deleteConfirmModal"
    tabindex="-1"
    aria-labelledby="deleteConfirmLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            {{-- Close Button --}}
            <button type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close">
            </button>

            {{-- Delete Icon --}}
            <div class="pp-confirm-modal__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M8.982 1.566a1 1 0 0 0-1.964 0L.165 13.233A1 1 0 0 0 1 14.5h14a1 1 0 0 0 .835-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0z"/>
                </svg>
            </div>

            {{-- Message --}}
            <h5 class="pp-confirm-modal__title" id="deleteConfirmLabel">
                Delete This Record?
            </h5>

            <div class="pp-confirm-modal__message">
                Are you sure you want to <strong>delete</strong> this record?
                This action cannot be undone.
            </div>

            {{-- Footer --}}
            <div class="modal-footer">

                <button type="button"
                    class="btn pp-confirm-cancel"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <form id="deleteForm" method="POST" action="#">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn pp-confirm-action">
                        Delete
                    </button>
                </form>

            </div>

        </div>
    </div>
</div>
