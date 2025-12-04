@extends('adminlte::page')

@section('title', 'Add Payment')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add New Payment</h3>
        <a href="{{ route('payments.index') }}" class="btn btn-sm btn-secondary">Back</a>
    </div>
@stop

@section('content')
    <div class="container">
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

                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        <div class="col-md-6 form-group">
                            <label><strong>Payment Name</strong></label>
                            <input type="text" name="payment_name" class="form-control" value="{{ old('payment_name') }}"
                                placeholder="Invoice/Challan/Petty Cash">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Invoice</strong></label>
                            <select name="invoice_id" id="invoice-select" class="form-control">
                                <option value="">-- Select Invoice (Optional) --</option>
                                @foreach ($invoices as $invoice)
                                    <option value="{{ $invoice->id }}" data-total="{{ $invoice->total }}">
                                        #{{ $invoice->invoice_id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Paid By</strong></label>
                            <select name="paid_by" class="form-control" required>
                                <option value="">-- Select User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Payment Type</strong></label>
                            <select name="payment_type" id="payment-type-select" class="form-control" required>
                                <option value="cash">Cash</option>
                                <option value="bank">Bank</option>
                                <option value="mobile">Mobile</option>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Paid Amount</strong></label>
                            <input type="number" step="0.01" name="paid_amount" id="paid-amount" class="form-control"
                                value="{{ old('paid_amount', 0) }}">
                        </div>

                        <div class="col-md-6 form-group">
                            <label><strong>Due Amount</strong></label>
                            <input type="number" step="0.01" name="due_amount" id="due-amount" class="form-control"
                                value="{{ old('due_amount', 0) }}" readonly>
                        </div>

                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Save Payment</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const invoiceSelect = document.getElementById('invoice-select');
            const paidAmountInput = document.getElementById('paid-amount');
            const dueAmountInput = document.getElementById('due-amount');

            function updateDue() {
                const selectedOption = invoiceSelect.options[invoiceSelect.selectedIndex];
                const total = parseFloat(selectedOption.dataset.total) || 0;
                const paid = parseFloat(paidAmountInput.value) || 0;
                dueAmountInput.value = Math.max(total - paid, 0).toFixed(2);
            }

            // Update due when invoice changes
            invoiceSelect.addEventListener('change', updateDue);

            // Update due when paid amount changes
            paidAmountInput.addEventListener('input', updateDue);
        });
    </script>
@stop
