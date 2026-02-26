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
                   @include('backend.transaction_management.payment.flow.flow')
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
