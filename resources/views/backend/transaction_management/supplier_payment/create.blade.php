@extends('adminlte::page')

@section('title', 'Add Supplier Payment')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add Supplier Payment</h3>
        <a href="{{ route('supplier_payments.index') }}"
            class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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

                    <div class="col-md-6 form-group">
                        <label><strong>Supplier</strong> <span class="text-danger">*</span></label>
                        <select name="supplier_id" class="form-control @error('supplier_id') is-invalid @enderror">
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Amount</strong> <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount"
                            class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}"
                            placeholder="Enter amount">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Payment Date</strong> <span class="text-danger">*</span></label>
                        <input type="date" name="payment_date" class="form-control"
                            value="{{ old('payment_date', date('Y-m-d')) }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label><strong>Payment Method</strong></label>
                        <select name="payment_method" class="form-control">
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                            <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque
                            </option>
                        </select>
                    </div>

                    <div class="col-md-12 form-group">
                        <label><strong>Note</strong></label>
                        <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
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
@stop
