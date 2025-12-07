@extends('adminlte::page')

@section('title', 'Add Petty Cash')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Add Petty Cash</h3>

        <a href="{{ route('petty_cashes.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('petty_cashes.store') }}" method="POST" enctype="multipart/form-data"
                    data-confirm="create">
                    @csrf
                    <div class="row">

                        {{-- Reference No --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Reference No</strong></label>
                            <input type="text" name="reference_no" class="form-control" value="{{ old('reference_no') }}"
                                placeholder="Auto or Manual">
                        </div>

                        {{-- Type --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Type</strong> <span class="text-danger">*</span></label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror">
                                <option value="">Select Type</option>
                                <option value="receive" {{ old('type') == 'receive' ? 'selected' : '' }}>Receive</option>
                                <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                            @error('type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Reference Type --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Reference Type</strong></label>
                            <input type="text" name="reference_type" class="form-control"
                                value="{{ old('reference_type') }}" placeholder="cash_in / cash_out">
                        </div>

                        {{-- Item Name --}}
                        <div class="col-md-6 form-group">
                            <label><strong>Item Name</strong> <span class="text-danger">*</span></label>
                            <input type="text" name="item_name"
                                class="form-control @error('item_name') is-invalid @enderror" value="{{ old('item_name') }}"
                                placeholder="Ex: Office Pen">
                            @error('item_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Amount --}}
                        <div class="col-md-6 form-group">
                            <label><strong>Amount (BDT)</strong> <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="amount"
                                class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}"
                                placeholder="Enter amount">
                            @error('amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Amount in Dollar --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Amount (USD)</strong></label>
                            <input type="number" step="0.01" name="amount_in_dollar" class="form-control"
                                value="{{ old('amount_in_dollar') }}">
                        </div>

                        {{-- Exchange Rate --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Exchange Rate</strong></label>
                            <input type="number" step="0.0001" name="exchange_rate" class="form-control"
                                value="{{ old('exchange_rate') }}">
                        </div>

                        {{-- Currency --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Currency</strong></label>
                            <input type="text" name="currency" class="form-control"
                                value="{{ old('currency', 'BDT') }}">
                        </div>

                        {{-- Payment Method --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Payment Method</strong></label>
                            <select name="payment_method" class="form-control">
                                <option value="">Select</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash
                                </option>
                                <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank
                                </option>
                                <option value="bkash" {{ old('payment_method') == 'bkash' ? 'selected' : '' }}>Bkash
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label><strong>Status</strong></label> <span class="text-danger">*</span>
                            <select name="status" id="payment-type-select"
                                class="form-control @error('status') is-invalid @enderror">
                                <option value="">--- Select Status ---</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>

                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Bank Balance --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Bank Balance</strong></label>
                            <select name="bank_balance_id" class="form-control">
                                <option value="">Select</option>
                                @foreach ($bank_balances as $balance)
                                    <option value="{{ $balance->id }}"
                                        {{ old('bank_balance_id') == $balance->id ? 'selected' : '' }}>
                                        {{ $balance->user->name }} — {{ $balance->balance }} BDT
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Supplier --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Supplier</strong></label>
                            <select name="supplier_id" class="form-control">
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $sup)
                                    <option value="{{ $sup->id }}"
                                        {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>
                                        {{ $sup->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Customer --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Customer</strong></label>
                            <select name="customer_id" class="form-control">
                                <option value="">Select Customer</option>
                                @foreach ($customers as $cus)
                                    <option value="{{ $cus->id }}"
                                        {{ old('customer_id') == $cus->id ? 'selected' : '' }}>
                                        {{ $cus->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Category --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Category</strong></label>
                            <input type="text" name="category" class="form-control" value="{{ old('category') }}"
                                placeholder="Ex: stationery, office supplies">
                        </div>

                        {{-- User --}}
                        <div class="col-md-4 form-group">
                            <label><strong>User</strong> <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Attachment --}}
                        <div class="col-md-4 form-group">
                            <label><strong>Attachment</strong></label>
                            <input type="file" name="attachment" class="form-control">
                        </div>

                        {{-- Note --}}
                        <div class="col-md-12 form-group">
                            <label><strong>Note</strong></label>
                            <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
                        </div>

                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
