<div class="row mt-3">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center p-2 border rounded">

            <label class="mb-0 fw-bold">
                Is Expired?
            </label>

            <div class="d-flex align-items-center">

                <label class="switch mb-0">
                    <input type="checkbox" id="is_expired" name="is_expired"
                        {{ old('is_expired', $storage->is_expired) ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>

                <span id="expiryLabel"
                    class="ms-2 badge 
                    {{ $storage->is_expired ? 'badge-warning' : 'badge-success' }}">
                    {{ $storage->is_expired ? 'YES' : 'NO' }}
                </span>

            </div>

        </div>
    </div>
</div>
<div id="expirySection" style="display:none">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label">Expired Quantity</label>
            <input type="number" name="expired_qty" class="form-control"
                value="{{ old('expired_qty', $storage->expired_qty) }}">
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Error Solution</label>
                <input type="text" name="expired_solution" class="form-control"
                    value="{{ old('expired_solution', $storage->expired_solution) }}">
            </div>
        </div>
        <div class="col-md-12">
            <label class="form-label">Expiry Description</label>
            <textarea name="expired_description" class="form-control" rows="2">{{ old('expired_description', $storage->expired_description) }}</textarea>
        </div>
    </div>

    <div class="mt-3">
        <label class="form-label">Expiry Image</label><br>

        <!-- BOOTSTRAP 5 MODAL BUTTON -->
        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
            data-bs-target="#expiryImageUploadModal">
            <i class="fas fa-upload"></i> Upload Expiry Image
        </button>

        @if ($storage->expired_image)
            <div class="mt-2">
                <img src="{{ asset($storage->expired_image) }}" width="120" class="img-thumbnail">
            </div>
        @endif
    </div>
</div>
<div class="modal fade" id="expiryImageUploadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-warning">
                <h5 class="modal-title">Upload Expiry Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-md-5 border-end text-center">
                        <svg width="120" height="120">
                            <circle cx="60" cy="60" r="50" stroke="#eee" stroke-width="10"
                                fill="none" />
                            <circle id="expiryProgressCircleBar" cx="60" cy="60" r="50" stroke="#ffc107"
                                stroke-width="10" fill="none" stroke-dasharray="314" stroke-dashoffset="314"
                                transform="rotate(-90 60 60)" />
                            <text x="60" y="65" text-anchor="middle" id="expiryProgressText">0%</text>
                        </svg>

                        <div class="mt-3">
                            <strong>Status:</strong>
                            <div id="expiryUploadStatus" class="text-muted">Waiting for image...</div>
                            <hr>
                            <small>
                                Size: <span id="expiryImageSize">-</span><br>
                                Format: <span id="expiryImageFormat">-</span><br>
                                Dimension: <span id="expiryImageDimension">-</span>
                            </small>
                        </div>
                    </div>

                    <div class="col-md-7 text-center">
                        <input type="file" id="expiryImageInput" name="expiry_image" class="form-control mb-3"
                            accept="image/*">
                        <img id="expiryImagePreview" class="img-fluid img-thumbnail d-none">
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ==========================
       EXPIRY TOGGLE
    ========================== */
        const toggle = document.getElementById('is_expired');
        const section = document.getElementById('expirySection');
        const label = document.getElementById('expiryLabel');

        if (!toggle || !label) return; // only require these two

        function toggleExpirySection() {

            if (toggle.checked) {

                // Show section if exists
                if (section) section.style.display = 'block';

                label.textContent = 'YES';
                label.classList.remove('badge-success');
                label.classList.add('badge-warning');

            } else {

                if (section) section.style.display = 'none';

                label.textContent = 'NO';
                label.classList.remove('badge-warning');
                label.classList.add('badge-success');
            }
        }

        toggle.addEventListener('change', toggleExpirySection);

        // Run once for edit mode
        toggleExpirySection();


        /* ==========================
           IMAGE PREVIEW
        ========================== */
        const input = document.getElementById('expiryImageInput');

        if (input) {
            input.addEventListener('change', function(e) {

                const file = e.target.files[0];
                if (!file) return;

                const preview = document.getElementById('expiryImagePreview');
                const status = document.getElementById('expiryUploadStatus');
                const sizeEl = document.getElementById('expiryImageSize');
                const typeEl = document.getElementById('expiryImageFormat');
                const dimEl = document.getElementById('expiryImageDimension');
                const textEl = document.getElementById('expiryProgressText');
                const circle = document.getElementById('expiryProgressCircleBar');

                const allowed = ['image/jpeg', 'image/png', 'image/webp'];
                const maxSize = 5 * 1024 * 1024;

                if (!allowed.includes(file.type)) {
                    status.innerHTML = '<span class="text-danger">Invalid format</span>';
                    return;
                }

                if (file.size > maxSize) {
                    status.innerHTML = '<span class="text-danger">File too large</span>';
                    return;
                }

                sizeEl.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                typeEl.textContent = file.type;

                const img = new Image();
                img.onload = function() {
                    dimEl.textContent = img.width + ' x ' + img.height;
                    preview.src = img.src;
                    preview.classList.remove('d-none');
                    status.innerHTML = '<span class="text-success">Ready ✔</span>';

                    if (circle && textEl) {
                        circle.style.strokeDashoffset = 0;
                        textEl.textContent = '100%';
                    }
                };

                img.src = URL.createObjectURL(file);
            });
        }

    });
</script>
