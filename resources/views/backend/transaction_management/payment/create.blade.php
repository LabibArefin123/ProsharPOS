@extends('adminlte::page')

@section('title', 'Add Payment')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add Payment</h3>
        <a href="{{ route('payments.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            {{-- GLOBAL ERROR ALERT --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('payments.store') }}" method="POST" data-confirm="create">
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>Payment Name</strong></label> <span class="text-danger">*</span>
                        <input type="text" name="payment_name"
                            class="form-control @error('payment_name') is-invalid @enderror"
                            value="{{ old('payment_name') }}" placeholder="Invoice/Challan/Petty Cash">

                        @error('payment_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Invoice --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Invoice</strong></label> <span class="text-danger">*</span>
                        <select name="invoice_id" id="invoice-select"
                            class="form-control @error('invoice_id') is-invalid @enderror">
                            <option value="">-- Select Invoice (Optional) --</option>
                            @foreach ($invoices as $invoice)
                                <option value="{{ $invoice->id }}" data-total="{{ $invoice->total }}"
                                    {{ old('invoice_id') == $invoice->id ? 'selected' : '' }}>
                                    #{{ $invoice->invoice_id }}
                                </option>
                            @endforeach
                        </select>

                        @error('invoice_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Paid By --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Paid By</strong></label> <span class="text-danger">*</span>
                        <select name="paid_by" class="form-control @error('paid_by') is-invalid @enderror">
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('paid_by') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('paid_by')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Payment Type --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Payment Type</strong></label> <span class="text-danger">*</span>
                        <select name="payment_type" id="payment-type-select"
                            class="form-control @error('payment_type') is-invalid @enderror">
                            <option value="">--- Select Payment Type ---</option>
                            <option value="cash" {{ old('payment_type') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank" {{ old('payment_type') == 'bank' ? 'selected' : '' }}>Bank</option>
                            <option value="mobile" {{ old('payment_type') == 'mobile' ? 'selected' : '' }}>Mobile
                            </option>
                        </select>

                        @error('payment_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Paid Amount --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Paid Amount</strong></label> <span class="text-danger">*</span>
                        <input type="number" step="0.01" name="paid_amount" id="paid-amount"
                            class="form-control @error('paid_amount') is-invalid @enderror"
                            value="{{ old('paid_amount', 0) }}">

                        @error('paid_amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Dollar Amount</strong></label>
                        <input type="number" step="0.01" name="dollar_amount" id="paid-amount"
                            class="form-control @error('dollar_amount') is-invalid @enderror"
                            value="{{ old('dollar_amount', 0) }}">

                        @error('dollar_amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Due Amount --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Due Amount</strong></label>
                        <input type="number" step="0.01" name="due_amount" id="due-amount"
                            class="form-control @error('due_amount') is-invalid @enderror"
                            value="{{ old('due_amount', 0) }}" readonly>

                        @error('due_amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- Due Amount --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Due Amount (in Dollar)</strong></label>
                        <input type="number" step="0.01" name="due_amount_in_dollar" id="due-amount"
                            class="form-control @error('due_amount_in_dollar') is-invalid @enderror"
                            value="{{ old('due_amount_in_dollar', 0) }}" readonly>

                        @error('due_amount_in_dollar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
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

            invoiceSelect.addEventListener('change', updateDue);
            paidAmountInput.addEventListener('input', updateDue);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const invoiceSelect = document.getElementById('invoice-select');
            const paidAmountInputDollar = document.getElementById('dollar_amount');
            const dueAmountInputDollar = document.getElementById('due_amount_in_dollar');

            function updateDue() {
                const selectedOption = invoiceSelect.options[invoiceSelect.selectedIndex];
                const total = parseFloat(selectedOption.dataset.total) || 0;
                const paid = parseFloat(paidAmountInputDollar.value) || 0;
                dueAmountInputDollar.value = Math.max(total - paid, 0).toFixed(2);
            }

            invoiceSelect.addEventListener('change', updateDue);
            paidAmountInputDollar.addEventListener('input', updateDue);
        });
    </script>
@stop
