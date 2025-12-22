    <section class="proshar-hero">
        <style>
            .proshar-hero {
                padding: 100px 0;
                background: linear-gradient(120deg, #f6fff9, #f2edff);
            }

            .hero-badge {
                color: #3ad29f;
                font-weight: 600;
                font-size: 14px;
                display: inline-block;
                margin-bottom: 15px;
            }

            .hero-title {
                font-size: 52px;
                font-weight: 800;
                color: #1f2933;
                line-height: 1.2;
                margin-bottom: 20px;
            }

            .hero-text {
                font-size: 17px;
                color: #6b7280;
                max-width: 500px;
                margin-bottom: 30px;
            }

            .hero-btn {
                background-color: #6c7cff;
                color: #fff;
                padding: 14px 28px;
                border-radius: 8px;
                font-weight: 600;
                text-decoration: none;
            }

            .hero-btn:hover {
                background-color: #5a6af0;
                color: #fff;
            }

            .hero-image {
                max-width: 100%;
                height: auto;
            }
        </style>
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
                    <img src="{{ asset('uploads/images/welcome_page/hero/hero.png') }}" alt="ProsharPOS Illustration" class="hero-image">
                </div>

            </div>
        </div>

    </section>
