@extends('adminlte::page')

@section('title', 'Edit Storage')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Storage</h3>
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

            <form action="{{ route('storages.update', $storage->id) }}" method="POST" enctype="multipart/form-data"
                data-confirm="edit">
                @csrf
                @method('PUT')

                {{-- Partials --}}
                @include('backend.product_management.storage.partial_edit.part_1')
                @include('backend.product_management.storage.partial_edit.part_2')
                @include('backend.product_management.storage.partial_edit.part_3')
                @include('backend.product_management.storage.partial_edit.part_4')

                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <div class="row align-items-center">

                            <!-- LEFT SIDE -->
                            <div class="col-md-4 border-right text-center">
                                <label class="font-weight-bold d-block mb-3">
                                    Upload Image
                                </label>

                                <button type="button" class="btn btn-info btn-sm px-4" data-toggle="modal"
                                    data-target="#imageUploadModal">
                                    <i class="fas fa-upload"></i> Choose Image
                                </button>

                                @error('image_path')
                                    <div class="text-danger small mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- RIGHT SIDE -->
                            <div class="col-md-8">

                                <div class="row">

                                    <!-- IMAGE PREVIEW -->
                                    <div class="col-md-4 text-center">
                                        <div style="min-height:120px;">
                                            <img id="mainImagePreview"
                                                src="{{ $storage->image_path ? asset($storage->image_path) : '' }}"
                                                class="img-fluid img-thumbnail {{ $storage->image_path ? '' : 'd-none' }}"
                                                style="cursor:pointer; max-height:120px;">
                                        </div>
                                    </div>

                                    <!-- IMAGE INFO -->
                                    <div class="col-md-8">
                                        <small>
                                            <strong>Size:</strong> <span id="mainImageSize">-</span><br>
                                            <strong>Format:</strong> <span id="mainImageFormat">-</span><br>
                                            <strong>Dimension:</strong> <span id="mainImageDimension">-</span><br>
                                            <strong>Type:</strong> <span id="mainImageShape">-</span>
                                        </small>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                @include('backend.product_management.storage.partial_edit.part_5')
                @include('backend.product_management.storage.partial_edit.part_6')

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="imageZoomModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0 text-center">
                <img id="zoomedImage" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
    {{-- Modal --}}
    <div class="modal fade" id="imageUploadModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-info">
                    <h5 class="modal-title">Upload Storage Image</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        {{-- LEFT: Circular Progress & Status --}}
                        <div class="col-md-5 border-right text-center">
                            <svg id="progressCircle" width="120" height="120">
                                <circle cx="60" cy="60" r="50" stroke="#eee" stroke-width="10"
                                    fill="none"></circle>
                                <circle id="progressCircleBar" cx="60" cy="60" r="50" stroke="#17a2b8"
                                    stroke-width="10" fill="none" stroke-dasharray="314" stroke-dashoffset="314"
                                    transform="rotate(-90 60 60)"></circle>
                                <text x="60" y="65" text-anchor="middle" font-size="14" fill="#000"
                                    id="progressText">0%</text>
                            </svg>

                            <div class="mt-3">
                                <p><strong>Status:</strong></p>
                                <div id="uploadStatus" class="text-muted">Waiting for image...</div>
                                <hr>
                                <p><strong>Image Info:</strong></p>
                                <small>
                                    Size: <span id="imageSize">-</span><br>
                                    Format: <span id="imageFormat">-</span><br>
                                    Dimension: <span id="imageDimension">-</span>
                                </small>
                            </div>
                        </div>

                        {{-- RIGHT: File Input + Preview --}}
                        <div class="col-md-7 text-center">
                            <input type="file" name="image_file" id="imageInput" class="form-control-file mb-3"
                                accept="image/*">
                            <div id="previewContainer" style="min-height:150px;">
                                <img id="imagePreview" src="#" alt="Preview"
                                    class="img-fluid img-thumbnail d-none">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="useImageBtn" data-dismiss="modal">Use This
                        Image</button>
                </div>

            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('js/backend/storage/edit_page/product_load.js') }}"></script>
    <script src="{{ asset('js/backend/storage/edit_page/supplier_load.js') }}"></script>
    <script src="{{ asset('js/backend/storage/edit_page/manufacture_load.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const input = document.getElementById('imageInput'); // inside modal
            const preview = document.getElementById('mainImagePreview');
            const sizeEl = document.getElementById('mainImageSize');
            const formatEl = document.getElementById('mainImageFormat');
            const dimEl = document.getElementById('mainImageDimension');
            const shapeEl = document.getElementById('mainImageShape');

            /* =====================================
               FUNCTION: Detect Image Info
            ===================================== */
            function detectImageInfo(imgSrc, file = null) {

                const img = new Image();
                img.onload = function() {

                    // Dimension
                    const width = img.width;
                    const height = img.height;
                    dimEl.textContent = width + ' x ' + height;

                    // Shape Detection
                    if (width === height) {
                        shapeEl.innerHTML = '<span class="badge badge-success">Square (50 x 50)</span>';
                    } else if (width > height) {
                        shapeEl.innerHTML = '<span class="badge badge-info">Landscape (150 x 50)</span>';
                    } else {
                        shapeEl.innerHTML = '<span class="badge badge-warning">Portrait (50 x 150)</span>';
                    }
                };

                img.src = imgSrc;

                // File info (only if new upload)
                if (file) {

                    // Size Format
                    let size = file.size / 1024;
                    if (size > 1024) {
                        sizeEl.textContent = (size / 1024).toFixed(2) + ' MB';
                    } else {
                        sizeEl.textContent = size.toFixed(1) + ' KB';
                    }

                    // Format
                    let format = file.type.split('/')[1]?.toUpperCase() ?? 'Unknown';
                    formatEl.textContent = format;
                }
            }

            /* =====================================
               LOAD EXISTING IMAGE INFO (ON PAGE LOAD)
            ===================================== */
            if (preview && preview.src && !preview.classList.contains('d-none')) {

                // Try to detect format from URL
                const urlParts = preview.src.split('.');
                const extension = urlParts[urlParts.length - 1].toUpperCase();

                formatEl.textContent = extension;
                sizeEl.textContent = 'Saved Image';

                detectImageInfo(preview.src);
            }

            /* =====================================
               NEW IMAGE SELECT
            ===================================== */
            if (input) {
                input.addEventListener('change', function(e) {

                    const file = e.target.files[0];
                    if (!file) return;

                    const imageURL = URL.createObjectURL(file);

                    preview.src = imageURL;
                    preview.classList.remove('d-none');

                    detectImageInfo(imageURL, file);
                });
            }

            /* =====================================
               IMAGE ZOOM
            ===================================== */
            preview?.addEventListener('click', function() {
                const zoom = document.getElementById('zoomedImage');
                zoom.src = preview.src;
                $('#imageZoomModal').modal('show');
            });

        });
    </script>
@endsection
