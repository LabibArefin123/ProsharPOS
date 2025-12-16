  <div class="row">

      <div class="col-md-4">
          <div class="form-group">
              <label>Product</label> <span class="text-danger">*</span>
              <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror">
                  <option value="">Select</option>
                  @foreach ($products as $prod)
                      <option value="{{ $prod->id }}" data-sku="{{ $prod->sku }}"
                          data-part_number="{{ $prod->part_number }}" data-type_model="{{ $prod->type_model }}"
                          data-origin="{{ $prod->origin }}" data-using_place="{{ $prod->using_place }}"
                          {{ old('product_id') == $prod->id ? 'selected' : '' }}>
                          {{ $prod->name }}
                      </option>
                  @endforeach
              </select>

              @error('product_id')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>SKU</label>
              <input type="text" id="sku" name="sku" class="form-control" readonly>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <label>Part Number</label>
              <input type="text" id="part_number" name="part_number" class="form-control" readonly>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <label>Type / Model</label>
              <input type="text" id="type_model" name="type_model" class="form-control" readonly>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <label>Origin</label>
              <input type="text" id="origin" name="origin" class="form-control" readonly>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <label>Using Place</label>
              <input type="text" id="using_place" name="using_place" class="form-control" readonly>
          </div>
      </div>

  </div>
