@extends('adminlte::page')

@section('title', 'Add Storage')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New Storage</h3>
        <a href="{{ route('storages.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li class="small">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('storages.store') }}" method="POST" enctype="multipart/form-data" data-confirm="create">
                @csrf
                @include('backend.product_management.storage.partial_create.part_1')
                @include('backend.product_management.storage.partial_create.part_2')
                @include('backend.product_management.storage.partial_create.part_3')
                @include('backend.product_management.storage.partial_create.part_4')
                <!-- Button to trigger modal -->
                <div class="form-group">
                    <label>Upload Image</label>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#imageUploadModal">
                        Choose Image
                    </button>
                    <input type="hidden" name="image_path" id="hiddenImagePath">
                    <div class="mt-2">
                        <img id="createImagePreview" src="#" alt="Preview" class="img-thumbnail d-none"
                            style="max-width:150px;">
                    </div>
                    @error('image_path')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image Upload Modal -->
                <div class="modal fade" id="imageUploadModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header bg-info">
                                <h5 class="modal-title">Upload Storage Image</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <div class="row">

                                    <!-- LEFT: Circular Progress & Status -->
                                    <div class="col-md-5 border-right text-center">
                                        <svg id="progressCircleCreate" width="120" height="120">
                                            <circle cx="60" cy="60" r="50" stroke="#eee" stroke-width="10"
                                                fill="none"></circle>
                                            <circle id="progressCircleBarCreate" cx="60" cy="60" r="50"
                                                stroke="#17a2b8" stroke-width="10" fill="none" stroke-dasharray="314"
                                                stroke-dashoffset="314" transform="rotate(-90 60 60)"></circle>
                                            <text x="60" y="65" text-anchor="middle" font-size="14" fill="#000"
                                                id="progressTextCreate">0%</text>
                                        </svg>

                                        <div class="mt-3">
                                            <p><strong>Status:</strong></p>
                                            <div id="uploadStatusCreate" class="text-muted">Waiting for image...</div>

                                            <hr>

                                            <p><strong>Image Info:</strong></p>
                                            <small>
                                                Size: <span id="imageSizeCreate">-</span><br>
                                                Format: <span id="imageFormatCreate">-</span><br>
                                                Dimension: <span id="imageDimensionCreate">-</span>
                                            </small>
                                        </div>
                                    </div>

                                    <!-- RIGHT: File Input + Preview -->
                                    <div class="col-md-7 text-center">
                                        <input type="file" name="image_file" id="imageInputCreate"
                                            class="form-control-file mb-3" accept="image/*">
                                        <div id="previewContainerCreate" style="min-height:150px;">
                                            <img id="imagePreviewCreate" src="#" alt="Preview"
                                                class="img-fluid img-thumbnail d-none">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="useImageBtn" data-dismiss="modal">Use
                                    This Image</button>
                            </div>

                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="text-end mt-3">
        <button type="submit" class="btn btn-success">Save</button>
    </div>
    </form>
    <script>
        document.getElementById('imageInputCreate').addEventListener('change', async function(e) {

            const file = e.target.files[0];
            const status = document.getElementById('uploadStatusCreate');
            const sizeEl = document.getElementById('imageSizeCreate');
            const formatEl = document.getElementById('imageFormatCreate');
            const dimensionEl = document.getElementById('imageDimensionCreate');
            const progressText = document.getElementById('progressTextCreate');
            const progressCircle = document.getElementById('progressCircleBarCreate');
            const preview = document.getElementById('imagePreviewCreate');

            if (!file) return;

            const maxSize = 5 * 1024 * 1024; // 5MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            // Reset preview
            preview.classList.add('d-none');
            preview.src = '#';

            // Circular progress helper
            const setProgress = (stage) => {
                const stages = 4;
                const percent = Math.round((stage / stages) * 100);
                const dashOffset = 314 - (314 * percent / 100); // circle circumference 2πr ≈ 314
                progressCircle.style.strokeDashoffset = dashOffset;
                progressText.innerText = percent + '%';
            }

            // Stage 1: Uploading Image
            status.innerHTML = 'Uploading image...';
            setProgress(1);
            await new Promise(r => setTimeout(r, 400));

            // Stage 2: Validate Size
            const sizeMB = (file.size / 1024 / 1024).toFixed(2);
            sizeEl.innerText = sizeMB + " MB";

            if (file.size > maxSize) {
                status.innerHTML = '<span class="text-danger">Failed: File too large</span>';
                setProgress(0);
                return;
            }
            status.innerHTML = 'Validating size...';
            setProgress(2);
            await new Promise(r => setTimeout(r, 400));

            // Stage 3: Validate format & dimension
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

                // Stage 4: Supported & preview
                status.innerHTML = '<span class="text-success">Image is safe to upload ✔</span>';
                setProgress(4);

                preview.src = img.src;
                preview.classList.remove('d-none');
            };
            img.src = URL.createObjectURL(file);

            // Save temporary image object
            window.uploadedImageFile = file;
        });

        // Use this image in hidden input on modal confirm
        document.getElementById('useImageBtn').addEventListener('click', function() {
            if (window.uploadedImageFile) {
                const formData = new FormData();
                formData.append('image', window.uploadedImageFile);

                const hiddenInput = document.getElementById('hiddenImagePath');
                hiddenInput.files = window.uploadedImageFile ? window.uploadedImageFile : null;

                // Also update small preview
                const smallPreview = document.getElementById('createImagePreview');
                smallPreview.src = URL.createObjectURL(window.uploadedImageFile);
                smallPreview.classList.remove('d-none');
            }
        });
    </script>
    <script>
        document.getElementById('purchase_price').addEventListener('input', function() {
            let purchase = parseFloat(this.value) || 0;
            document.getElementById('handling_charge').value = (purchase * 0.05).toFixed(2);
            document.getElementById('maintenance_charge').value = (purchase * 0.03).toFixed(2);
        });
    </script>
    <script src="{{ asset('js/backend/storage/create_page/product_load.js') }}"></script> {{--  Product load  JS --}}
    <script src="{{ asset('js/backend/storage/create_page/supplier_load.js') }}"></script> {{--  Supplier load  JS --}}
    <script src="{{ asset('js/backend/storage/create_page/manufacture_load.js') }}"></script> {{--  Manufacture load  JS --}}

@endsection
