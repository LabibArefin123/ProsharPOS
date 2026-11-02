{{-- LOGIN FORM PANEL --}}
<div class="col-lg-6 login-form-panel">
    <div class="login-form-content">
        {{-- Mobile Brand --}}
        <div class="mobile-brand">
            <img src="{{ asset('uploads/images/logor.png') }}" alt="ProsharPOS">
            <span>{{ $systemInfo->name ?? 'ProsharPOS' }}</span>
        </div>

        {{-- Welcome --}}
        <div class="login-heading">

            <div class="login-welcome-icon">
                <i class="fas fa-hand-sparkles"></i>
            </div>

            <span class="login-eyebrow">WELCOME BACK</span>

            <h2>Sign in to your account</h2>

            <p>
                Welcome back! Please enter your details to continue
                managing your business.
            </p>

        </div>

        {{-- Session Error --}}
        @if (session('error'))
            <div class="login-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="login-alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>Please check your login information and try again.</span>
            </div>
        @endif

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}" class="login-form">

            @csrf

            {{-- Username / Email --}}
            <div class="login-field">

                <label for="loginUsername">
                    Email Address / Username
                </label>

                <div class="login-input-wrapper @error('login') has-error @enderror">

                    <span class="login-input-icon">
                        <i class="fas fa-user"></i>
                    </span>

                    <input type="text" id="loginUsername" name="login" value="{{ old('login') }}"
                        placeholder="Enter your email or username" autocomplete="username" required autofocus>

                </div>

                @error('login')
                    <small class="login-error">{{ $message }}</small>
                @enderror

            </div>

            {{-- Password --}}
            <div class="login-field">

                <label for="loginPassword">
                    Password
                </label>

                <div class="login-input-wrapper @error('password') has-error @enderror">

                    <span class="login-input-icon">
                        <i class="fas fa-lock"></i>
                    </span>

                    <input type="password" id="loginPassword" name="password" placeholder="Enter your password"
                        autocomplete="current-password" required>

                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
                        <i class="far fa-eye"></i>
                    </button>

                </div>

                @error('password')
                    <small class="login-error">{{ $message }}</small>
                @enderror

            </div>

            {{-- Remember / Forgot --}}
            <div class="login-options">

                <label class="remember-option">
                    <input type="checkbox" name="remember" value="1">
                    <span>Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        Forgot password?
                    </a>
                @endif

            </div>

            {{-- Submit --}}
            <button type="submit" class="login-submit-btn">

                <span>Sign In to Your Account</span>

                <i class="fas fa-arrow-right"></i>

            </button>

        </form>

        {{-- Divider --}}
        <div class="login-divider">
            <span>NEED ASSISTANCE?</span>
        </div>

        {{-- Support --}}
        <div class="login-support">

            <div class="support-icon">
                <i class="fas fa-headset"></i>
            </div>

            <div class="support-content">
                <h6>Having trouble signing in?</h6>

                <p>
                    Don't worry! Let our technical team help you.
                </p>

                <button type="button" class="login-problem-link" onclick="openProblemModal()">

                    <i class="fas fa-headset"></i>
                    Report a Problem
                </button>
            </div>

        </div>

        {{-- Security Message --}}
        <div class="login-security">
            <i class="fas fa-shield-alt"></i>
            Your business information is protected.
        </div>
    </div>
</div>
