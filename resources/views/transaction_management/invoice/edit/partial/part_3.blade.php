<div class="card-body row">

    <div class="col-md-4 form-group">
        <label><strong>Invoice ID</strong></label>
        <input type="text" name="invoice_id" class="form-control @error('invoice_id') is-invalid @enderror"
            value="{{ old('invoice_id', $invoice->invoice_id) }}">
        @error('invoice_id')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-md-4 form-group">
        <label><strong>Invoice Date</strong></label>
        <input type="date" name="invoice_date" class="form-control @error('invoice_date') is-invalid @enderror"
            value="{{ old('invoice_date', $invoice->invoice_date) }}">
        @error('invoice_date')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

    <div class="col-md-4 form-group">
        <label>Status</label> <span class="text-danger">*</span>
        <select name="status" class="form-control @error('status') is-invalid @enderror">
            <option value="">
                Select Status
            </option>
            <option value="1" {{ old('status', $invoice->status) == '1' ? 'selected' : '' }}>
                Paid
            </option>
            <option value="0" {{ old('status', $invoice->status) == '0' ? 'selected' : '' }}>
                Pending
            </option>
        </select>
        @error('status')
            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    </div>

</div>
