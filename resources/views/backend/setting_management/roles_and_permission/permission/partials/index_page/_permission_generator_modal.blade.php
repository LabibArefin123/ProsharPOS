{{--  Generated Permissions Modal --}}

<div class="modal fade" id="permissionGeneratorModal" tabindex="-1" aria-labelledby="permissionGeneratorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content permission-modal-content">
            {{-- Modal Header --}}
            <div class="modal-header border-0">
                <div>
                    <h5 class="modal-title fw-bold" id="permissionGeneratorModalLabel">
                        <i class="fas fa-shield-alt text-primary me-1"></i>
                        Generated Permissions
                    </h5>

                    <small class="text-muted">
                        Select permissions you want to add
                    </small>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body">
                <div id="generatedPermissionList" class="generated-permission-list">
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button type="button" class="btn btn-primary" id="addSelectedPermissions">
                    <i class="fas fa-check-circle me-1"></i>
                    Add Selected Permissions
                </button>
            </div>
        </div>
    </div>
</div>
