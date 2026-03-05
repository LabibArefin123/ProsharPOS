<div class="card shadow-sm mt-3">
    <div class="card-body">

        <div class="row align-items-center">

            <!-- LEFT SIDE : IMAGE UPLOAD -->
            <div class="col-md-3 border-right text-center">

                <label class="font-weight-bold d-block mb-3">
                    Upload Image
                </label>

                <button type="button" class="btn btn-info btn-sm px-4" data-toggle="modal" data-target="#imageUploadModal">

                    <i class="fas fa-upload"></i> Choose Image
                </button>

                @error('image_path')
                    <div class="text-danger small mt-2">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <!-- IMAGE PREVIEW -->
            <div class="col-md-3 text-center">

                <label class="font-weight-bold d-block mb-2">
                    Image Preview
                </label>

                <div style="min-height:120px;">

                    <img id="mainImagePreview" src="{{ $storage->image_path ? asset($storage->image_path) : '' }}"
                        class="img-fluid img-thumbnail {{ $storage->image_path ? '' : 'd-none' }}"
                        style="cursor:pointer; max-height:120px;">

                </div>

            </div>


            <!-- IMAGE INFORMATION -->
            <div class="col-md-3">

                <label class="font-weight-bold d-block mb-2">
                    Image Details
                </label>

                <small>

                    <strong>Size:</strong>
                    <span id="mainImageSize">-</span><br>

                    <strong>Format:</strong>
                    <span id="mainImageFormat">-</span><br>

                    <strong>Dimension:</strong>
                    <span id="mainImageDimension">-</span><br>

                    <strong>Type:</strong>
                    <span id="mainImageShape">-</span>

                </small>

            </div>


            <!-- BARCODE SECTION -->
            <div class="col-md-3 text-center border-left">

                <label class="font-weight-bold d-block mb-2">
                    Product Barcode
                </label>

                <div id="barcodeSection">

                    @if ($storage->barcode_path)
                        <img src="{{ asset($storage->barcode_path) }}" class="img-fluid" style="max-height:80px">

                        <div class="mt-2">
                            <small class="text-muted">
                                {{ $storage->barcode }}
                            </small>
                        </div>
                    @else
                        <button class="btn btn-success btn-sm" onclick="generateBarcode({{ $storage->id }}, this)">

                            <i class="fas fa-barcode"></i> Generate Barcode
                        </button>
                    @endif

                </div>

            </div>

        </div>

    </div>
</div>
