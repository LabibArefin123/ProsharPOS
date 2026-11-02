@extends('frontend.layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/frontend/login_page/custom_login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/login_page/custom_modal/login_modal.css') }}">
    {{-- Problem Report Modal Styles --}}
    <link rel="stylesheet" href="{{ asset('css/frontend/login_page/problem_report/problem_report_box.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/login_page/problem_report/problem_report_form.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/login_page/problem_report/problem_report_upload.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/login_page/problem_report/problem_report_footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/frontend/login_page/problem_report/problem_report_responsive.css') }}">
    <main class="login-page" style="--login-wallpaper: url('{{ asset('images/wallpaper.jpg') }}');">
        <div class="login-wrapper">
            <div class="login-card">
                <div class="row g-0 h-100">
                    {{-- LEFT: BRANDING --}}
                    @include('backend.auth.login.left')
                    {{-- RIGHT: LOGIN FORM --}}
                    @include('backend.auth.login.right')
                </div>
            </div>

            {{-- Footer --}}
            <div class="login-footer">
                <span>Powered by</span>
                <a href="#" id="visitDeveloper">Labib Arefin</a>
                <span class="footer-divider">·</span>
                <span>ProsharPOS Business Solutions</span>
            </div>

        </div>
        {{-- Problem Modal --}}
        @include('backend.auth.login.modal.problem')
    </main>
    {{-- 
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Password visibility
            const passwordInput = document.getElementById('loginPassword');
            const passwordToggle = document.getElementById('togglePassword');

            if (passwordInput && passwordToggle) {
                passwordToggle.addEventListener('click', function() {
                    const isPassword = passwordInput.type === 'password';

                    passwordInput.type = isPassword ? 'text' : 'password';

                    this.innerHTML = isPassword ?
                        '<i class="far fa-eye-slash"></i>' :
                        '<i class="far fa-eye"></i>';

                    this.setAttribute(
                        'aria-label',
                        isPassword ? 'Hide password' : 'Show password'
                    );
                });
            }


        });
    </script> --}}
    <script src="{{ asset('js/frontend/login_page/custom_problem.js') }}" defer></script>
    <script src="{{ asset('js/frontend/login_page/custom_description.js') }}" defer></script>
    <script src="{{ asset('js/frontend/login_page/problem_upload_config.js') }}" defer></script>
    <script src="{{ asset('js/frontend/login_page/problem_upload_preview.js') }}" defer></script>
    <script src="{{ asset('js/frontend/login_page/problem_upload_selection.js') }}" defer></script>
    <script src="{{ asset('js/frontend/login_page/problem_upload_submit.js') }}" defer></script>
    <script src="{{ asset('js/frontend/login_page/file_progress.js') }}" defer></script>
@endsection
