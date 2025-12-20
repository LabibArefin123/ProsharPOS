  <div class="row">

      {{-- Product Name --}}
      <div class="col-md-4">
          <div class="form-group">
              <label>Name</label> <span class="text-danger">*</span>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                  value="{{ old('name', $product->name) }}">
              @error('name')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <label>SKU</label> <span class="text-danger">*</span>
              <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                  value="{{ old('sku', $product->sku) }}">
              @error('sku')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

      {{-- Category --}}

      {{-- Origin --}}
      <div class="col-md-4">
          <div class="form-group">
              <label>Origin</label> <span class="text-danger">*</span>
              <input type="text" name="origin" class="form-control @error('origin') is-invalid @enderror"
                  value="{{ old('origin', $product->origin) }}">
              @error('origin')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

  </div>
