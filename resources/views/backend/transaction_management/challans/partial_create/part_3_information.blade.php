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
          <label><strong>Challan Expiry Date</strong></label>
          <input type="date" name="valid_until" class="form-control @error('valid_until') is-invalid @enderror"
              value="{{ old('valid_until') }}">
          @error('valid_until')
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
          <label>Out Ref</label>
          <input type="text" name="out_ref" class="form-control" value="{{ old('out_ref') }}">
      </div>

      <div class="col-md-3 form-group">
          <label>Note</label>
          <input type="text" name="note" class="form-control" value="{{ old('note') }}">
      </div>

      <div class="col-md-3 form-group">
          <label>Upload PDF (delivery note)</label>
          <input type="file" name="pdf_path" class="form-control">
      </div>


  </div>
