@extends('adminlte::page')

@section('title', 'Sales Return Flow Diagram')

@section('content_header')
    <div class="transaction-page-heading">
        <i class="fas fa-project-diagram"></i>
        <div>
            <h3>Sales Return Flow Diagram</h3>
            <small class="transaction-muted">
                Follow the invoice, stock return and refund process.
            </small>
        </div>
    </div>
@stop

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/backend/transaction_management/payment/transaction_history.css') }}">
@stop

@section('content')
    <div class="flow-diagram-page">

        @forelse($salesReturns as $return)
            @php
                $originalQuantity = (int) ($return->invoice?->invoiceItems?->sum('quantity') ?? 0);
                $returnedQuantity = (int) ($return->items?->sum('quantity') ?? 0);

                $refundAmount = (float) ($return->sub_total ?? 0);
                $refundMethod = strtolower($return->refund_method ?? '');

                $refundLabel = match ($refundMethod) {
                    'adjust_due' => 'Adjusted Against Invoice Due',
                    'cash' => 'Cash Refund',
                    'bank' => 'Bank Refund',
                    'bkash' => 'bKash Refund',
                    'nagad' => 'Nagad Refund',
                    default => ucfirst(str_replace('_', ' ', $refundMethod ?: 'Not Specified')),
                };

                $invoice = $return->invoice;
                $customer = $invoice?->customer;
                $invoiceTotal = (float) ($invoice?->total ?? 0);
                $paidAmount = (float) ($invoice?->paid_amount ?? 0);
            @endphp

            <div class="flow-return-card">

                <div class="flow-return-header">
                    <div>
                        <h6 class="flow-return-title">
                            Return No: {{ $return->return_no }}
                        </h6>

                        <div class="flow-return-meta">
                            <span>
                                <i class="fas fa-file-invoice mr-1"></i>
                                Invoice: {{ $invoice?->invoice_id ?? 'N/A' }}
                            </span>

                            <span class="mx-2">•</span>

                            <span>
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $return->return_date
                                    ? \Carbon\Carbon::parse($return->return_date)->format('d M Y')
                                    : 'N/A' }}
                            </span>

                            @if ($customer)
                                <span class="mx-2">•</span>
                                <span>
                                    <i class="fas fa-user mr-1"></i>
                                    {{ $customer->name }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <button type="button"
                        class="flow-return-toggle"
                        data-target="return-flow-{{ $return->id }}"
                        aria-expanded="true">
                        <i class="fas fa-chevron-up"></i>
                        <span class="toggle-label">Hide Details</span>
                    </button>
                </div>

                <div class="flow-return-content" id="return-flow-{{ $return->id }}">

                    <div class="flow-diagram-track">

                        {{-- Original Invoice --}}
                        <div class="flow-node purchase">
                            <span class="flow-node-title">
                                <i class="fas fa-shopping-cart mr-1"></i>
                                Original Sale
                            </span>

                            <div class="flow-node-detail">
                                Invoice: <strong>{{ $invoice?->invoice_id ?? 'N/A' }}</strong><br>
                                Customer: <strong>{{ $customer?->name ?? 'N/A' }}</strong><br>
                                Original Items: <strong>{{ $originalQuantity }}</strong><br>
                                Invoice Total: <strong>৳{{ number_format($invoiceTotal, 2) }}</strong><br>
                                Amount Paid: <strong>৳{{ number_format($paidAmount, 2) }}</strong>
                            </div>

                            <span class="flow-status info">Sale Completed</span>
                        </div>

                        <div class="flow-arrow">
                            <i class="fas fa-arrow-down"></i>
                        </div>

                        {{-- Original Stock Movement --}}
                        <div class="flow-node stock">
                            <span class="flow-node-title">
                                <i class="fas fa-boxes mr-1"></i>
                                Stock Sold
                            </span>

                            <div class="flow-node-detail">
                                Original Sold Quantity:
                                <strong>{{ $originalQuantity }} items</strong><br>
                                Stock Movement:
                                <strong class="text-danger">−{{ $originalQuantity }}</strong>
                            </div>

                            <span class="flow-status warning">Stock Decreased</span>
                        </div>

                        <div class="flow-arrow">
                            <i class="fas fa-arrow-down"></i>
                        </div>

                        {{-- Customer Return --}}
                        <div class="flow-node return">
                            <span class="flow-node-title">
                                <i class="fas fa-rotate-left mr-1"></i>
                                Customer Return
                            </span>

                            <div class="flow-node-detail">
                                Returned Quantity:
                                <strong>{{ $returnedQuantity }} items</strong><br>
                                Stock Movement:
                                <strong class="text-success">+{{ $returnedQuantity }}</strong><br>
                                Return Amount:
                                <strong>৳{{ number_format($refundAmount, 2) }}</strong><br>
                                Refund Method:
                                <strong>{{ $refundLabel }}</strong>
                            </div>

                            <span class="flow-status success">Return Recorded</span>
                        </div>

                        <div class="flow-arrow">
                            <i class="fas fa-arrow-down"></i>
                        </div>

                        {{-- Financial Adjustment --}}
                        <div class="flow-node invoice">
                            <span class="flow-node-title">
                                <i class="fas fa-file-invoice-dollar mr-1"></i>
                                Financial Adjustment
                            </span>

                            <div class="flow-node-detail">
                                @if ($refundMethod === 'adjust_due')
                                    Invoice Due Adjustment:
                                    <strong class="text-success">
                                        −৳{{ number_format($refundAmount, 2) }}
                                    </strong><br>
                                    The return amount is adjusted against the customer's invoice due.
                                @elseif ($refundMethod !== '')
                                    Refund Method:
                                    <strong>{{ $refundLabel }}</strong><br>
                                    Refund Amount:
                                    <strong class="text-danger">
                                        ৳{{ number_format($refundAmount, 2) }}
                                    </strong>
                                @else
                                    Refund Details:
                                    <strong>Not specified</strong>
                                @endif
                            </div>

                            <span class="flow-status info">Adjustment Recorded</span>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="card">
                <div class="card-body">
                    <div class="flow-empty">
                        <i class="fas fa-project-diagram"></i>
                        <strong>No sales returns found</strong>
                        <span>Sales return flow records will appear here when available.</span>
                    </div>
                </div>
            </div>
        @endforelse

    </div>
@stop

@section('js')
    <script src="{{ asset('js/backend/transaction_management/payment/history_tooltips.js') }}"></script>
    <script src="{{ asset('js/backend/transaction_management/payment/flow_diagram_toggle.js') }}"></script>
    <script src="{{ asset('js/backend/transaction_management/payment/flow_diagram.js') }}"></script>
@stop