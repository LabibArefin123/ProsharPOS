<div class="row">
    <div class="col-md-3">
          <div class="form-group">
              <label>Rack Label</label> <span class="text-danger">*</span>
              <input type="text" name="rack_no" class="form-control"
                  value="{{ old('rack_no', $product->box_no) }}">
          </div>
      </div>
      <div class="col-md-3">
            <div class="form-group">
                <label>Rack Location</label> <span class="text-danger">*</span>
                <input type="text" name="rack_location" class="form-control"
                    value="{{ old('rack_location', $product->box_no) }}">
            </div>
        </div>
    <div class="col-md-3">
          <div class="form-group">
              <label>Box Label</label> <span class="text-danger">*</span>
              <input type="text" name="box_no" class="form-control"
                  value="{{ old('box_no', $product->box_no) }}">
          </div>
      </div>
    <div class="col-md-3">
          <div class="form-group">
              <label>Box Location</label> <span class="text-danger">*</span>
              <input type="text" name="box_location" class="form-control"
                  value="{{ old('box_location', $product->box_no) }}">
          </div>
      </div>
    
</div>