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
    }

    .off-highlight {
        color: #B2BEB5 !important;
    }

    .footer-links a {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.3s;
    }

    .footer-links a:hover {
        color: #0d6efd;
    }

    .newsletter-input {
        max-width: 250px;
        display: inline-block;
    }

    .newsletter-btn {
        margin-left: 5px;
    }

    footer {
        background-color: #f8f9fa;
    }
</style>

<footer class="pt-2">
    <div class="container">
        <div class="row text-start">

            <!-- Logo + Description -->
            <div class="col-md-4 mb-4">
                <h3 class="fw-bold onstage-text">ProsharPOS</h3>
                <p class="text-muted">
                    ProsharPOS is the ultimate point-of-sale software designed to make your business simpler, faster,
                    and smarter. Manage sales, inventory, customers, and analytics effortlessly.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-2 mb-4">
                <h5 class="fw-semibold">Quick Links</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <!-- Support Links -->
            <div class="col-md-2 mb-4">
                <h5 class="fw-semibold">Support</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">FAQ’s</a></li>
                    <li><a href="#">Articles</a></li>
                    <li><a href="#">Live Chat</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-semibold">Subscribe Newsletter</h5>
                <p class="text-muted">Get the latest updates and offers from ProsharPOS.</p>
                <form class="d-flex flex-wrap align-items-center">
                    <input type="email" class="form-control newsletter-input mb-2" placeholder="Your email address"
                        required>
                    <button type="submit" class="btn btn-primary newsletter-btn mb-2">Send</button>
                </form>
            </div>
        </div>

        <hr>

        <!-- Bottom -->
        <div class="text-center text-muted small py-3">
            &copy; {{ date('Y') }}
            <a href="#" target="_blank" class="text-decoration-none text-primary fw-semibold">
                ProsharPOS
            </a> All rights reserved |
            Designed & Developed by
            <a href="https://labib.work" target="_blank" class="text-decoration-none fw-semibold">
                <span class="onstage-text">Labib Arefin</span>
            </a>
        </div>
    </div>
</footer>
