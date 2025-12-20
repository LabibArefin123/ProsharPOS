 <div class="row">
     {{-- Unit --}}

     <div class="col-md-4">
         <div class="form-group">
             <label>Category</label> <span class="text-danger">*</span>
             <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                 <option value="">Select</option>
                 @foreach ($categories as $category)
                     <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                         {{ $category->name }}
                     </option>
                 @endforeach
             </select>
             @error('category_id')
                 <span class="text-danger small">{{ $message }}</span>
             @enderror
         </div>
     </div>

     {{-- Brand --}}
     <div class="col-md-4">
         <div class="form-group">
             <label>Brand</label> <span class="text-danger">*</span>
             <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                 <option value="">Select</option>
                 @foreach ($brands as $brand)
                     <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                         {{ $brand->name }}
                     </option>
                 @endforeach
             </select>
             @error('brand_id')
                 <span class="text-danger small">{{ $message }}</span>
             @enderror
         </div>
     </div>
     <div class="col-md-4">
         <div class="form-group">
             <label>Unit</label> <span class="text-danger">*</span>
             <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                 <option value="">Select</option>
                 @foreach ($units as $unit)
                     <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                         {{ $unit->name }} ({{ $unit->short_name }})
                     </option>
                 @endforeach
             </select>
             @error('unit_id')
                 <span class="text-danger small">{{ $message }}</span>
             @enderror
         </div>
     </div>

     {{-- Part Number --}}
     <div class="col-md-6">
         <div class="form-group">
             <label>Part Number</label> <span class="text-danger">*</span>
             <input type="text" name="part_number" class="form-control @error('part_number') is-invalid @enderror"
                 value="{{ old('part_number') }}">
             @error('part_number')
                 <span class="text-danger small">{{ $message }}</span>
             @enderror
         </div>
     </div>

     {{-- Type / Model --}}
     <div class="col-md-6">
         <div class="form-group">
             <label>Type / Model</label> <span class="text-danger">*</span>
             <input type="text" name="type_model" class="form-control @error('type_model') is-invalid @enderror"
                 value="{{ old('type_model') }}">
             @error('type_model')
                 <span class="text-danger small">{{ $message }}</span>
             @enderror
         </div>
     </div>

 </div>
