@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Transaction History (Fully Paid)</h3>
    </div>
@stop

@section('css')
    <style>
        .diagram-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-height: 300px;
            overflow-y: auto;
            padding: 5px 0;
        }

        .diagram-box {
            background-color: #f8f9fa;
            border: 2px solid #dc3545;
            border-radius: 10px;
            padding: 8px 12px;
            width: 220px;
            margin-bottom: 5px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .diagram-box:hover {
            transform: scale(1.03);
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .arrow {
            font-size: 18px;
            margin: 2px 0;
            color: #dc3545;
        }

        .flow-diagram {
            cursor: pointer;
        }

        .flow-diagram .diagram-content {
            display: none;
            margin-top: 5px;
        }
    </style>
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
                            <div class="diagram-header">
                                <strong>View Return Flow &raquo;</strong>
                            </div>
                            <div class="diagram-content mt-2">
                                @foreach ($payment->invoice->salesReturns as $return)
                                    <h6>Return No: <strong>{{ $return->return_no }}</strong> | Invoice:
                                        <strong>{{ $return->invoice->invoice_id }}</strong>
                                    </h6>

                                    <div class="diagram-container">
                                        <div class="diagram-box" data-bs-toggle="tooltip" data-bs-html="true"
                                            title="Bought: {{ $return->items->sum('quantity') }}<br>
                                                Payment: ৳{{ number_format($return->invoice->paid_amount ?? 0, 2) }}">
                                            Customer Bought: {{ $return->items->sum('quantity') }} Items<br>
                                            Payment: ৳{{ number_format($return->invoice->paid_amount ?? 0, 2) }}
                                        </div>
                                        <div class="arrow">↓</div>
                                        <div class="diagram-box" data-bs-toggle="tooltip" data-bs-html="true"
                                            title="Stock reduced by {{ $return->items->sum('quantity') }}<br>
                                                Invoice items: {{ $return->items->sum('quantity') }}">
                                            Stock: -{{ $return->items->sum('quantity') }} (sold)<br>
                                            Invoice: {{ $return->items->sum('quantity') }} Items
                                        </div>
                                        <div class="arrow">↓</div>
                                        <div class="diagram-box" data-bs-toggle="tooltip" data-bs-html="true"
                                            title="Returned: {{ $return->items->sum('quantity') }}<br>
                                                Refund: ৳{{ number_format($return->sub_total, 2) }}<br>
                                                @if ($return->refund_method === 'adjust_due')
Invoice Adjusted: -৳{{ number_format($return->sub_total, 2) }}
@endif">
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
                                        <div class="diagram-box" data-bs-toggle="tooltip" data-bs-html="true"
                                            title="Payment and Invoice updated">
                                            Updated Payment & Invoice
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Collapsible diagram content
            document.querySelectorAll('.flow-diagram .diagram-header').forEach(header => {
                header.addEventListener('click', () => {
                    const content = header.nextElementSibling;
                    content.style.display = (content.style.display === 'block') ? 'none' : 'block';
                });
            });

            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@stop
