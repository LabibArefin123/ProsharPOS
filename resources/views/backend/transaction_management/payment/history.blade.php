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

            @php
                $runningBalance = $runningBalance ?? 0;
            @endphp

            @forelse($transactions as $tx)
                @php
                    // Transaction logic
                    $amount = $tx->amount;
                    $oldBalance = $runningBalance;

                    if ($tx->type === 'deposit') {
                        $runningBalance += $amount;
                        $sign = '+';
                        $color = 'text-success';
                        $label = 'Deposit';
                    } elseif ($tx->type === 'withdraw') {
                        $runningBalance -= $amount;
                        $sign = '-';
                        $color = 'text-danger';
                        $label = 'Withdraw';
                    } else {
                        // payment
                        $runningBalance -= $amount;
                        $sign = '-';
                        $color = 'text-danger';
                        $label = 'Payment';
                    }
                @endphp

                <div class="border rounded p-3 mb-3 shadow-sm">

                    {{-- Transaction Info --}}
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <strong>{{ $tx->type === 'payment' ? '#' . $tx->payment->payment_id : $tx->description }}</strong><br>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}</small>
                        </div>
                        <div class="col-md-2">
                            <strong>User</strong><br>{{ $tx->user->name ?? 'N/A' }}
                        </div>
                        <div class="col-md-2">
                            <strong>Transaction</strong><br>
                            <span class="{{ $color }}">{{ $label }}: ৳{{ number_format($amount, 2) }}</span>
                        </div>
                    </div>

                    {{-- Collapsible Balance Row --}}
                    <div class="row balance-row mt-3" >
                        <div class="col-md-4">
                            <strong>Old Balance</strong><br>৳{{ number_format($oldBalance, 2) }}
                        </div>
                        <div class="col-md-4 text-success">
                            <strong>Transaction</strong><br>
                            {{ $sign }} ৳{{ number_format($amount, 2) }}
                        </div>
                        <div class="col-md-4 text-primary fw-bold">
                            <strong>New Balance</strong><br>৳{{ number_format($runningBalance, 2) }}
                        </div>
                    </div>

                    {{-- Sales Return Flow --}}
                    @if (
                        $tx->type === 'payment' &&
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
        document.addEventListener('DOMContentLoaded', function() {

            // Toggle balance row
            document.querySelectorAll('.toggle-balance').forEach(btn => {
                btn.addEventListener('click', () => {
                    const row = btn.closest('.border').querySelector('.balance-row');
                    if (row.style.display === 'none' || row.style.display === '') {
                        row.style.display = 'flex';
                        btn.innerHTML = 'Balance Flow &laquo;';
                    } else {
                        row.style.display = 'none';
                        btn.innerHTML = 'Balance Flow &raquo;';
                    }
                });
            });

            // Collapsible sales return diagram content
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
