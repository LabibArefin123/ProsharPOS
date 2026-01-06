<!-- Footer -->
<style>
    @font-face {
        font-family: 'OnStage';
        src: url('fonts/OnStage_Regular.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    .onstage-text {
        font-family: 'OnStage', sans-serif;
        color: #ff9900;
        cursor: default;
    }

    .footer-links a {
        color: #ffffff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-links a:hover {
        color: #ff9900;
    }

    .brand-hover:hover {
        color: #ff9900 !important;
    }

    .newsletter-input {
        max-width: 250px;
        display: inline-block;
    }

    footer {
        background-color: #003366;
    }
</style>

<footer class="pt-4">
    <div class="container">
        <div class="row text-start">

            <!-- Brand -->
            <div class="col-md-4 mb-4">
                <h3 class="fw-bold onstage-text">ProsharPOS</h3>
                <p class="text-white small">
                    ProsharPOS helps businesses run smarter and faster.
                    Easily manage sales, inventory, customers, and insights
                    from one simple platform.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-2 mb-4">
                <h6 class="text-white fw-semibold">Quick Links</h6>
                <ul class="list-unstyled footer-links small">
                    <li><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#client-feedback">Feedback</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#blog">Blog</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="col-md-2 mb-4">
                <h6 class="text-white fw-semibold">Support</h6>
                <ul class="list-unstyled footer-links small">
                    <li><a href="#">Help Articles</a></li>
                    <li><a href="#">Live Chat</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-md-4 mb-4">
                <h6 class="text-white fw-semibold">Stay Updated</h6>
                <p class="text-white small">
                    Subscribe to receive updates, tips, and exclusive offers.
                </p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="d-flex flex-wrap gap-2">
                    @csrf
                    <input type="email" name="email" class="form-control newsletter-input"
                        placeholder="Enter your email" required>

                    <button type="submit" class="btn btn-primary">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <hr class="border-light">

        <!-- Bottom Bar -->
        <div
            class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center small text-white pb-3">

            <!-- Left -->
            <div>
                © 2026 <span class="onstage-text brand-hover">ProsharPOS</span>. All rights reserved.
            </div>

            <!-- Right -->
            <div class="mt-2 mt-md-0">
                Designed & Developed by
                <a href="https://labib.work" target="_blank" class="text-white text-decoration-none brand-hover">
                    <span class="onstage-text">Labib Arefin</span>
                </a>
            </div>

        </div>

    </div>
</footer>
