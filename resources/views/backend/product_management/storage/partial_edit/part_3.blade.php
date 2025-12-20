  <div class="row">

      <div class="col-md-4">
          <div class="form-group">
              <label>Manufacturer</label> <span class="text-danger">*</span>
              <select name="manufacturer_id" id="manufacturer_id"
                  class="form-control @error('manufacturer_id') is-invalid @enderror">
                  <option value="">Select Manufacturer Name</option>
                  @foreach ($manufacturers as $manu)
                      <option value="{{ $manu->id }}" data-country="{{ $manu->country }}"
                          data-email="{{ $manu->email }}" data-phone="{{ $manu->phone }}"
                          data-location="{{ $manu->location }}"
                          {{ old('manufacturer_id', $storage->manufacturer_id ?? '') == $manu->id ? 'selected' : '' }}>
                          {{ $manu->name }}
                      </option>
                  @endforeach
              </select>

              @error('manufacturer_id')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Country</label>
              <input type="text" id="country" name="country" class="form-control" readonly>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Location</label>
              <input type="text" id="location" name="location" class="form-control" readonly>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Email</label>
              <input type="text" id="email" name="email" class="form-control" readonly>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Phone</label>
              <input type="text" id="phone" name="phone" class="form-control" readonly>
          </div>
      </div>
  </div>
