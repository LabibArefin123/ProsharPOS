@extends('adminlte::page')

@section('title', 'View Card Payment')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Card Payment Details</h3>
        <a href="{{ route('bank_cards.index') }}" class="btn btn-sm btn-secondary d-flex align-items-center gap-2 back-btn">
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
            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>Bank:</strong><br>
                    {{ $bankCard->bankBalance->name ?? 'N/A' }} ({{ $bankCard->bankBalance->user->name ?? 'N/A' }})
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Payment Date:</strong><br>
                    {{ $bankCard->payment_date->format('d M Y') }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Card Type:</strong><br>
                    {{ $bankCard->card_type }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Card Holder Name:</strong><br>
                    {{ $bankCard->card_holder_name }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Card Last 4 Digits:</strong><br>
                    **** **** **** {{ $bankCard->card_last_four }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Amount (BDT):</strong><br>
                    ৳{{ number_format($bankCard->amount, 2) }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Amount (USD):</strong><br>
                    ${{ number_format($bankCard->amount_in_dollar, 2) }}
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Reference No:</strong><br>
                    {{ $bankCard->reference_no }}
                </div>

                <div class="col-md-12 mb-3">
                    <strong>Note:</strong><br>
                    <p>{{ $bankCard->note ?? '-' }}</p>
                </div>

            </div>

            <div class="text-end mt-3">
                <a href="{{ route('bank_cards.edit', $bankCard->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
@stop
