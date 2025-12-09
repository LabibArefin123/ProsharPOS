<div class="card-body row">
    <div class="form-group col-md-3">
        <label for="branch_id">Branch Name</label>
        <select name="branch_id" id="branch_id" class="form-control">
            <option value="">Select Branch</option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}" {{ $invoice->branch_id == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-3">
        <label>Branch Code</label>
        <input type="text" id="branch_code" class="form-control" value="{{ $invoice->branch->branch_code ?? '' }}"
            readonly>
    </div>
    <div class="form-group col-md-3">
        <label>Phone</label>
        <input type="text" id="branch_phone" class="form-control" value="{{ $invoice->branch->phone ?? '' }}"
            readonly>
    </div>
    <div class="form-group col-md-3">
        <label>Location</label>
        <input type="text" id="branch_address" class="form-control" value="{{ $invoice->branch->address ?? '' }}"
            readonly>
    </div>

</div>
