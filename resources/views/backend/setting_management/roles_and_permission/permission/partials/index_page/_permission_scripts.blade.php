
{{-- ==========================================
    Permission Scripts & Dependencies
========================================== --}}

{{-- Toastr CSS --}}
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


{{-- ==========================================
    Existing Permissions Data
========================================== --}}

<script>
    window.existingPermissions = @json(
        \Spatie\Permission\Models\Permission::pluck('name')
    );

    window.permissionBulkDeleteUrl = @json(
        route('permissions.deleteSelected')
    );

    window.permissionCsrfToken = @json(csrf_token());
</script>


{{-- ==========================================
    Toastr JS
========================================== --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


{{-- ==========================================
    Permission Generator Modules
========================================== --}}

<script src="{{ asset('js/backend/setting_management/permission/create_page/generator-core.js') }}"></script>

<script src="{{ asset('js/backend/setting_management/permission/create_page/generator-save.js') }}"></script>

<script src="{{ asset('js/backend/setting_management/permission/create_page/generator-ui.js') }}"></script>


{{-- ==========================================
    Permission Table Management
========================================== --}}

<script>
    $(document).ready(function () {

        "use strict";

        // ==========================================
        // Shift + Click Row Selection
        // ==========================================

        let lastChecked = null;

        $('.row-checkbox').on('click', function (e) {

            if (!lastChecked) {
                lastChecked = this;
                return;
            }

            if (e.shiftKey) {

                const checkboxes = $('.row-checkbox');

                const start = checkboxes.index(this);
                const end = checkboxes.index(lastChecked);

                checkboxes
                    .slice(
                        Math.min(start, end),
                        Math.max(start, end) + 1
                    )
                    .prop('checked', lastChecked.checked);

            }

            lastChecked = this;

            updateSelectAllCheckbox();

        });


        // ==========================================
        // Select / Deselect All
        // ==========================================

        $('#select-all').on('change', function () {

            const checked = $(this).prop('checked');

            $('.row-checkbox').prop('checked', checked);

        });


        // ==========================================
        // Update Select All Checkbox
        // ==========================================

        function updateSelectAllCheckbox() {

            const totalCheckboxes = $('.row-checkbox').length;

            const checkedCheckboxes = $('.row-checkbox:checked').length;

            $('#select-all').prop(
                'checked',
                totalCheckboxes > 0 &&
                totalCheckboxes === checkedCheckboxes
            );

        }


        // ==========================================
        // Individual Checkbox Changes
        // ==========================================

        $('#dataTables').on('change', '.row-checkbox', function () {

            updateSelectAllCheckbox();

        });


        // ==========================================
        // Bulk Delete Permissions
        // ==========================================

        $('#delete-selected').on('click', function () {

            const ids = $('.row-checkbox:checked').map(function () {

                return $(this).val();

            }).get();


            // Check Selected Rows
            if (ids.length === 0) {

                alert('Please select at least one permission to delete.');

                return;

            }


            // Confirm Bulk Delete
            if (!confirm('Are you sure you want to delete selected permissions?')) {

                return;

            }


            // Disable Button During Request
            const deleteButton = $(this);

            deleteButton.prop('disabled', true);


            // AJAX Request
            $.ajax({

                url: window.permissionBulkDeleteUrl,

                method: 'POST',

                data: {

                    _token: window.permissionCsrfToken,

                    ids: ids

                },

                success: function (res) {

                    if (typeof toastr !== 'undefined') {

                        toastr.success(
                            res.message || 'Selected permissions deleted successfully.'
                        );

                    } else {

                        alert(
                            res.message || 'Selected permissions deleted successfully.'
                        );

                    }

                    location.reload();

                },

                error: function (xhr) {

                    deleteButton.prop('disabled', false);

                    const message =
                        xhr.responseJSON?.message ||
                        'Something went wrong while deleting permissions.';

                    if (typeof toastr !== 'undefined') {

                        toastr.error(message);

                    } else {

                        alert(message);

                    }

                }

            });

        });


        // ==========================================
        // Initial Checkbox State
        // ==========================================

        updateSelectAllCheckbox();


        console.log(
            '[Permission Management] Table scripts initialized.'
        );

    });
</script>
