  <div class="row">
      <div class="col-md-4">
          <div class="form-group">
              <label>Minimum Stock Level</label> <span class="text-danger">*</span>
              <input type="number" name="minimum_stock_level" class="form-control @error('minimum_stock_level') is-invalid @enderror"
                  value="{{ old('minimum_stock_level') }}">
              @error('minimum_stock_level')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
      <div class="col-md-4">
          <div class="form-group">
              <label>Maximum Stock Level</label> <span class="text-danger">*</span>
              <input type="number" name="maximum_stock_level" class="form-control @error('maximum_stock_level') is-invalid @enderror"
                  value="{{ old('maximum_stock_level') }}">
              @error('maximum_stock_level')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
  </div>
