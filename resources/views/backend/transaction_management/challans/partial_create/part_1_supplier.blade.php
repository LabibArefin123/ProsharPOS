{{-- Start of supplier Section --}}
<div class="card-body row">
    <div class="col-md-3">
        <label for="supplier_id">Supplier Name</label>
        <select name="supplier_id" id="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
            <option value="">Select Supplier</option>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
        </select>
        @error('supplier_id')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>
    <div class="col-md-3">
        <label>Email</label>
        <input type="text" id="supplier_email" class="form-control" readonly>
    </div>
    <div class="col-md-3">
        <label>Phone</label>
        <input type="text" id="supplier_phone" class="form-control" readonly>
    </div>
    <div class="col-md-3">
        <label>Location</label>
        <input type="text" id="supplier_location" class="form-control" readonly>
    </div>
</div>

{{-- End of supplier Section --}}
