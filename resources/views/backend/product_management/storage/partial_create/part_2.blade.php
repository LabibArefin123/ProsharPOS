  <div class="row">

      <div class="col-md-4">
          <div class="form-group">
              <label>Rack </label> <span class="text-danger">*</span>
              <input type="number" name="rack_number" class="form-control @error('rack_number') is-invalid @enderror"
                  value="{{ old('rack_number') }}">
              @error('rack_number')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Rack Label</label> <span class="text-danger">*</span>
              <input type="text" name="rack_no" class="form-control @error('rack_no') is-invalid @enderror"
                  value="{{ old('rack_no') }}">
              @error('rack_no')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Rack Location</label> <span class="text-danger">*</span>
              <input type="text" name="rack_location"
                  class="form-control @error('rack_location') is-invalid @enderror" value="{{ old('rack_location') }}">
              @error('rack_location')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Box </label> <span class="text-danger">*</span>
              <input type="number" name="box_number" class="form-control @error('box_number') is-invalid @enderror"
                  value="{{ old('box_number') }}">
              @error('box_number')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Box Label</label> <span class="text-danger">*</span>
              <input type="text" name="box_no" class="form-control @error('box_no') is-invalid @enderror"
                  value="{{ old('box_no') }}">
              @error('box_no')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Box Location</label> <span class="text-danger">*</span>
              <input type="text" name="box_location" class="form-control @error('box_location') is-invalid @enderror"
                  value="{{ old('box_location') }}">
              @error('box_location')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Alert Quantity</label> <span class="text-danger">*</span>
              <input type="number" name="alert_quantity" class="form-control @error('alert_quantity') is-invalid @enderror"
                  value="{{ old('alert_quantity') }}">
              @error('alert_quantity')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Stock Quantity</label> <span class="text-danger">*</span>
              <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror"
                  value="{{ old('stock_quantity') }}">
              @error('stock_quantity')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
  </div>
