@extends('layouts.app')

@section('content')
    <div class="container"><br>
        <div class="text-center ">

            <img src="{{ asset('uploads/images/logor.png') }}" alt="Logo" style="width: 150px; height: 150px;">
        </div>

        <div class="row justify-content-center">
            <div class="col-md-16 text-center">
                <h1>ProsharPOS (Point of Sale System)</h1>

                <p class="fw-bold text-muted">Fast Billing. Smart Inventory. Powerful Business Insights.</p>
            </div>
        </div>


        <div class="row justify-content-center mt-2">
            <div class="col-md-5">

                {{-- Show error message --}}
                @if (session('error'))
                    <div class="alert alert-danger mb-3">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <div class="card shadow rounded-4 border-0">
                    <div class="card-body px-3 py-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="login" class="form-label fw-semibold">Email or Username</label>
                                <input id="login" type="text"
                                    class="form-control form-control-lg rounded-3 shadow-sm @error('login') is-invalid @enderror"
                                    name="login" value="{{ old('login') }}" placeholder="Enter your email or username"
                                    required autofocus>
                                @error('login')
                                    <div class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold"></label>
                                <input id="password" type="password"
                                    class="form-control form-control-lg rounded-3 shadow-sm @error('password') is-invalid @enderror"
                                    name="password" placeholder="Enter your password" required>
                                @error('password')
                                    <div class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm">
                                    Login
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none text-primary fw-semibold" href="#"
                                        id="forgotPasswordLink">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Helpdesk -->
        <div class="row justify-content-center mt-5">
            <div class="col-md-8 text-center">
                <h5>Need Help?</h5>
                <p class="mb-1">
                    <a href="#" class="text-decoration-none" id="callHelpdesk">📞 01776197999</a>
                </p>
                <p>
                    <a href="#" class="text-decoration-none" id="emailHelpdesk">📧 mdlabibarefin@gmail.com</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="row justify-content-center ">
            <div class="col-md-8 text-center">
                <p class="small text-muted">
                    Designed and Developed by
                    <a href="https://labib.work" class="text-decoration-none" id="visitDeveloper">Labib Arefin</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Background Wallpaper -->
    <style>
        body {
            background-image: url('{{ asset('images/wallpaper.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById("forgotPasswordLink").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Forgot Password?",
                text: "We'll help you recover it.",
                icon: "info",
                confirmButtonText: "Go to Reset Page"
            }).then(() => {
                window.location.href = "{{ route('password.request') }}";
            });
        });

        document.getElementById("callHelpdesk").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Call Helpdesk",
                text: "Do you want to call 01776197999?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Call Now"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "tel:01776197999";
                }
            });
        });

        document.getElementById("emailHelpdesk").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Email Helpdesk",
                text: "Do you want to email us?",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Email Now"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "mailto:mdlabibarefin@gmail.com";
                }
            });
        });

        document.getElementById("visitDeveloper").addEventListener("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Visit Developer?",
                text: "You are about to leave the page.",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Visit"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open("https://labib.work", "_blank");
                }
            });
        });
    </script>
@endsection
