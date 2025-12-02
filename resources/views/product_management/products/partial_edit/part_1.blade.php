  <div class="row">

      {{-- Product Name --}}
      <div class="col-md-3">
          <div class="form-group">
              <label>Product/Parts Name</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                  value="{{ old('name', $product->name) }}">
              @error('name')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

      {{-- Category --}}
      <div class="col-md-3">
          <div class="form-group">
              <label>Category</label>
              <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                  <option value="">Select</option>
                  @foreach ($categories as $category)
                      <option value="{{ $category->id }}"
                          {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
      <div class="col-md-3">
          <div class="form-group">
              <label>Brand</label>
              <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                  <option value="">Select</option>
                  @foreach ($brands as $brand)
                      <option value="{{ $brand->id }}"
                          {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                          {{ $brand->name }}
                      </option>
                  @endforeach
              </select>
              @error('brand_id')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

      {{-- Origin --}}
      <div class="col-md-3">
          <div class="form-group">
              <label>Origin</label>
              <input type="text" name="origin" class="form-control @error('origin') is-invalid @enderror"
                  value="{{ old('origin', $product->origin) }}">
              @error('origin')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

  </div>
