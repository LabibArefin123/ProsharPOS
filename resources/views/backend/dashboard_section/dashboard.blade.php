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
    {{-- Start of float box js  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const boxes = document.querySelectorAll('.dashboard-box');

            boxes.forEach(box => {
                const pendingBox = box.querySelector('.pending-float');

                if (!pendingBox) return;

                // Show on mouse enter
                box.addEventListener('mouseenter', () => {
                    pendingBox.style.display = 'block';
                });

                // Hide on mouse leave
                box.addEventListener('mouseleave', () => {
                    pendingBox.style.display = 'none';
                });

                // Toggle on click (mobile friendly)
                box.addEventListener('click', (e) => {
                    e.stopPropagation();

                    // Hide all others
                    document.querySelectorAll('.pending-float').forEach(el => {
                        if (el !== pendingBox) el.style.display = 'none';
                    });

                    // Toggle current
                    pendingBox.style.display =
                        pendingBox.style.display === 'block' ? 'none' : 'block';
                });
            });

            // Click outside closes all
            document.addEventListener('click', () => {
                document.querySelectorAll('.pending-float').forEach(el => {
                    el.style.display = 'none';
                });
            });

        });
    </script>

    {{-- End of float box js  --}}
@endsection
