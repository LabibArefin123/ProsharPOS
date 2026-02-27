@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Transaction History (Fully Paid)</h3>
    </div>
@stop
@section('css')
    <style>
        /* Transaction card styling */
        .transaction-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 12px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .transaction-card:hover {
            transform: scale(1.02);
            box-shadow: 2px 2px 7px rgba(0, 0, 0, 0.1);
        }

        .balance-row {
            margin-top: 10px;
        }

        /* Sales Return / Flow Diagram */
        .flow-diagram {
            margin-top: 12px;
            border-top: 1px dashed #dee2e6;
            padding-top: 10px;
        }

        .flow-diagram .diagram-header {
            cursor: pointer;
            font-weight: 600;
            color: #dc3545;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .flow-diagram .diagram-header:hover {
            text-decoration: underline;
        }

        .flow-diagram .diagram-content {
            display: none;
            margin-top: 8px;
            padding-left: 15px;
            border-left: 2px solid #dc3545;
        }

        .diagram-container {
            display: flex;
            flex-direction: column;
            gap: 6px;
            max-height: 300px;
            overflow-y: auto;
        }

        .diagram-box {
            background-color: #f8f9fa;
            border: 2px solid #dc3545;
            border-radius: 8px;
            padding: 6px 10px;
            font-weight: 500;
            cursor: pointer;
            transition: transform 0.15s ease;
        }

        .diagram-box:hover {
            transform: scale(1.03);
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.15);
        }

        .arrow {
            text-align: center;
            font-size: 16px;
            color: #dc3545;
            margin: 2px 0;
        }

        /* Responsive for mobile */
        @media (max-width: 576px) {
            .diagram-container {
                max-height: 200px;
            }

            .diagram-box {
                font-size: 14px;
                padding: 5px 8px;
            }
        }
    </style>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">

            @php
                $runningBalance = $runningBalance ?? 0;
            @endphp

            @forelse($transactions as $tx)
                @php
                    $amount = abs($tx->amount);
                    $oldBalance = $runningBalance;

                    switch ($tx->type) {
                        case 'deposit':
                            $runningBalance -= $amount; // reverse calculation
                            $sign = '+';
                            $color = 'text-success';
                            $label = 'Deposit';
                            break;

                        case 'withdraw':
                            $runningBalance += $amount;
                            $sign = '-';
                            $color = 'text-danger';
                            $label = 'Withdraw';
                            break;

                        case 'payment':
                            $runningBalance += $amount;
                            $sign = '-';
                            $color = 'text-danger';
                            $label = 'Payment';
                            break;

                        case 'purchase':
                            $runningBalance += $amount;
                            $sign = '-';
                            $color = 'text-warning';
                            $label = 'Purchase';
                            break;

                        case 'purchase_return':
                            $runningBalance -= $amount; // money comes back
                            $sign = '+';
                            $color = 'text-primary';
                            $label = 'Purchase Return';
                            break;

                        default:
                            $sign = '';
                            $color = 'text-dark';
                            $label = ucfirst($tx->type);
                    }
                @endphp
                
                <div class="transaction-card">

                    {{-- Header Info --}}
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <strong>
                                {{ $tx->type === 'payment' ? '#' . ($tx->payment->payment_id ?? 'N/A') : $tx->description }}
                            </strong><br>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}
                                ({{ \Carbon\Carbon::parse($tx->created_at)->format('h:i:s A') }})
                            </small>
                        </div>
                        <div class="col-md-2">
                            <strong>User</strong><br>
                            {{ $tx->user->name ?? 'N/A' }}
                        </div>
                        <div class="col-md-2">
                            <strong>Transaction</strong><br>
                            <span class="{{ $color }}">{{ $label }}: ৳{{ number_format($amount, 2) }}</span>
                        </div>
                    </div>

                    {{-- Balance Flow --}}
                    <div class="row balance-row">
                        <div class="col-md-4">
                            <strong>Old Balance</strong><br>
                            ৳{{ number_format($runningBalance, 2) }}
                        </div>
                        <div class="col-md-4">
                            <strong>Transaction</strong><br>
                            {{ $sign }} ৳{{ number_format($amount, 2) }}
                        </div>
                        <div class="col-md-4 text-primary fw-bold">
                            <strong>New Balance</strong><br>
                            ৳{{ number_format($oldBalance, 2) }}
                        </div>
                    </div>

                    {{-- Optional Sales Return Flow --}}
                    @if (
                        $tx->type === 'payment' &&
                            isset($tx->payment) &&
                            $tx->payment->payment_type === 'return' &&
                            $tx->payment->invoice->salesReturns->isNotEmpty())
                        @include('backend.transaction_management.payment.flow.flow', [
                            'payment' => $tx->payment,
                        ])
                    @endif

                </div>
            @empty
                <div class="text-center text-muted">
                    No transactions found.
                </div>
            @endforelse

        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#transactionsTable').DataTable({
                "pageLength": 5, // show 5 per page
                "order": [
                    [1, "desc"]
                ] // sort by Date & Time descending
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Toggle collapsible diagram
            document.querySelectorAll('.flow-diagram .diagram-header').forEach(header => {
                header.addEventListener('click', () => {
                    const content = header.nextElementSibling;
                    content.style.display = (content.style.display === 'block') ? 'none' : 'block';
                });
            });

            // Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

        });
    </script>
@stop
