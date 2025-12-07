  {{-- Supplier --}}
  <div class="col-md-6 form-group">
      <label><strong>Supplier</strong></label>
      <select name="supplier_id" id="supplier_id" class="form-control">
          <option value="">Select Supplier</option>
          @foreach ($suppliers as $sup)
              <option value="{{ $sup->id }}"
                  {{ old('supplier_id', $petty_cash->supplier_id) == $sup->id ? 'selected' : '' }}>
                  {{ $sup->name }}
              </option>
          @endforeach
      </select>
  </div>
  <div class="form-group col-md-6">
      <label>Supplier Email</label>
      <input type="text" id="supplier-email" class="form-control" readonly>
  </div>
  <div class="form-group col-md-6">
      <label>Supplier Phone</label>
      <input type="text" id="supplier-phone" class="form-control" readonly>
  </div>
  <div class="form-group col-md-6">
      <label>License Number</label>
      <input type="text" id="supplier-license" class="form-control" readonly>
  </div>
