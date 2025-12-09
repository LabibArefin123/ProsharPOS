<div class="card-body row">
    <div class="form-group col-md-3">
        <label for="branch_id">Branch Name</label>
        <select name="branch_id" id="branch_id" class="form-control">
            <option value="">Select Branch</option>
            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-3">
        <label>Branch Code</label>
        <input type="text" id="branch_code" class="form-control" readonly>
    </div>
    <div class="form-group col-md-3">
        <label>Phone</label>
        <input type="text" id="branch_phone" class="form-control" readonly>
    </div>
    <div class="form-group col-md-3">
        <label>Address</label>
        <input type="text" id="branch_location" class="form-control" readonly>
    </div>
</div>
