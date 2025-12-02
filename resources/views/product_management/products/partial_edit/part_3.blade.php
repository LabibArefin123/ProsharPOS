  <div class="row">
      <div class="col-md-4">
          <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control">
                  <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>
                      Active
                  </option>
                  <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>
                      Inactive
                  </option>
              </select>
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <label>Using Place</label>
              <input type="text" name="using_place" class="form-control"
                  value="{{ old('using_place', $product->using_place) }}">
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <label>Warranty</label>
              <select name="warranty_id" class="form-control">
                  <option value="">Select</option>
                  @foreach ($warranties as $warranty)
                      <option value="{{ $warranty->id }}"
                          {{ old('warranty_id', $product->warranty_id) == $warranty->id ? 'selected' : '' }}>
                          {{ $warranty->name }} ({{ $warranty->day_count }}
                          {{ $warranty->duration_type }})
                      </option>
                  @endforeach
              </select>
          </div>
      </div>
  </div>
