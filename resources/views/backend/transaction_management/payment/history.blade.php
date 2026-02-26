@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Transaction History (Fully Paid)</h3>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">

            @forelse($payments as $payment)
                <div class="border rounded p-3 mb-3 shadow-sm">

                    {{-- Payment Info --}}
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <strong>#{{ $payment->payment_id }}</strong><br>
                            <small class="text-muted">{{ $payment->created_at->format('d M Y, h:i A') }}</small>
                        </div>
                        <div class="col-md-3">
                            <strong>Invoice:</strong><br>{{ $payment->invoice->invoice_id ?? '-' }}
                        </div>
                        <div class="col-md-2">
                            <strong>Customer:</strong><br>{{ $payment->invoice->customer->name ?? '-' }}
                        </div>
                        <div class="col-md-2 text-success">
                            <strong>Paid:</strong><br>৳{{ number_format($payment->paid_amount, 2) }}
                        </div>
                        <div class="col-md-2">
                            <strong>Paid By:</strong><br>{{ $payment->paidBy?->name ?? '-' }}
                        </div>
                        <div class="col-md-1 text-end">
                            <span class="badge bg-success">PAID</span>
                        </div>
                    </div>

                    {{-- Sales Return Flow Diagram --}}
                   @if ($payment->payment_type === 'return' && $payment->invoice->salesReturns->isNotEmpty())
                        <div class="flow-diagram mt-3 p-3 border rounded bg-light">
                            @foreach ($payment->invoice->salesReturns as $return)
                                <h6>Return No: <strong>{{ $return->return_no }}</strong> | Invoice:
                                    <strong>{{ $return->invoice->invoice_id }}</strong></h6>

                                <div class="diagram-container">
                                    <div class="diagram-box">
                                        Customer Bought: {{ $return->items->sum('quantity') }} Items<br>
                                        Payment: ৳{{ number_format($return->invoice->paid_amount ?? 0, 2) }}
                                    </div>
                                    <div class="arrow">↓</div>
                                    <div class="diagram-box">
                                        Stock: -{{ $return->items->sum('quantity') }} (sold)<br>
                                        Invoice: {{ $return->items->sum('quantity') }} Items
                                    </div>
                                    <div class="arrow">↓</div>
                                    <div class="diagram-box">
                                        Customer Returned: {{ $return->items->sum('quantity') }} Items<br>
                                        Stock: +{{ $return->items->sum('quantity') }} (returned)<br>
                                        Refund:
                                        <span
                                            class="{{ $return->refund_method === 'cash' ? 'text-danger' : 'text-success' }}">
                                            ৳{{ number_format($return->sub_total, 2) }}
                                        </span><br>
                                        @if ($return->refund_method === 'adjust_due')
                                            Invoice Adjusted: -৳{{ number_format($return->sub_total, 2) }}
                                        @endif
                                    </div>
                                    <div class="arrow">↓</div>
                                    <div class="diagram-box">
                                        Updated Payment & Invoice
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            @empty
                <div class="text-center text-muted">
                    No fully paid transactions found.
                </div>
            @endforelse

        </div>
    </div>
@stop

@section('css')
    <style>
        .diagram-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .diagram-box {
            background-color: #f8f9fa;
            border: 2px solid #dc3545;
            border-radius: 10px;
            padding: 10px 15px;
            width: 250px;
            margin-bottom: 5px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
            font-weight: bold;
        }

        .arrow {
            font-size: 20px;
            margin: 3px 0;
            color: #dc3545;
        }
    </style>
@stop
