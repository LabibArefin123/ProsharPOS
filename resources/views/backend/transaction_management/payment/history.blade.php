@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Transaction History</h3>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/backend/transaction_management/payment/custom_history.css') }}">
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">

            @forelse($transactions as $tx)
                <div class="transaction-card p-3 mb-3 border rounded shadow-sm">

                    {{-- Header --}}
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong>{{ $tx->description }}</strong><br>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}
                                ({{ \Carbon\Carbon::parse($tx->created_at)->format('h:i:s A') }})
                            </small>
                        </div>
                        <div>
                            <strong>User:</strong> {{ $tx->user->name ?? 'N/A' }}
                        </div>
                    </div>

                    {{-- Transaction Amount --}}
                    <div class="mb-2">
                        @php
                            switch ($tx->type) {
                                case 'deposit':
                                    $sign = '+';
                                    $color = 'text-success';
                                    $label = 'Deposit';
                                    break;
                                case 'withdraw':
                                    $sign = '-';
                                    $color = 'text-danger';
                                    $label = 'Withdraw';
                                    break;
                                case 'payment':
                                    $sign = '-';
                                    $color = 'text-danger';
                                    $label = 'Customer Payment';
                                    break;
                                case 'supplier_payment':
                                    $sign = '-';
                                    $color = 'text-warning';
                                    $label = 'Supplier Payment';
                                    break;
                                case 'purchase':
                                    $sign = '-';
                                    $color = 'text-warning';
                                    $label = 'Purchase';
                                    break;
                                case 'purchase_return':
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
                        <span class="{{ $color }}">
                            <strong>{{ $label }}:</strong> {{ $sign }}
                            ৳{{ number_format(abs($tx->amount), 2) }}
                        </span>
                    </div>

                    {{-- Return Flow (for payments with returns) --}}
                    @if (
                        $tx->type === 'payment' &&
                            isset($tx->payment) &&
                            $tx->payment->payment_type === 'return' &&
                            $tx->payment->invoice->salesReturns->isNotEmpty())
                        @include('backend.transaction_management.payment.flow.flow', [
                            'payment' => $tx->payment,
                        ])
                    @endif

                    {{-- Balance Flow --}}
                    <div class="d-flex justify-content-between fw-bold mt-2 p-2 bg-light rounded">
                        <div>Old Balance: ৳{{ number_format($tx->new_balance, 2) }}</div>
                        <div>Transaction: {{ $sign }} ৳{{ number_format(abs($tx->amount), 2) }}</div>
                        <div class="text-primary">New Balance: ৳{{ number_format($tx->old_balance, 2) }}</div>
                    </div>

                </div>
            @empty
                <div class="text-center text-muted">No transactions found.</div>
            @endforelse

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                @if ($totalPages > 1)
                    @for ($i = 1; $i <= $totalPages; $i++)
                        <a href="?page={{ $i }}"
                            class="btn btn-sm {{ $currentPage == $i ? 'btn-primary' : 'btn-outline-primary' }} mx-1">
                            {{ $i }}
                        </a>
                    @endfor
                @endif
            </div>

        </div>
    </div>
@stop

@section('js')
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
