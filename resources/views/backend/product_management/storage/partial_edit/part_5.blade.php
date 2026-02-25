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
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center p-2 border rounded">

            <!-- LEFT SIDE -->
            <label class="mb-0 fw-bold">
                Is Damaged?
            </label>

            <!-- RIGHT SIDE -->
            <div class="d-flex align-items-center">

                <label class="switch mb-0">
                    <input type="checkbox" id="is_damaged" name="is_damaged"
                        {{ old('is_damaged', $storage->is_damaged) ? 'checked' : '' }}>
                    <span class="slider round"></span>
                </label>

                <span id="damageLabel"
                    class="ms-2 badge 
                    {{ $storage->is_damaged ? 'badge-danger' : 'badge-success' }}">
                    {{ $storage->is_damaged ? 'YES' : 'NO' }}
                </span>

            </div>

        </div>
    </div>
</div>
<div id="damageSection" style="display:none">

    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label>Damaged Quantity</label>
                <input type="number" name="damage_qty" class="form-control"
                    value="{{ old('damage_qty', $storage->damage_qty) }}">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Damage Solution</label>
                <input type="text" name="damage_solution" class="form-control"
                    value="{{ old('damage_solution', $storage->damage_solution) }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Damage Description</label>
                <textarea name="damage_description" class="form-control" rows="2">{{ old('damage_description', $storage->damage_description) }}</textarea>
            </div>
        </div>

    </div>

    {{-- Damage Image Upload --}}
    <div class="form-group">
        <label>Damage Image</label>

        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#damageImageUploadModal">
            <i class="fas fa-upload"></i> Upload Damage Image
        </button>

        @if ($storage->damage_image)
            <div class="mt-2">
                <img src="{{ asset($storage->damage_image) }}" width="120" class="img-thumbnail">
            </div>
        @endif
    </div>
</div>
<div class="modal fade" id="damageImageUploadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">Upload Damage Image</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <!-- LEFT: Progress & Info -->
                    <div class="col-md-5 border-right text-center">

                        <svg width="120" height="120">
                            <circle cx="60" cy="60" r="50" stroke="#eee" stroke-width="10"
                                fill="none"></circle>
                            <circle id="damageProgressCircleBar" cx="60" cy="60" r="50" stroke="#dc3545"
                                stroke-width="10" fill="none" stroke-dasharray="314" stroke-dashoffset="314"
                                transform="rotate(-90 60 60)"></circle>
                            <text x="60" y="65" text-anchor="middle" font-size="14" id="damageProgressText">0%</text>
                        </svg>

                        <div class="mt-3">
                            <p><strong>Status:</strong></p>
                            <div id="damageUploadStatus" class="text-muted">
                                Waiting for image...
                            </div>

                            <hr>

                            <p><strong>Image Info:</strong></p>
                            <small>
                                Size: <span id="damageImageSize">-</span><br>
                                Format: <span id="damageImageFormat">-</span><br>
                                Dimension: <span id="damageImageDimension">-</span>
                            </small>
                        </div>

                    </div>

                    <!-- RIGHT: Input & Preview -->
                    <div class="col-md-7 text-center">
                        <input type="file" name="damage_image" id="damageImageInput" class="form-control-file mb-3"
                            accept="image/*">

                        <div style="min-height:150px;">
                            <img id="damageImagePreview" class="img-fluid img-thumbnail d-none">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ==========================
           DAMAGE TOGGLE
        ========================== */
        const toggle = document.getElementById('is_damaged');
        const section = document.getElementById('damageSection');
        const label = document.getElementById('damageLabel');

        function toggleDamageSection() {
            if (toggle.checked) {
                section.style.display = 'block';
                label.textContent = 'YES';
                label.classList.remove('badge-success');
                label.classList.add('badge-danger');
            } else {
                section.style.display = 'none';
                label.textContent = 'NO';
                label.classList.remove('badge-danger');
                label.classList.add('badge-success');
            }
        }

        toggle.addEventListener('change', toggleDamageSection);
        toggleDamageSection();

        /* ==========================
           DAMAGE IMAGE PROGRESS
        ========================== */
        document.getElementById('damageImageInput')?.addEventListener('change', async function(e) {

            const file = e.target.files[0];
            if (!file) return;

            const status = document.getElementById('damageUploadStatus');
            const sizeEl = document.getElementById('damageImageSize');
            const formatEl = document.getElementById('damageImageFormat');
            const dimensionEl = document.getElementById('damageImageDimension');
            const progressText = document.getElementById('damageProgressText');
            const progressCircle = document.getElementById('damageProgressCircleBar');
            const preview = document.getElementById('damageImagePreview');

            const maxSize = 5 * 1024 * 1024;
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            preview.classList.add('d-none');
            preview.src = '#';

            const setProgress = (stage) => {
                const stages = 4;
                const percent = Math.round((stage / stages) * 100);
                const dashOffset = 314 - (314 * percent / 100);
                progressCircle.style.strokeDashoffset = dashOffset;
                progressText.innerText = percent + '%';
            };

            /* Stage 1 */
            status.innerHTML = 'Uploading image...';
            setProgress(1);
            await new Promise(r => setTimeout(r, 400));

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
            await new Promise(r => setTimeout(r, 400));

            /* Stage 3: Format & Dimension */
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
