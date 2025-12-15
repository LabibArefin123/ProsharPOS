<section id="about" class="content py-5 bg-white">
    <div class="container" data-aos="fade-up">
        <h2 class="text-center mb-4 about-title">About Us</h2>
        <p class="text-center text-muted mb-5 about-subtitle">
            Simple. Smart. Seamless. Our POS software is designed to help your business run better every day.
        </p>

        <div class="row align-items-center g-4">
            <!-- Image -->
            <div class="col-lg-6">
                <img src="{{ asset('uploads/images/welcome_page/about/about.png') }}"
                    alt="POS Software - Easy Business Management" class="about-image img-fluid rounded">
            </div>

            <!-- Text Content -->
            <div class="col-lg-6">
                <div class="about-text">
                    <p>
                        Our <strong>ProsharPOS</strong> is built to make running your business simple
                        and stress-free. From quick checkout counters to smart inventory tracking, our platform keeps
                        everything organized so you can focus on serving your customers.
                    </p>
                    <p>
                        With features like <strong>real-time stock updates, sales insights, and customer
                            management</strong>,
                        our ProsharPOS adapts to your needs—whether you run a retail shop, a restaurant, or a multi-branch
                        business. It’s fast, reliable, and designed to grow with you.
                    </p>
                    <p>
                        Our mission is simple: to give you the tools to <strong>sell smarter, save time, and boost
                            profits</strong>. Friendly, intuitive, and secure—our software is your trusted partner
                        for
                        everyday success.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* About Us Section */
        #about {
            padding-top: 4rem;
            padding-bottom: 4rem;
        }

        #about .about-title {
            font-size: 2.8rem;
            font-weight: 700;
        }

        #about .about-subtitle {
            font-size: 1.2rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        #about .about-image {
            width: 100%;
            max-width: 500px;
            /* prevent being too wide */
            height: auto;
            display: block;
            margin: 0 auto;
        }

        #about .about-text p {
            font-size: 1rem;
            line-height: 1.8;
            text-align: justify;
            margin-bottom: 1rem;
        }

        /* On smaller screens, stack neatly */
        @media (max-width: 991.98px) {
            #about .about-text {
                text-align: center;
            }

            #about .about-text p {
                text-align: center;
            }
        }
    </style>
</section>
