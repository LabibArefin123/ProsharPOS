  <div class="row">
      {{-- Unit --}}
      <div class="col-md-2">
          <div class="form-group">
              <label>Unit</label>
              <select name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                  <option value="">Select</option>
                  @foreach ($units as $unit)
                      <option value="{{ $unit->id }}"
                          {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>
                          {{ $unit->name }} ({{ $unit->short_name }})
                      </option>
                  @endforeach
              </select>
              @error('unit_id')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

      {{-- Part Number --}}
      <div class="col-md-2">
          <div class="form-group">
              <label>Part Number</label>
              <input type="text" name="part_number" class="form-control @error('part_number') is-invalid @enderror"
                  value="{{ old('part_number', $product->part_number) }}">
              @error('part_number')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

      {{-- Type / Model --}}
      <div class="col-md-2">
          <div class="form-group">
              <label>Type / Model</label>
              <input type="text" name="type_model" class="form-control @error('type_model') is-invalid @enderror"
                  value="{{ old('type_model', $product->type_model) }}">
              @error('type_model')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

      {{-- Rack --}}
      <div class="col-md-3">
          <div class="form-group">
              <label>Rack</label>
              <input type="text" name="rack_number" class="form-control @error('rack_number') is-invalid @enderror"
                  value="{{ old('rack_number', $product->rack_number) }}">
              @error('rack_number')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>

      {{-- Box --}}
      <div class="col-md-3">
          <div class="form-group">
              <label>Box</label>
              <input type="text" name="box_number" class="form-control @error('box_number') is-invalid @enderror"
                  value="{{ old('box_number', $product->box_number) }}">
              @error('box_number')
                  <span class="text-danger small">{{ $message }}</span>
              @enderror
          </div>
      </div>
  </div>
