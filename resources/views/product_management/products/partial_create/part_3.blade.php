  <div class="row">
      <div class="col-md-4">
          <div class="form-group">
              <label>Using Place</label>
              <input type="text" name="using_place" class="form-control @error('using_place') is-invalid @enderror"
                  value="{{ old('using_place') }}">
              @error('using_place')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <label>Warranty</label>
              <select name="warranty_id" class="form-control @error('warranty_id') is-invalid @enderror">
                  <option value="">Select</option>
                  @foreach ($warranties as $warranty)
                      <option value="{{ $warranty->id }}" {{ old('warranty_id') == $warranty->id ? 'selected' : '' }}>
                          {{ $warranty->name }} ({{ $warranty->day_count }}
                          {{ $warranty->duration_type }})
                      </option>
                  @endforeach
              </select>
              @error('warranty_id')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              <label>Status</label>
              <select name="status" class="form-control @error('status') is-invalid @enderror">
                  <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                  <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
              </select>
              @error('status')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
  </div>
