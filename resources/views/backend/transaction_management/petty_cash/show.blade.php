@extends('adminlte::page')

@section('title', 'Petty Cash Details')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Petty Cash Details</h3>

        <div>
            <a href="{{ route('petty_cashes.edit', $petty_cash->id) }}"
                class="btn btn-sm btn-primary d-inline-flex align-items-center gap-2">
                <i class="fas fa-edit"></i> Edit
            </a>

            <a href="{{ route('petty_cashes.index') }}"
                class="btn btn-sm btn-secondary d-inline-flex align-items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label><strong>User's Name</strong></label>
                    <input type="text" class="form-control" value="{{ $petty_cash->user->name }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Email</strong></label>
                    <input type="text" class="form-control" value="{{ $petty_cash->user->email }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Phone</strong></label>
                    <input type="text" class="form-control" value="{{ $petty_cash->user->phone }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Username</strong></label>
                    <input type="text" class="form-control" value="{{ $petty_cash->user->username }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Supplier's Name</strong></label>
                    <input type="text" class="form-control" value="{{ $petty_cash->supplier->name }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Supplier's Email</strong></label>
                    <input type="text" class="form-control" value="{{ $petty_cash->supplier->email }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Supplier's Phone</strong></label>
                    <input type="text" class="form-control" value="{{ $petty_cash->supplier->phone_number }}" readonly>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Supplier's License No</strong></label>
                    <input type="text" class="form-control" value="{{ $petty_cash->supplier->license_number }}" readonly>
                </div>
               
                <div class="form-group col-md-6">
                    <label><strong>Reference No</strong></label>
                    <div class="form-control">{{ $petty_cash->reference_no }}</div>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Type</strong></label>
                    <div class="form-control text-capitalize">{{ $petty_cash->type }}</div>
                </div>

                <div class="form-group col-md-6">
                    <label><strong>Reference Type</strong></label>
                    <div class="form-control">{{ $petty_cash->reference_type }}</div>
                </div>

                <div class="form-group col-md-6 mb-3">
                    <label><strong>Product Item Name</strong></label>
                    <div class="form-control">
                        {{ $petty_cash->product->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="form-group col-md-6 mb-3">
                    <label><strong>Amount (BDT)</strong></label>
                    <div class="form-control">{{ number_format($petty_cash->amount, 2) }}</div>
                </div>

                {{-- Amount in Dollars --}}
                <div class="form-group col-md-6">
                    <label><strong>Amount (USD)</strong></label>
                    <div class="form-control">{{ number_format($petty_cash->amount_in_dollar, 2) }}</div>
                </div>

                {{-- Exchange Rate --}}
                <div class="form-group col-md-6">
                    <label><strong>Exchange Rate</strong></label>
                    <div class="form-control">{{ $petty_cash->exchange_rate }}</div>
                </div>

                {{-- Currency --}}
                <div class="form-group col-md-6">
                    <label><strong>Currency</strong></label>
                    <div class="form-control">{{ $petty_cash->currency }}</div>
                </div>

                {{-- Payment Method --}}
                <div class="form-group col-md-6">
                    <label><strong>Payment Method</strong></label>
                    <input type="text" class="form-control" value="{{ $petty_cash->payment_method }}" readonly>
                </div>

                {{-- Status --}}
                <div class="form-group col-md-6">
                    <label><strong>Status</strong></label>
                    <div class="form-control text-capitalize">{{ $petty_cash->status }}</div>
                </div>

                {{-- Customer --}}
                <div class="form-group col-md-6">
                    <label><strong>Customer's Name</strong></label>
                    <div class="form-control">{{ $petty_cash->customer->name ?? 'N/A' }}</div>
                </div>



                {{-- Bank Balance --}}
                <div class="form-group col-md-6">
                    <label><strong>Bank Balance Holder</strong></label>
                    <div class="form-control">
                        {{ $petty_cash->bankBalance->user->name ?? 'N/A' }}
                        — {{ number_format($petty_cash->bankBalance->balance ?? 0, 2) }} BDT
                    </div>
                </div>

                {{-- Category --}}
                <div class="form-group col-md-6">
                    <label><strong>Category</strong></label>
                    <div class="form-control">{{ $petty_cash->category->name ?? 'N/A' }}</div>
                </div>

                {{-- Attachment --}}
                <div class="form-group col-md-6">
                    <label><strong>Attachment</strong></label>
                    <div class="form-control">
                        @if ($petty_cash->attachment)
                            <a href="{{ asset('uploads/petty_cash/' . $petty_cash->attachment) }}" target="_blank"
                                class="text-primary">
                                View File
                            </a>
                        @else
                            N/A
                        @endif
                    </div>
                </div>

                {{-- Note --}}
                <div class="col-md-12 mb-3">
                    <label><strong>Note</strong></label>
                    <textarea class="form-control" rows="3" readonly>{{ $petty_cash->note }}</textarea>
                </div>
            </div>
        </div>
    </div>
@stop
