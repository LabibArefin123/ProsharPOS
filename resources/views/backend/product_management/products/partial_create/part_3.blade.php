  <div class="row">

      <div class="col-md-3">
          <div class="form-group">
              <label>Rack Label</label> <span class="text-danger">*</span>
              <input type="text" name="rack_no" class="form-control @error('rack_no') is-invalid @enderror"
                  value="{{ old('rack_no') }}">
              @error('rack_no')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <label>Rack Location</label> <span class="text-danger">*</span>
              <input type="text" name="rack_location" class="form-control @error('rack_location') is-invalid @enderror"
                  value="{{ old('rack_location') }}">
              @error('rack_location')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <label>Box Label</label> <span class="text-danger">*</span>
              <input type="text" name="box_no" class="form-control @error('box_no') is-invalid @enderror"
                  value="{{ old('box_no') }}">
              @error('box_no')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-3">
          <div class="form-group">
              <label>Box Location</label> <span class="text-danger">*</span>
              <input type="text" name="box_location" class="form-control @error('box_location') is-invalid @enderror"
                  value="{{ old('box_location') }}">
              @error('box_location')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
  </div>
