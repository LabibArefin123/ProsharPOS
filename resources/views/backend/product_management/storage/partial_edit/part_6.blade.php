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
