@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="font-bold text-dark mb-1">ProsharPOS Dashboard</h1>
    <p class="text-muted">Your business performance summary at a glance.</p>
@endsection

@section('content')

    <div class="row g-4">

        {{-- TOTAL INVOICE --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-primary text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>{{ $total_invoices }}</h3>
                    <p>Total Invoice</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <a href="{{ route('invoices.index') }}" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- SALES AMOUNT --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-success text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>{{ $salesAmount }} Tk</h3>
                    <p>Sales Amount</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cash-register"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- RECEIVE AMOUNT --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-indigo text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>{{ $receiveAmount }} Tk</h3>
                    <p>Receive Amount</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- DUE AMOUNT --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-danger text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>{{ $dueAmount }} Tk</h3>
                    <p>Due Amount</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-end"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- TOTAL CHALLAN --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-warning text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>{{ $total_challans }}</h3>
                    <p>Total Challan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-truck-loading"></i>
                </div>
                <a href="{{ route('challans.index') }}" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- CHALLAN UNBILLED --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-pink text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>{{ $total_challan_unbill }}</h3>
                    <p>Challan Unbilled</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ban"></i>
                </div>
                <a href="{{ route('challans.index') }}" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- CHALLAN BILLED --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-info text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>{{ $total_challan_bill }}</h3>
                    <p>Challan Billed</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <a href="{{ route('challans.index') }}" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        {{-- CHALLAN FOC --}}
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-purple text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>{{ $total_challan_foc }}</h3>
                    <p>Challan FOC</p>
                </div>
                <div class="icon">
                    <i class="fas fa-gift"></i>
                </div>
                <a href="{{ route('challans.index') }}" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 ">
            <div class="small-box bg-orange text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>00 Tk</h3>
                    <p>Petty Cash Receive</p>
                </div>
                <div class="icon">
                    <i class="fas fa-coins"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 ">
            <div class="small-box bg-lime text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>00 Tk</h3>
                    <p>Petty Cash Expense</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 ">
            <div class="small-box bg-warning text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>00$</h3>
                    <p>Petty Cash Dollar Receive</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12 ">
            <div class="small-box bg-pink text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>00$</h3>
                    <p>Petty Cash Dollar Expense</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More Info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
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
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="small-box bg-cyan text-white shadow-sm dashboard-box">
                <div class="inner">
                    <h3>$ {{ $totalPaymentInDollar }} </h3>
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
    </div>

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
