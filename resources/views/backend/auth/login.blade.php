@extends('frontend.layouts.app')

@section('content')
    <div class="container min-vh-100 d-flex align-items-center">
        <div class="row w-100 justify-content-center">

            <div class="col-xl-9 col-lg-11">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        @include('backend.auth.login.left')
                        @include('backend.auth.login.right')
                    </div>
                </div>

                <!-- Footer -->
                <p class="text-center text-muted small mt-3">
                    Designed & Developed by
                    <a href="#" id="visitDeveloper" class="fw-semibold text-decoration-none">
                        Labib Arefin
                    </a>
                </p>
            </div>

        </div>
    </div>

    <!-- Background -->
    <style>
        body {
            background: url('{{ asset('images/wallpaper.jpg') }}') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
@endsection
