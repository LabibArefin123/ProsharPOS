<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        background-color: #ccc;
        border-radius: 34px;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        border-radius: 50%;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #dc3545;
    }

    input:checked+.slider:before {
        transform: translateX(24px);
    }
</style>
<div class="row mt-3">
    <div class="col-md-4">
        <div class="form-group">
            <label>Is Expired?</label><br>

            <label class="switch">
                <input type="checkbox" id="is_expired" name="is_expired"
                    {{ old('is_expired', $storage->is_expired) ? 'checked' : '' }}>
                <span class="slider round"></span>
            </label>

            <span id="expiryLabel"
                class="ml-2 badge
                {{ $storage->is_expired ? 'badge-warning' : 'badge-success' }}">
                {{ $storage->is_expired ? 'YES' : 'NO' }}
            </span>
        </div>
    </div>
</div>
<div id="expirySection" style="display:none">

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label>Expired Quantity</label>
                <input type="number" name="expired_qty" class="form-control"
                    value="{{ old('expired_qty', $storage->expired_qty) }}">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Expiry Description</label>
                <textarea name="expiry_description" class="form-control" rows="2">
            {{ old('expiry_description', $storage->expiry_description) }}
                </textarea>
            </div>
        </div>

    </div>

    <div class="form-group">
        <label>Expiry Image</label>

        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#expiryImageUploadModal">
            <i class="fas fa-upload"></i> Upload Expiry Image
        </button>

        @if ($storage->expiry_image)
            <div class="mt-2">
                <img src="{{ asset($storage->expiry_image) }}" width="120" class="img-thumbnail">
            </div>
        @endif
    </div>

</div>
<div class="modal fade" id="expiryImageUploadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-warning">
                <h5 class="modal-title">Upload Expiry Image</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <!-- LEFT -->
                    <div class="col-md-5 border-right text-center">

                        <svg width="120" height="120">
                            <circle cx="60" cy="60" r="50" stroke="#eee" stroke-width="10"
                                fill="none"></circle>
                            <circle id="expiryProgressCircleBar" cx="60" cy="60" r="50" stroke="#ffc107"
                                stroke-width="10" fill="none" stroke-dasharray="314" stroke-dashoffset="314"
                                transform="rotate(-90 60 60)"></circle>
                            <text x="60" y="65" text-anchor="middle" id="expiryProgressText">0%</text>
                        </svg>

                        <div class="mt-3">
                            <p><strong>Status:</strong></p>
                            <div id="expiryUploadStatus" class="text-muted">
                                Waiting for image...
                            </div>

                            <hr>

                            <small>
                                Size: <span id="expiryImageSize">-</span><br>
                                Format: <span id="expiryImageFormat">-</span><br>
                                Dimension: <span id="expiryImageDimension">-</span>
                            </small>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="col-md-7 text-center">
                        <input type="file" name="expiry_image" id="expiryImageInput" class="form-control-file mb-3"
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
           SAFE ELEMENT FETCH
        ========================== */
        const expiryToggle = document.getElementById('is_expired');
        const expirySection = document.getElementById('expirySection');
        const expiryLabel = document.getElementById('expiryLabel');

        /* Stop if expiry toggle does not exist (prevents JS crash) */
        if (!expiryToggle || !expirySection || !expiryLabel) {
            return;
        }

        /* ==========================
           TOGGLE HANDLER
        ========================== */
        function toggleExpirySection(force = false) {

            const checked = force !== false ? force : expiryToggle.checked;

            if (checked) {
                expirySection.style.display = 'block';
                expiryLabel.textContent = 'YES';
                expiryLabel.classList.remove('badge-success');
                expiryLabel.classList.add('badge-warning');
            } else {
                expirySection.style.display = 'none';
                expiryLabel.textContent = 'NO';
                expiryLabel.classList.remove('badge-warning');
                expiryLabel.classList.add('badge-success');
            }
        }

        /* Bind change */
        expiryToggle.addEventListener('change', function() {
            toggleExpirySection();
        });

        /* Initial state (VERY IMPORTANT FIX) */
        toggleExpirySection(expiryToggle.checked);

        /* ==========================
           EXPIRY IMAGE PROGRESS
        ========================== */
        const expiryImageInput = document.getElementById('expiryImageInput');

        if (!expiryImageInput) return;

        expiryImageInput.addEventListener('change', async function(e) {

            const file = e.target.files[0];
            if (!file) return;

            const status = document.getElementById('expiryUploadStatus');
            const sizeEl = document.getElementById('expiryImageSize');
            const formatEl = document.getElementById('expiryImageFormat');
            const dimensionEl = document.getElementById('expiryImageDimension');
            const progressText = document.getElementById('expiryProgressText');
            const progressCircle = document.getElementById('expiryProgressCircleBar');
            const preview = document.getElementById('expiryImagePreview');

            if (!status || !progressCircle || !preview) return;

            const maxSize = 5 * 1024 * 1024;
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            /* Reset */
            preview.classList.add('d-none');
            preview.src = '#';
            progressCircle.style.strokeDashoffset = 314;
            progressText.innerText = '0%';

            const setProgress = (stage) => {
                const percent = Math.round((stage / 4) * 100);
                progressCircle.style.strokeDashoffset = 314 - (314 * percent / 100);
                progressText.innerText = percent + '%';
            };

            /* Stage 1 */
            status.innerHTML = 'Uploading image...';
            setProgress(1);
            await new Promise(r => setTimeout(r, 300));

            /* Stage 2: Size */
            const sizeMB = (file.size / 1024 / 1024).toFixed(2);
            sizeEl.innerText = sizeMB + ' MB';

            if (file.size > maxSize) {
                status.innerHTML = '<span class="text-danger">Failed: File too large</span>';
                setProgress(0);
                return;
            }

            status.innerHTML = 'Validating size...';
            setProgress(2);
            await new Promise(r => setTimeout(r, 300));

            /* Stage 3: Format + Dimension */
            formatEl.innerText = file.type;

            if (!allowedTypes.includes(file.type)) {
                status.innerHTML = '<span class="text-danger">Failed: Invalid format</span>';
                setProgress(0);
                return;
            }

            status.innerHTML = 'Validating format & dimension...';

            const img = new Image();
            img.onload = function() {
                dimensionEl.innerText = img.width + ' x ' + img.height;

                status.innerHTML =
                    '<span class="text-success">Image is safe to upload ✔</span>';
                setProgress(4);

                preview.src = img.src;
                preview.classList.remove('d-none');
            };

            img.src = URL.createObjectURL(file);
        });

    });
</script>
