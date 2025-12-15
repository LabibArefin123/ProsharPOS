<!-- Top Info Bar -->
<div class="py-1" style="background-color: #003366; color: #fff; font-size: 14px;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Left: Email + Phone -->
        <div class="contact-info d-flex align-items-center p-2 rounded">
            <a href="mailto:mdlabibarefin@gmail.com"
                class="contact-item text-decoration-none text-dark d-flex align-items-center me-3 text-white">
                <i class="fas fa-envelope me-2 text-white"></i> mdlabibarefin@gmail.com
            </a>
            <span class="mx-2">|</span>
            <a href="tel:+8801776197999"
                class="contact-item text-decoration-none text-dark d-flex align-items-center me-3 text-white">
                <i class="fas fa-phone me-2 text-white"></i> +8801776197999
            </a>
            <a href="https://wa.me/8801776197999" target="_blank"
                class="contact-item text-decoration-none text-dark d-flex align-items-center text-white">
                <i class="fab fa-whatsapp me-2 text-white"></i> WhatsApp
            </a>
        </div>

        <style>
            .contact-item {
                transition: background-color 0.3s, color 0.3s;
                padding: 2px 6px;
                border-radius: 4px;
            }

            .contact-item:hover {
                background-color: #d9f0ff;
                /* light blue hover */
                color: #007bff;
                /* optional: text turns blue on hover */
                text-decoration: none;
            }
        </style>


        <!-- Right: Date & Time -->
        <div id="currentDateTime">
            {{ now()->format('d M Y, h:i:s A') }}
        </div>

    </div>
</div>

<!-- Main Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white"
    style="padding-left: 30px; padding-right: 30px;">
    <div class="container-fluid">

        <!-- Left: Logo -->
        <a href="{{ route('welcome') }}" class="navbar-brand d-flex align-items-center">
            <img src="{{ asset('uploads/images/welcome_page/logo.JPG') }}" alt="Logo"
                class="brand-image img-circle elevation-3" style="width:250px; height:75px;">
        </a>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Center Menu -->
        <div class="collapse navbar-collapse justify-content-center order-2" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item"><a href="#about" class="nav-link custom-link">About</a></li>
                <li class="nav-item"><a href="#features" class="nav-link custom-link">Features</a></li>
                <li class="nav-item"><a href="#services" class="nav-link custom-link">Services</a></li>
                <li class="nav-item"><a href="#client-feedback" class="nav-link custom-link">Feedback</a></li>
                <li class="nav-item"><a href="#blog" class="nav-link custom-link">Blog</a></li>
                <li class="nav-item"><a href="#contact" class="nav-link custom-link">Contact</a></li>
            </ul>
        </div>

        <!-- Right: Login Button -->
        <div class="order-3 ml-auto d-flex align-items-center">
            <a href="{{ route('login') }}" class="btn btn-outline-primary" style="margin-right: 10px;">Login</a>
        </div>

    </div>
</nav>
