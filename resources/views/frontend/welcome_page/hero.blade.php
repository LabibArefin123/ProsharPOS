@section('content')
    <section class="proshar-hero">
        <div class="container">
            <div class="row align-items-center">

                <!-- Left Content -->
                <div class="col-lg-6 col-md-12">
                    <span class="hero-badge">Bangladesh POS Software</span>

                    <h1 class="hero-title">
                        Easy-to-use<br>
                        Point of Sale
                    </h1>

                    <p class="hero-text">
                        ProsharPOS helps businesses in Bangladesh manage sales,
                        inventory, customers, and reports easily.
                        Fast, secure, and works on all devices.
                    </p>

                    <a href="{{ route('login') }}" class="btn hero-btn">
                        Get Started
                    </a>
                </div>

                <!-- Right Illustration -->
                <div class="col-lg-6 col-md-12 text-center">
                    <img src="{{ asset('images/pos-hero.png') }}" alt="ProsharPOS Illustration" class="hero-image">
                </div>

            </div>
        </div>
    </section>
