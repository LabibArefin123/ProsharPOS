 <div class="row">

     {{-- Product Name --}}
     <div class="col-md-4">
         <div class="form-group">
             <label>Name</label> <span class="text-danger">*</span>
             <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                 placeholder="Enter product name" value="{{ old('name') }}">
             @error('name')
                 <span class="text-danger small">{{ $message }}</span>
             @enderror
         </div>
     </div>

     {{-- Origin --}}
     <div class="col-md-4">
         <div class="form-group">
             <label>SKU</label> <span class="text-danger">*</span>
             <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                 value="{{ old('sku') }}">
             @error('sku')
                 <span class="text-danger small">{{ $message }}</span>
             @enderror
         </div>
     </div>

     <div class="col-md-4">
         <div class="form-group">
             <label>Origin</label> <span class="text-danger">*</span>
             <input type="text" name="origin" class="form-control @error('origin') is-invalid @enderror"
                 placeholder="Country of Origin" value="{{ old('origin') }}">
             @error('origin')
                 <span class="text-danger small">{{ $message }}</span>
             @enderror
         </div>
     </div>

 </div>
