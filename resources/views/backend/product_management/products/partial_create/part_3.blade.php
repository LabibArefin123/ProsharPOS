<hr>
{{-- Price & Stock Table --}}
<div class="table-responsive">
    <table class="table table-bordered table-sm text-center">
        <thead class="thead-light">
            <tr>
                <th>Purchase Price</th>
                <th>Handling Charge (%)</th>
                <th>Office Maintenance (%)</th>
                <th>Selling Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="number" name="purchase_price" id="purchase_price"
                        class="form-control @error('purchase_price') is-invalid @enderror"
                        value="{{ old('purchase_price') }}">
                    @error('purchase_price')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </td>
                <td>
                    <input type="number" name="handling_charge" id="handling_charge" class="form-control bg-light"
                        readonly value="{{ old('handling_charge') }}">
                </td>
                <td>
                    <input type="number" name="maintenance_charge" id="maintenance_charge"
                        class="form-control bg-light" readonly value="{{ old('maintenance_charge') }}">
                </td>
                <td>
                    <input type="number" name="sell_price" id="sell_price"
                        class="form-control @error('sell_price') is-invalid @enderror" value="{{ old('sell_price') }}">
                    @error('sell_price')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </td>

            </tr>
        </tbody>
    </table>
</div>
