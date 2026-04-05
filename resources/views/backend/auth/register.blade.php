@extends('frontend.layouts.app')

@section('content')

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

                    {{-- LEFT SIDE (Same as login) --}}
                    @include('backend.auth.login.left')

                    {{-- RIGHT SIDE : REGISTER --}}
                    <div class="col-lg-6">
                        <div class="p-4 p-md-5">

                            <h4 class="fw-bold mb-1">Create Account</h4>
                            <p class="text-muted small mb-4">
                                Start managing your business today 🚀
                            </p>

                            {{-- Validation Errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger small">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li><i class="fas fa-circle-exclamation me-1"></i> {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                {{-- Name --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Full Name</label>
                                    <div class="input-group input-group-lg shadow-sm">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" name="name"
                                            class="form-control border-start-0"
                                            placeholder="Enter full name"
                                            value="{{ old('name') }}" required>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Email Address</label>
                                    <div class="input-group input-group-lg shadow-sm">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                        <input type="email" name="email"
                                            class="form-control border-start-0"
                                            placeholder="Enter email"
                                            value="{{ old('email') }}" required>
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Password</label>
                                    <div class="input-group input-group-lg shadow-sm">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password" name="password"
                                            class="form-control border-start-0"
                                            placeholder="Enter password" required>
                                    </div>
                                </div>

                                {{-- Confirm Password --}}
                                <div class="mb-4">
                                    <label class="form-label fw-semibold small">Confirm Password</label>
                                    <div class="input-group input-group-lg shadow-sm">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password" name="password_confirmation"
                                            class="form-control border-start-0"
                                            placeholder="Confirm password" required>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="submit"
                                        class="btn btn-success btn-lg rounded-pill px-4 shadow">
                                        <i class="fas fa-user-plus me-1"></i> Register
                                    </button>

                                    <a href="{{ route('login') }}"
                                        class="small fw-semibold text-decoration-none">
                                        Already have account?
                                    </a>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

            {{-- Footer --}}
            <p class="text-center text-muted small mt-3">
                Designed & Developed by
                <a href="#" class="fw-semibold text-decoration-none">
                    Labib Arefin
                </a>
            </p>

        </div>

    </div>
</div>

@endsection