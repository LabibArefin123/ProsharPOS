<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Warehouse Name</label> <span class="text-danger">*</span>

            <select name="warehouse_id" id="warehouse_id" class="form-control @error('warehouse_id') is-invalid @enderror">

                <option value="">Select Warehouse Name</option>

                @foreach ($warehouses as $ware)
                    <option value="{{ $ware->id }}" data-code="{{ $ware->code }}"
                        data-location="{{ $ware->location }}" data-manager="{{ $ware->manager }}"
                        {{ old('warehouse_id', $storage->warehouse_id ?? '') == $ware->id ? 'selected' : '' }}>

                        {{ $ware->name }}
                    </option>
                @endforeach

            </select>

            @error('warehouse_id')
                <span class="text-danger small">{{ $message }}</span>
            @enderror

        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Code</label>
            <input type="text" id="warehouse_code" class="form-control" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Location</label>
            <input type="text" id="warehouse_location" class="form-control" readonly>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>Manager Name</label>
            <input type="text" id="warehouse_manager_name" class="form-control" readonly>
        </div>
    </div>
</div>
