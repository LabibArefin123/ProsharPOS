  <div class="row">

      <div class="col-md-4">
          <div class="form-group">
              <label>Supplier</label> <span class="text-danger">*</span>
              <select name="supplier_id" id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                  <option value="">Select Supplier Name</option>
                  @foreach ($suppliers as $supply)
                      <option value="{{ $supply->id }}" data-email="{{ $supply->email }}"
                          data-phone="{{ $supply->phone_number }}" data-location="{{ $supply->location }}"
                          data-license={{ $supply->license_number }}
                          {{old('supplier_id', $storage->supplier_id ?? '') == $supply->id ? 'selected' : '' }}>
                          {{ $supply->name }}
                      </option>
                  @endforeach
              </select>

              @error('supplier_id')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <label>Location</label>
              <input type="text" id="supplier_location" name="location" class="form-control" readonly>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Email</label>
              <input type="text" id="supplier_email" name="email" class="form-control" readonly>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Phone</label>
              <input type="text" id="supplier_phone_number" name="phone_number" class="form-control" readonly>
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>License No</label>
              <input type="text" id="supplier_license_no" name="license_no" class="form-control" readonly>
          </div>
      </div>


  </div>
