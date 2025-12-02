{{-- Start of Customer Section --}}
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-primary text-white">
        <strong>👤 Customer Information</strong>
    </div>
    <div class="card-body row g-3">
        <div class="col-md-3">
            <label for="customer_id">Customer Name</label>
            <select name="customer_id" id="customer_id" class="form-control" required>
                <option value="">Select Customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Email</label>
            <input type="text" id="customer_email" class="form-control" readonly>
        </div>
        <div class="col-md-3">
            <label>Phone</label>
            <input type="text" id="customer_phone" class="form-control" readonly>
        </div>
        <div class="col-md-3">
            <label>Location</label>
            <input type="text" id="customer_location" class="form-control" readonly>
        </div>
    </div>
</div>
{{-- End of Customer Section --}}
