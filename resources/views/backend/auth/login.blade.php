@extends('frontend.layouts.app')

@section('content')
    <!-- Background -->
    <style>
        body {
            background: url('{{ asset('images/wallpaper.jpg') }}') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/frontend/login_page/custom_login.css') }}">
    <div class="container min-vh-100 d-flex align-items-center">
        <div class="row w-100 justify-content-center">

            <div class="col-xl-9 col-lg-11">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        @include('backend.auth.login.left')
                        @include('backend.auth.login.right')
                    </div>
                </div>
                @include('backend.auth.login.modal.problem')

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



    <script>
        document.addEventListener("DOMContentLoaded", function() {

            window.openProblemModal = function() {
                document.getElementById('problemModal').classList.add('show');
            }

            window.closeProblemModal = function() {
                document.getElementById('problemModal').classList.remove('show');
            }

            const modal = document.getElementById('problemModal');

            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeProblemModal();
                }
            });

        });
    </script>
@endsection
