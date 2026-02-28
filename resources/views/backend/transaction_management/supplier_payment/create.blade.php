@extends('adminlte::page')

@section('title', 'Add Supplier Payment')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add Supplier Payment</h3>
        <a href="{{ route('supplier_payments.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2">
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

            <form action="{{ route('supplier_payments.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Purchase --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Purchase *</strong></label>
                        <select name="purchase_id" id="purchaseSelect"
                            class="form-control @error('purchase_id') is-invalid @enderror">
                            <option value="">Select Purchase</option>
                            @foreach ($purchases as $purchase)
                                <option value="{{ $purchase->id }}" data-supplier="{{ $purchase->supplier->name }}"
                                    data-total="{{ $purchase->total_amount }}" data-paid="{{ $purchase->total_paid ?? 0 }}"
                                    data-due="{{ $purchase->due_amount ?? $purchase->total_amount }}"
                                    {{ old('purchase_id') == $purchase->id ? 'selected' : '' }}>
                                    {{ $purchase->reference_no }} | {{ $purchase->supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Supplier (Auto Filled) --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Supplier</strong></label>
                        <input type="text" id="supplierName" class="form-control" readonly>
                    </div>

                    {{-- Info Section --}}
                    <div class="col-md-4 form-group">
                        <label><strong>Total Amount</strong></label>
                        <input type="text" id="totalAmount" class="form-control" readonly>
                    </div>

                    <div class="col-md-4 form-group">
                        <label><strong>Total Paid</strong></label>
                        <input type="text" id="totalPaid" class="form-control" readonly>
                    </div>

                    <div class="col-md-4 form-group">
                        <label><strong>Due Amount</strong></label>
                        <input type="text" id="dueAmount" class="form-control text-danger font-weight-bold" readonly>
                    </div>

                    {{-- Payment Amount --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Pay Amount *</strong></label>
                        <input type="number" step="0.01" name="amount"
                            class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}">
                    </div>

                    {{-- Payment Date --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Payment Date *</strong></label>
                        <input type="date" name="payment_date" class="form-control"
                            value="{{ old('payment_date', date('Y-m-d')) }}">
                    </div>

                    {{-- Method --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Payment Method</strong></label>
                        <select name="payment_method" class="form-control">
                            <option value="cash">Cash</option>
                            <option value="bank">Bank</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>

                    {{-- Note --}}
                    <div class="col-md-12 form-group">
                        <label><strong>Note</strong></label>
                        <textarea name="note" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">
                        Save Payment
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- 🔥 Script --}}
@section('js')
    <script>
        document.getElementById('purchaseSelect').addEventListener('change', function() {

            let selected = this.options[this.selectedIndex];

            document.getElementById('supplierName').value =
                selected.getAttribute('data-supplier') ?? '';

            document.getElementById('totalAmount').value =
                selected.getAttribute('data-total') ?? '';

            document.getElementById('totalPaid').value =
                selected.getAttribute('data-paid') ?? '';

            document.getElementById('dueAmount').value =
                selected.getAttribute('data-due') ?? '';
        });
    </script>
@stop

@stop
