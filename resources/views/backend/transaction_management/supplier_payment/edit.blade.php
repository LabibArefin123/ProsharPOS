@extends('adminlte::page')

@section('title', 'Edit Supplier Payment')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Edit Supplier Payment</h3>
        <a href="{{ route('supplier_payments.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">

            <form action="{{ route('supplier_payments.update', $supplierPayment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Purchase --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Purchase</strong></label>
                        <select name="purchase_id" class="form-control">
                            @foreach ($purchases as $purchase)
                                <option value="{{ $purchase->id }}"
                                    {{ $supplierPayment->purchase_id == $purchase->id ? 'selected' : '' }}>
                                    {{ $purchase->reference_no }} | {{ $purchase->supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Amount</strong></label>
                        <input type="number" step="0.01" name="amount" class="form-control"
                            value="{{ old('amount', $supplierPayment->amount) }}">
                    </div>

                    {{-- Date --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Payment Date</strong></label>
                        <input type="date" name="payment_date" class="form-control"
                            value="{{ old('payment_date', $supplierPayment->payment_date->format('Y-m-d')) }}">
                    </div>

                    {{-- Method --}}
                    <div class="col-md-6 form-group">
                        <label><strong>Payment Method</strong></label>
                        <select name="payment_method" class="form-control">
                            <option value="cash" {{ $supplierPayment->payment_method == 'cash' ? 'selected' : '' }}>Cash
                            </option>
                            <option value="bank" {{ $supplierPayment->payment_method == 'bank' ? 'selected' : '' }}>Bank
                            </option>
                            <option value="cheque" {{ $supplierPayment->payment_method == 'cheque' ? 'selected' : '' }}>
                                Cheque</option>
                        </select>
                    </div>

                    {{-- Note --}}
                    <div class="col-md-12 form-group">
                        <label><strong>Note</strong></label>
                        <textarea name="note" class="form-control" rows="3">
            {{ old('note', $supplierPayment->note) }}
        </textarea>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        Update Payment
                    </button>
                </div>

            </form>

        </div>
    </div>
@stop
