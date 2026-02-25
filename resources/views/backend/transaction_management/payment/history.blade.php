@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <h3 class="mb-0">Transaction History (Fully Paid)</h3>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            @forelse($payments as $payment)
                <div class="border rounded p-3 mb-3 shadow-sm">

                    <div class="row align-items-center">

                        <div class="col-md-2">
                            <strong>#{{ $payment->payment_id }}</strong>
                            <br>
                            <small class="text-muted">
                                {{ $payment->created_at->format('d M Y, h:i A') }}
                            </small>
                        </div>

                        <div class="col-md-3">
                            <strong>Invoice:</strong><br>
                            {{ $payment->invoice->invoice_id ?? '-' }}
                        </div>

                        <div class="col-md-2">
                            <strong>Customer:</strong><br>
                            {{ $payment->invoice->customer->name ?? '-' }}
                        </div>

                        <div class="col-md-2 text-success">
                            <strong>Paid:</strong><br>
                            ৳{{ number_format($payment->paid_amount, 2) }}
                        </div>

                        <div class="col-md-2">
                            <strong>Paid By:</strong><br>
                            {{ $payment->paidBy?->name ?? '-' }}
                        </div>

                        <div class="col-md-1 text-end">
                            <span class="badge bg-success">
                                PAID
                            </span>
                        </div>

                    </div>

                </div>

            @empty
                <div class="text-center text-muted">
                    No fully paid transactions found.
                </div>
            @endforelse

        </div>
    </div>

@stop
