@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="font-bold text-dark mb-1">Dashboard Overview</h1>
@endsection

@section('content')

    <div class="card">
        <div class="card-body">

            <div class="row">
                @php
                    $metrics = [
                        [
                            'label' => 'Total Invoice',
                            'value' => $total_invoices,
                            'icon' => 'fas fa-file-invoice-dollar',
                            'color' => 'primary',
                            'route' => route('invoices.index'),
                        ],
                        [
                            'label' => 'Sales Amount',
                            'value' => $salesAmount . ' Tk',
                            'icon' => 'fas fa-cash-register',
                            'color' => 'success',
                        ],

                        [
                            'label' => 'Receive Amount',
                            'value' => $receiveAmount . ' Tk',
                            'icon' => 'fas fa-hand-holding-usd',
                            'color' => 'purple',
                        ],
                        [
                            'label' => 'Due Amount',
                            'value' => $dueAmount . ' Tk',
                            'icon' => 'fas fa-hourglass-end',
                            'color' => 'danger',
                        ],
                        [
                            'label' => 'Total Challan',
                            'value' => $total_challans,
                            'icon' => 'fas fa-truck-loading',
                            'color' => 'warning',
                            'route' => route('challans.index'),
                        ],
                        [
                            'label' => 'Challan Unbill',
                            'value' => $total_challan_unbill,
                            'icon' => 'fas fa-ban',
                            'color' => 'pink',
                            'route' => route('challans.index'),
                        ],
                        [
                            'label' => 'Challan Bill',
                            'value' => $total_challan_bill,
                            'icon' => 'fas fa-file-invoice',
                            'color' => 'info',
                            'route' => route('challans.index'),
                        ],
                        [
                            'label' => 'Challan FOC',
                            'value' => $total_challan_foc,
                            'icon' => 'fas fa-gift',
                            'color' => 'indigo',
                        ],
                        [
                            'label' => 'Petty Cash Receive',
                            'value' => '0 Tk',
                            'icon' => 'fas fa-coins',
                            'color' => 'orange',
                        ],
                        [
                            'label' => 'Petty Cash Expense',
                            'value' => '0 Tk',
                            'icon' => 'fas fa-wallet',
                            'color' => 'lime',
                        ],
                        [
                            'label' => 'Petty Cash Dollar Receive',
                            'value' => '0$',
                            'icon' => 'fas fa-dollar-sign',
                            'color' => 'emerald',
                        ],
                        [
                            'label' => 'Petty Cash Dollar Expense',
                            'value' => '0$',
                            'icon' => 'fas fa-money-bill-wave',
                            'color' => 'rose',
                        ],
                        [
                            'label' => 'BDT Payment',
                            'value' => $totalPayment . ' Tk',
                            'icon' => 'fas fa-credit-card',
                            'color' => 'cyan',
                            'route' => route('payments.index'),
                        ],
                        [
                            'label' => 'Dollar Payment',
                            'value' => '0$',
                            'icon' => 'fas fa-money-check-alt',
                            'color' => 'secondary',
                        ],
                    ];
                @endphp

                @foreach ($metrics as $metric)
                    <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
                        <a href="{{ $metric['route'] ?? '#' }}" class="text-decoration-none metric-card-link"
                            data-label="{{ $metric['label'] }}">
                            <div class="card border border-{{ $metric['color'] }} shadow-sm h-100 hover-shadow">
                                <div class="card-body d-flex align-items-center justify-content-between gap-3">
                                    <div class="flex-grow-1 text-wrap">
                                        <h6 class="text-{{ $metric['color'] }} mb-1 font-weight-bold">
                                            {{ $metric['label'] }}
                                        </h6>
                                        <div class="text-dark font-weight-bold" style="font-size: 1.25rem;">
                                            {{ $metric['value'] }}</div>
                                    </div>
                                    <div class="icon-container text-{{ $metric['color'] }} flex-shrink-0 text-end"
                                        style="width: 48px;">
                                        <i class="{{ $metric['icon'] }} fa-2x"></i>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


    <style>
        .metric-card-link {
            position: relative;
            display: block;
        }

        .metric-card-link::after {
            content: attr(data-label);
            position: absolute;
            bottom: 100%;
            left: 0;
            background-color: #ff9900;
            color: white;
            padding: 4px 8px;
            font-size: 0.75rem;
            border-radius: 4px;
            white-space: nowrap;
            opacity: 0;
            transform: translateY(-5px);
            pointer-events: none;
            transition: all 0.3s ease-in-out;
            z-index: 99;
        }

        .metric-card-link:hover::after {
            opacity: 1;
            transform: translateY(-10px);
        }

        .icon-container {
            transition: transform 0.3s ease;
            text-align: right;
        }

        .metric-card-link:hover .icon-container {
            transform: scale(1.2);
        }

        .metric-card-link .card-body {
            min-height: 100px;
        }

        .hover-shadow:hover {
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.2) !important;
        }
    </style>
@endsection
