@extends('frontend.layouts.app')

@section('title', 'Help & Support')

@section('content')
    @include('frontend.welcome_page.header')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Help & Support</h2>
                <p class="text-muted">
                    Learn how ProSharpos POS works and get answers to common questions
                </p>
            </div>

            <div class="row g-4">

                <!-- Getting Started -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="fw-semibold">Getting Started</h5>
                            <ul class="list-unstyled small mt-3">
                                <li>• What is ProSharpos POS?</li>
                                <li>• How to use the demo</li>
                                <li>• System requirements</li>
                                <li>• Internet & device setup</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- POS Features -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="fw-semibold">POS Features</h5>
                            <ul class="list-unstyled small mt-3">
                                <li>• Sales & billing</li>
                                <li>• Inventory management</li>
                                <li>• Customer & supplier</li>
                                <li>• Reports & analytics</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Accounts & Security -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="fw-semibold">Accounts & Security</h5>
                            <ul class="list-unstyled small mt-3">
                                <li>• Login & user roles</li>
                                <li>• Data security</li>
                                <li>• Backup & recovery</li>
                                <li>• Password safety</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Call to Action -->
            <div class="text-center mt-5">
                <p class="text-muted">
                    Need more help?
                </p>
                <a href="{{ route('home') }}" class="btn btn-primary px-4">
                    Contact Support
                </a>
            </div>
        </div>
    </section>
    @include('frontend.welcome_page.footer')
@endsection
