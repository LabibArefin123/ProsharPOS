{{-- Start of Branch Section --}}
<div class="card-body row">

    <div class="form-group col-md-3">
        <label for="branch_id">Branch Name</label>
        <select name="branch_id" id="branch_id" class="form-control @error('branch_id') is-invalid @enderror">
            <option value="">Select Branch</option>

            @foreach ($branches as $branch)
                <option value="{{ $branch->id }}" {{ $challan->branch_id == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                </option>
            @endforeach

        </select>

        @error('branch_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group col-md-3">
        <label>Branch Code</label>
        <input type="text" id="branch_code" class="form-control" value="{{ $challan->branch->branch_code ?? '' }}"
            readonly>
    </div>

    <div class="form-group col-md-3">
        <label>Phone</label>
        <input type="text" id="branch_phone" class="form-control" value="{{ $challan->branch->phone ?? '' }}"
            readonly>
    </div>

    <div class="form-group col-md-3">
        <label>Address</label>
        <input type="text" id="branch_location" class="form-control" value="{{ $challan->branch->address ?? '' }}"
            readonly>
    </div>

</div>
{{-- End of Branch Section --}}
