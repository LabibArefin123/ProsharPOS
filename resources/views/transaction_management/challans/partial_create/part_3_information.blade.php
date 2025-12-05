  <div class="card-body row">

      <div class="col-md-3 form-group">
          <label><strong>Challan No</strong></label>
          <input type="text" name="challan_no" class="form-control @error('challan_no') is-invalid @enderror"
              value="{{ old('challan_no') }}">
          @error('challan_no')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
          @enderror
      </div>

      <div class="col-md-3 form-group">
          <label><strong>Challan Date</strong></label>
          <input type="date" name="challan_date" class="form-control @error('challan_date') is-invalid @enderror"
              value="{{ old('challan_date') }}">
          @error('challan_date')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
          @enderror
      </div>

      <div class="col-md-3 form-group">
          <label><strong>Challan Ref</strong></label>
          <input type="text" name="challan_ref" class="form-control @error('challan_ref') is-invalid @enderror"
              value="{{ old('challan_ref') }}">
          @error('challan_ref')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
          @enderror
      </div>

      <div class="col-md-3 form-group">
          <label>Status</label> <span class="text-danger">*</span>
          <select name="status" class="form-control @error('status') is-invalid @enderror">
              <option value="">
                  Select Status
              </option>
              <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                  Paid
              </option>
              <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                  Pending
              </option>
          </select>
          @error('status')
              <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
          @enderror
      </div>

  </div>
