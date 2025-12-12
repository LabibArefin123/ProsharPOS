<div class="card-body row">
    <div class="form-group col-md-3">
        <label for="customer_id">Customer Name</label>
        <select name="customer_id" id="customer_id" class="form-control">
            <option value="">Select Customer</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-3">
        <label>Email</label>
        <input type="text" id="customer_email" class="form-control" readonly>
    </div>
    <div class="form-group col-md-3">
        <label>Phone</label>
        <input type="text" id="customer_phone" class="form-control" readonly>
    </div>
    <div class="form-group col-md-3">
        <label>Location</label>
        <input type="text" id="customer_location" class="form-control" readonly>
    </div>
</div>
