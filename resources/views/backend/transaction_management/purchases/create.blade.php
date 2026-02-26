@extends('adminlte::page')

@section('title', 'Add Purchase')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New Purchase</h3>
        <a href="{{ route('purchases.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Supplier</strong> <span class="text-danger">*</span></label>
                        <select name="supplier_id" id="supplier_id"
                            class="form-control @error('supplier_id') is-invalid @enderror">
                            <option value="">-- Select Supplier --</option>

                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" data-company="{{ $supplier->company_name }}"
                                    data-email="{{ $supplier->email }}" data-phone="{{ $supplier->phone_number }}"
                                    data-license="{{ $supplier->license_number }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Purchase Date</strong> <span class="text-danger">*</span></label>
                        <input type="date" name="purchase_date"
                            class="form-control @error('purchase_date') is-invalid @enderror"
                            value="{{ old('purchase_date', date('Y-m-d')) }}">
                        @error('purchase_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-3 form-group">
                        <label><strong>Supplier's Company Name</strong></label>
                        <input type="text" id="company_name" name="company_name" class="form-control" readonly>
                    </div>

                    <div class="col-md-3 form-group">
                        <label><strong>Supplier's Email</strong></label>
                        <input type="text" id="email" name="email" class="form-control" readonly>
                    </div>

                    <div class="col-md-3 form-group">
                        <label><strong>Supplier's Phone</strong></label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" readonly>
                    </div>

                    <div class="col-md-3 form-group">
                        <label><strong>Supplier's License No</strong></label>
                        <input type="text" id="license_number" name="license_number" class="form-control" readonly>
                    </div>


                    <div class="col-md-6 form-group">
                        <label><strong>Reference No</strong></label>
                        <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no') }}"
                            placeholder="Optional reference number">
                    </div>

                    <div class="col-md-12 form-group">
                        <label><strong>Note</strong></label>
                        <textarea name="note" class="form-control">{{ old('note') }}</textarea>
                    </div>

                </div>

                <hr>

                <h5 class="mb-3">Purchase Items</h5>

                <table class="table table-bordered" id="purchaseTable">
                    <thead class="thead-light">
                        <tr>
                            <th width="35%">Product</th>
                            <th width="15%">Qty</th>
                            <th width="20%">Unit Price</th>
                            <th width="20%">Subtotal</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="product_id[]" class="form-control">
                                    <option value="">-- Select Product --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="quantity[]" class="form-control qty" min="1">
                            </td>
                            <td>
                                <input type="number" name="unit_price[]" class="form-control price" step="0.01">
                            </td>
                            <td>
                                <input type="text" class="form-control subtotal" readonly>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removeRow">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" class="btn btn-sm btn-info mb-3" id="addRow">
                    <i class="fas fa-plus"></i> Add More
                </button>

                <div class="text-right">
                    <h5>Total: ৳ <span id="grandTotal">0.00</span></h5>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">
                        Save Purchase
                    </button>
                </div>

            </form>
        </div>
    </div>
@stop

@section('js')
<script>
$(function () {

    /* ===============================
       SUPPLIER AUTO FILL (NO AJAX)
    =============================== */

    function fillSupplierInfo() {
        let selected = $('#supplier_id').find(':selected');

        if (!selected.val()) {
            $('#company_name, #email, #phone_number, #license_number').val('');
            return;
        }

        $('#company_name').val(selected.data('company') || '');
        $('#email').val(selected.data('email') || '');
        $('#phone_number').val(selected.data('phone') || '');
        $('#license_number').val(selected.data('license') || '');
    }

    // Change supplier
    $('#supplier_id').on('change', fillSupplierInfo);

    // Auto load on edit / refresh
    fillSupplierInfo();


    /* ===============================
       PURCHASE CALCULATION LOGIC
    =============================== */

    function calculateRow(row) {
        let qty   = parseFloat(row.find('.qty').val()) || 0;
        let price = parseFloat(row.find('.price').val()) || 0;
        row.find('.subtotal').val((qty * price).toFixed(2));
    }

    function calculateGrandTotal() {
        let total = 0;
        $('.subtotal').each(function () {
            total += parseFloat($(this).val()) || 0;
        });
        $('#grandTotal').text(total.toFixed(2));
    }

    // Qty / Price change
    $(document).on('input', '.qty, .price', function () {
        let row = $(this).closest('tr');
        calculateRow(row);
        calculateGrandTotal();
    });

    // Add row
    $('#addRow').on('click', function () {
        let row = $('#purchaseTable tbody tr:first').clone();

        row.find('input').val('');
        row.find('.subtotal').val('0.00');

        $('#purchaseTable tbody').append(row);
    });

    // Remove row
    $(document).on('click', '.removeRow', function () {
        if ($('#purchaseTable tbody tr').length > 1) {
            $(this).closest('tr').remove();
            calculateGrandTotal();
        }
    });

});
</script>
@endsection