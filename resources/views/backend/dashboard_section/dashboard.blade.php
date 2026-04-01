@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h3 class="fw-bold mb-2">Welcome {{ Auth::user()->name }} </h3>
    <p class="text-muted">Your business performance summary at a glance.</p>

    <div class="mt-2 p-2 bg-light">
        <p class="mb-1">
            💡 ProsharPOS is ready to help you manage sales, track inventory, and keep your customers happy!
        </p>
        <p class="mb-0 small text-muted">
            Tip: Check your daily sales and pending orders to stay on top of your business.
        </p>
    </div>
@endsection

@section('content')

    <div class="row g-4">

        {{-- ================= ADMIN & MANAGER ================= --}}
        @role('admin|manager')
            @include('backend.dashboard_section.dashboard_part.part_1')
            @include('backend.dashboard_section.dashboard_part.part_2')
            @include('backend.dashboard_section.dashboard_part.part_3')

            {{-- BDT PAYMENT --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-cyan text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>{{ $totalPayment }} Tk</h3>
                        <p>BDT Payment</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <a href="{{ route('payments.index') }}" class="small-box-footer">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            {{-- Dollar Payment --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-cyan text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>$ {{ $totalPaymentInDollar }}</h3>
                        <p>Dollar Payment</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <a href="{{ route('payments.index') }}" class="small-box-footer">
                        More Info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endrole


        {{-- ================= CASHIER ================= --}}
        @role('cashier')
            {{-- Only Invoice + Sales --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-primary text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>{{ $total_invoices }}</h3>
                        <p>Total Invoice</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-success text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>{{ $salesAmount }} Tk</h3>
                        <p>Sales Amount</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                </div>
            </div>
        @endrole


        {{-- ================= INVENTORY MANAGER ================= --}}
        @role('inventory_manager')
            {{-- You can connect real data later --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-info text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>{{ $total_products ?? 0 }}</h3>
                        <p>Total Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-warning text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>{{ $total_stock_movements ?? 0 }}</h3>
                        <p>Stock Movement</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-random"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-danger text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>{{ $damaged_products ?? 0 }}</h3>
                        <p>Damaged Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-secondary text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>{{ $expired_products ?? 0 }}</h3>
                        <p>Expired Products</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        @endrole


        {{-- ================= ACCOUNTANT ================= --}}
        @role('accountant')
            {{-- Sales (optional) --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-success text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>{{ $salesAmount }} Tk</h3>
                        <p>Sales Amount</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-cash-register"></i>
                    </div>
                </div>
            </div>

            {{-- Receive --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-indigo text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>{{ $receiveAmount }} Tk</h3>
                        <p>Receive Amount</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                </div>
            </div>

            {{-- Due --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-danger text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>{{ $dueAmount }} Tk</h3>
                        <p>Due Amount</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hourglass-end"></i>
                    </div>
                </div>
            </div>

            {{-- Payments --}}
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="small-box bg-cyan text-white shadow-sm dashboard-box">
                    <div class="inner">
                        <h3>{{ $totalPayment }} Tk</h3>
                        <p>Total Payment</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
            </div>

            {{-- Petty Cash --}}
            @include('backend.dashboard_section.dashboard_part.part_3')
        @endrole

    </div>

    {{-- STYLES --}}
    <style>
        .dashboard-box {
            transition: transform .2s ease-in-out, box-shadow .2s ease-in-out;
            border-radius: 8px;
        }

        .dashboard-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .small-box .icon i {
            opacity: 0.3;
            font-size: 70px;
            position: absolute;
            top: 15px;
            right: 15px;
        }
    </style>

@endsection
