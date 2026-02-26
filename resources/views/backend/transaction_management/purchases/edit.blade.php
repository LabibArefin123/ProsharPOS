@extends('adminlte::page')

@section('title', 'Edit Purchase')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Purchase</h3>
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

            <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 form-group">
                        <label><strong>Supplier</strong></label>
                        <select name="supplier_id" class="form-control">
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Purchase Date</strong></label>
                        <input type="date" name="purchase_date" class="form-control"
                            value="{{ old('purchase_date', $purchase->purchase_date) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Reference No</strong></label>
                        <input type="text" name="reference_no" class="form-control"
                            value="{{ old('reference_no', $purchase->reference_no) }}">
                    </div>

                    <div class="col-md-12 form-group">
                        <label><strong>Note</strong></label>
                        <textarea name="note" class="form-control">{{ old('note', $purchase->note) }}</textarea>
                    </div>

                </div>

                <hr>

                <h5 class="mb-3">Purchase Items</h5>

                <table class="table table-bordered" id="purchaseTable">
                    <thead>
                        <tr>
                            <th width="35%">Product</th>
                            <th width="15%">Qty</th>
                            <th width="20%">Unit Price</th>
                            <th width="20%">Subtotal</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchase->items as $item)
                            <tr>
                                <td>
                                    <select name="product_id[]" class="form-control">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="quantity[]" class="form-control qty"
                                        value="{{ $item->quantity }}">
                                </td>
                                <td>
                                    <input type="number" name="unit_price[]" class="form-control price"
                                        value="{{ $item->unit_price }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control subtotal" value="{{ $item->subtotal }}"
                                        readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm removeRow">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="button" class="btn btn-sm btn-info mb-3" id="addRow">
                    <i class="fas fa-plus"></i> Add More
                </button>

                <div class="text-right">
                    <h5>Total: ৳ <span id="grandTotal">{{ number_format($purchase->total_amount, 2) }}</span></h5>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        Update Purchase
                    </button>
                </div>

            </form>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(document).ready(function() {

            function calculateTotal() {
                let grandTotal = 0;
                $('.subtotal').each(function() {
                    grandTotal += parseFloat($(this).val()) || 0;
                });
                $('#grandTotal').text(grandTotal.toFixed(2));
            }

            $(document).on('keyup change', '.qty, .price', function() {
                let row = $(this).closest('tr');
                let qty = parseFloat(row.find('.qty').val()) || 0;
                let price = parseFloat(row.find('.price').val()) || 0;
                let subtotal = qty * price;
                row.find('.subtotal').val(subtotal.toFixed(2));
                calculateTotal();
            });

            $('#addRow').click(function() {
                let row = $('#purchaseTable tbody tr:first').clone();
                row.find('input').val('');
                $('#purchaseTable tbody').append(row);
            });

            $(document).on('click', '.removeRow', function() {
                if ($('#purchaseTable tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                    calculateTotal();
                }
            });

        });
    </script>
@endsection
