@extends('adminlte::page')

@section('title', 'Transaction History')

@section('content_header')
    <div class="transaction-page-heading">
        <i class="fas fa-receipt"></i>
        <div>
            <h3>Transaction History</h3>
            <small class="transaction-muted">Review deposits, withdrawals and payment activities.</small>
        </div>
    </div>
@stop

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/backend/transaction_management/payment/transaction_history.css') }}">
@stop

@section('content')
    <div class="transaction-history-page">
        <div class="card">
            <div class="card-body">

                @forelse($transactions as $tx)
                    <div class="transaction-card">

                        {{-- Header --}}
                        <div class="transaction-card-header">
                            <div>
                                <div class="transaction-card-title">
                                    {{ $tx->description }}
                                </div>

                                <div class="transaction-card-date">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}

                                    <span class="mx-1">•</span>

                                    <i class="far fa-clock mr-1"></i>
                                    {{ \Carbon\Carbon::parse($tx->created_at)->format('h:i:s A') }}
                                </div>
                            </div>

                            <div class="transaction-card-actor-wrapper">
                                <div class="transaction-card-actor">
                                    @if ($tx->user)
                                        <strong>
                                            <i class="fas fa-user mr-1"></i>
                                            User
                                        </strong>
                                        <div>{{ $tx->user->name }}</div>
                                    @elseif(in_array($tx->type, ['supplier_payment', 'purchase', 'purchase_return']))
                                        <strong>
                                            <i class="fas fa-truck mr-1"></i>
                                            Supplier
                                        </strong>
                                        <div>{{ $tx->source->supplier->name ?? 'N/A' }}</div>
                                    @else
                                        <strong>
                                            <i class="fas fa-cogs mr-1"></i>
                                            Source
                                        </strong>
                                        <div>System</div>
                                    @endif
                                </div>

                                <a href="{{ route('payments.flow-diagram') }}" class="transaction-flow-btn"
                                    data-bs-toggle="tooltip" title="View transaction flow diagram">

                                    <i class="fas fa-project-diagram"></i>
                                    <span>Show Flow Diagram</span>
                                </a>
                            </div>
                        </div>

                        {{-- Transaction Amount --}}
                        <div class="transaction-amount-section">
                            <div>
                                <div class="transaction-amount-label">Transaction Type</div>

                                <span class="transaction-type-badge {{ $tx->class }}">
                                    <i class="fas {{ $tx->icon }}"></i>
                                    {{ $tx->label }}
                                </span>
                            </div>

                            <div class="text-right">
                                <div class="transaction-amount-label">Transaction Amount</div>

                                <div class="transaction-amount-value {{ $tx->class }}">
                                    {{ $tx->sign }}৳{{ $tx->formatted_amount }}
                                </div>
                            </div>
                        </div>

                        {{-- Balance --}}
                        <div class="transaction-balance">

                            <div class="transaction-balance-item old">
                                <span class="transaction-balance-label">Old Balance</span>

                                <span class="transaction-balance-value">
                                    @if ($tx->old_balance !== null)
                                        ৳{{ number_format($tx->old_balance, 2) }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>

                            <div class="transaction-balance-item transaction">
                                <span class="transaction-balance-label">Transaction</span>

                                <span class="transaction-balance-value">
                                    {{ $tx->sign }}৳{{ $tx->formatted_amount }}
                                </span>
                            </div>

                            <div class="transaction-balance-item new">
                                <span class="transaction-balance-label">New Balance</span>

                                <span class="transaction-balance-value">
                                    @if ($tx->new_balance !== null)
                                        ৳{{ number_format($tx->new_balance, 2) }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="transaction-empty">
                        <i class="fas fa-receipt"></i>
                        <strong>No transactions found</strong>
                        <span>Transaction records will appear here when available.</span>
                    </div>
                @endforelse

                @if ($totalPages > 1)
                    <div class="transaction-pagination">
                        @for ($i = 1; $i <= $totalPages; $i++)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"
                                class="btn btn-sm {{ $currentPage == $i ? 'btn-primary' : 'btn-outline-primary' }}">
                                {{ $i }}
                            </a>
                        @endfor
                    </div>
                @endif

            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/backend/transaction_management/payment/history_tooltips.js') }}"></script>
    <script src="{{ asset('js/backend/transaction_management/payment/transaction_history.js') }}"></script>
@stop
