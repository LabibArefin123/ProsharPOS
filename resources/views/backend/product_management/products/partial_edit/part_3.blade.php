<hr>

{{-- Price & Stock --}}
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
                <td><input type="number" name="purchase_price" id="purchase_price" class="form-control"
                        value="{{ old('purchase_price', $product->purchase_price) }}"></td>
                <td><input type="number" name="handling_charge" id="handling_charge" class="form-control bg-light"
                        readonly value="{{ old('handling_charge', $product->handling_charge) }}"></td>
                <td><input type="number" name="maintenance_charge" id="maintenance_charge"
                        class="form-control bg-light" readonly
                        value="{{ old('maintenance_charge', $product->maintenance_charge) }}">
                </td>
                <td><input type="number" name="sell_price" id="sell_price" class="form-control"
                        value="{{ old('sell_price', $product->sell_price) }}"></td>
            </tr>
        </tbody>
    </table>
</div>
