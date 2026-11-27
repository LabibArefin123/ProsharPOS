<header class="sticky-header">
    {{-- TOP INFORMATION BAR --}}
    <div class="top-info-bar">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            {{-- CONTACT INFORMATION --}}
            <div class="contact-info d-none d-md-flex align-items-center">
                <a href="mailto:mdlabibarefin@gmail.com" class="contact-item">
                    <i class="fas fa-envelope"></i>
                    mdlabibarefin@gmail.com
                </a>

                <span class="text-white-50">|</span>

                <a href="tel:+8801776197999" class="contact-item">
                    <i class="fas fa-phone"></i>
                    +8801776197999
                </a>

                <a href="https://wa.me/8801776197999" target="_blank" rel="noopener noreferrer" class="contact-item">
                    <i class="fab fa-whatsapp"></i>
                    WhatsApp
                </a>
            </div>

            {{-- DATE AND TIME --}}
            <div class="fw-semibold">
                <i class="far fa-clock"></i>
                <span id="currentDateTime">
                    {{ \Carbon\Carbon::now()->format('l, d F Y, h:i:s A') }}
                </span>
            </div>

        </div>
    </div>

    {{-- MAIN NAVIGATION --}}
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container-fluid">
            {{-- COMPANY LOGO --}}
            <a href="{{ route('welcome') }}" class="navbar-brand">

                <img src="{{ asset('uploads/images/welcome_page/logo.JPG') }}" alt="ProsharPOS Logo" class="brand-image"
                    width="200" height="50">
            </a>

            {{-- MOBILE TOGGLE --}}
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- NAVIGATION LINKS --}}
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('welcome') }}"
                            class="nav-link custom-link {{ request()->routeIs('welcome') ? 'active' : '' }}">
                            Overview
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#about" class="nav-link custom-link">
                            About
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#features" class="nav-link custom-link">
                            Features
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#services" class="nav-link custom-link">
                            Services
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="#faq" class="nav-link custom-link">
                            FAQ
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#blog" class="nav-link custom-link">
                            Blog
                        </a>
                    </li>
                </ul>
            </div>

            {{-- LOGIN BUTTON --}}
            <div class="header-login-wrapper">

                <a href="{{ route('login') }}" class="header-login">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login
                </a>
            </div>
        </div>
    </nav>
</header>
