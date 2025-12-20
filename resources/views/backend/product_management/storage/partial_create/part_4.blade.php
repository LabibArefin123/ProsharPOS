  <div class="row">

      <div class="col-md-4">
          <div class="form-group">
              <label>Manufacturer</label> <span class="text-danger">*</span>
              <select name="manufacturer_id" id="manufacturer_id"
                  class="form-control @error('manufacturer_id') is-invalid @enderror">
                  <option value="">Select Manufacturer Name</option>
                  @foreach ($manufacturers as $manu)
                      <option value="{{ $manu->id }}" 
                          data-country="{{ $manu->country }}" data-email="{{ $manu->email }}"
                          data-phone="{{ $manu->phone }}" data-location="{{ $manu->location }}"
                          {{ old('manufacturer_id') == $manu->id ? 'selected' : '' }}>
                          {{ $manu->name }}
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
              <label>Country</label>
              <input type="text" id="manufacturer_country" name="country" class="form-control" readonly>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Location</label>
              <input type="text" id="manufacturer_location" name="location" class="form-control" readonly>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Email</label>
              <input type="text" id="manufacturer_email" name="email" class="form-control" readonly>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Phone</label>
              <input type="text" id="manufacturer_phone" name="phone" class="form-control" readonly>
          </div>
      </div>

      
  </div>
