<!-- Top Info Bar -->
<div class="top-info-bar py-1 text-white">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- Left: Contact Info (Hidden on small screens) -->
        <div class="contact-info d-none d-md-flex align-items-center gap-3">

            <a href="mailto:mdlabibarefin@gmail.com"
                class="contact-item d-flex align-items-center text-white text-decoration-none" aria-label="Email us">
                <i class="fas fa-envelope me-2"></i>
                mdlabibarefin@gmail.com
            </a>

            <span class="text-white-50">|</span>

            <a href="tel:+8801776197999" class="contact-item d-flex align-items-center text-white text-decoration-none"
                aria-label="Call us">
                <i class="fas fa-phone me-2"></i>
                +8801776197999
            </a>

            <a href="https://wa.me/8801776197999" target="_blank"
                class="contact-item d-flex align-items-center text-white text-decoration-none"
                aria-label="WhatsApp chat">
                <i class="fab fa-whatsapp me-2"></i>
                WhatsApp
            </a>

        </div>

        <!-- Right: Date & Time -->
        <div class="fw-semibold">
            <i class="far fa-clock me-1"></i>
            <span id="currentDateTime">
                {{ \Carbon\Carbon::now()->format('l, d F Y, h:i:s A') }}
            </span>
        </div>

    </div>
</div>

<!-- Main Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white px-4">
    <div class="container-fluid">

        <!-- Logo -->
        <a href="{{ route('welcome') }}" class="navbar-brand d-flex align-items-center">
            <img src="{{ asset('uploads/images/welcome_page/logo.JPG') }}" alt="Company Logo"
                class="brand-image elevation-3" style="max-height: 75px; width: auto;">
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Center Menu -->
        <div class="collapse navbar-collapse justify-content-center" id="navbarCollapse">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a href="{{ route('welcome') }}"
                        class="nav-link custom-link {{ request()->routeIs('welcome') ? 'active' : '' }}">
                        Home
                    </a>
                </li>

                <li class="nav-item"><a href="#about" class="nav-link custom-link">About</a></li>
                <li class="nav-item"><a href="#features" class="nav-link custom-link">Features</a></li>
                <li class="nav-item"><a href="#services" class="nav-link custom-link">Services</a></li>
                <li class="nav-item"><a href="#client-feedback" class="nav-link custom-link">Feedback</a></li>
                <li class="nav-item"><a href="#faq" class="nav-link custom-link">FAQ</a></li>
                <li class="nav-item"><a href="#blog" class="nav-link custom-link">Blog</a></li>

            </ul>
        </div>

        <!-- Right: Login -->
        <div class="d-flex align-items-center">
            <a href="{{ route('login') }}" class="btn btn-outline-primary px-4">
                Login
            </a>
        </div>

    </div>
</nav>
