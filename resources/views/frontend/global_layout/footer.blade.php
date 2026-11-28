<footer class="frontend-footer">
    <div class="footer-container">
        <div class="footer-main">
            {{-- BRAND --}}
            <div class="footer-brand">
                <a href="{{ route('welcome') }}" class="footer-brand-link">
                    <img src="{{ asset('uploads/images/welcome_page/logo.JPG') }}" alt="ProsharPOS Logo"
                        class="footer-brand-image" width="200" height="50">
                </a>
                <p class="footer-description">
                    ProsharPOS helps businesses run smarter and faster.
                    Easily manage sales, inventory, customers, and insights
                    from one simple platform.
                </p>

            </div>

            {{-- QUICK LINKS --}}
            <div class="footer-column">

                <h6 class="footer-heading">
                    Quick Links
                </h6>

                <ul class="footer-links">

                    <li>
                        <a href="{{ route('welcome') }}">
                            <i class="fas fa-chevron-right"></i>
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="#features">
                            <i class="fas fa-chevron-right"></i>
                            Features
                        </a>
                    </li>

                    <li>
                        <a href="#services">
                            <i class="fas fa-chevron-right"></i>
                            Services
                        </a>
                    </li>

                    <li>
                        <a href="#client-feedback">
                            <i class="fas fa-chevron-right"></i>
                            Feedback
                        </a>
                    </li>

                    <li>
                        <a href="#faq">
                            <i class="fas fa-chevron-right"></i>
                            FAQ
                        </a>
                    </li>

                    <li>
                        <a href="#about">
                            <i class="fas fa-chevron-right"></i>
                            About
                        </a>
                    </li>
                </ul>
            </div>

            {{-- SUPPORT --}}
            <div class="footer-column">

                <h6 class="footer-heading">
                    Support
                </h6>

                <ul class="footer-links">

                    <li>
                        <a href="{{ route('help') }}">
                            <i class="fas fa-chevron-right"></i>
                            Help Articles
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            Live Chat
                        </a>
                    </li>
                </ul>
            </div>

            {{-- NEWSLETTER --}}
            <div class="footer-column">
                <h6 class="footer-heading">Stay Updated </h6>
                <p class="newsletter-description">Subscribe to receive updates, tips, and exclusive offers.</p>

                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form">
                    @csrf
                    <input type="email" name="email" class="form-control newsletter-input"
                        placeholder="Enter your email" autocomplete="email" required>

                    <button type="submit" class="newsletter-button">
                        Subscribe
                        <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </form>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="footer-bottom">
            <p>
                &copy; {{ date('Y') }}
                <span class="onstage-text brand-hover">
                    ProsharPOS
                </span>.
                All rights reserved.
            </p>

            {{-- DEVELOPER CREDIT --}}
            <div>
                Designed &amp; Developed by

                <a href="https://labib.work" target="_blank" rel="noopener noreferrer" class="brand-hover">
                    <span class="onstage-text">
                        Labib Arefin
                    </span>
                </a>
            </div>
        </div>
    </div>
</footer>
