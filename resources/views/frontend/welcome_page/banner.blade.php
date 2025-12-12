<section id="banner" class="py-5">
    <div class="container">
        <div id="slider" class="position-relative rounded-4 overflow-hidden" style="height: 70vh;">
            <!-- Slides -->
            @php
                $slides = [
                    [
                        'image' => 'slider_1.png',
                        'title' => 'Welcome to Your Friendly POS',
                        'subtitle' => 'Simple • Fast • Reliable Checkout Experience',
                    ],
                    [
                        'image' => 'slider_2.png',
                        'title' => 'Easy Inventory Management',
                        'subtitle' => 'Keep your stock under control in real time',
                    ],
                    [
                        'image' => 'slider_3.png',
                        'title' => 'Grow Your Business',
                        'subtitle' => 'Insights, Reports & Multi-Branch Made Simple',
                    ],
                ];
            @endphp

            @foreach ($slides as $index => $slide)
                <div class="slide {{ $index === 0 ? 'active' : '' }} position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-center"
                    style="background-image: url('{{ asset('uploads/images/welcome_page/slider/' . $slide['image']) }}'); background-size: cover; background-position: center;">
                    <div class="position-absolute top-0 start-0 w-100 h-100"></div>
                    <div class="position-relative z-2">
                        <div class="title-box px-4 py-3 rounded-4 shadow">
                            <h2 class="display-5 fw-bold animate__animated animate__fadeInDown mb-2">
                                {{ $slide['title'] }}
                            </h2>
                            <p class="lead animate__animated animate__fadeInUp mb-0">
                                {{ $slide['subtitle'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Navigation Arrows -->
            <button onclick="prevSlide()" class="arrow-btn start">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button onclick="nextSlide()" class="arrow-btn end">
                <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Dots -->
            <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 z-3 d-flex gap-2">
                @foreach ($slides as $i => $slide)
                    <span class="dot" onclick="goToSlide({{ $i }})"></span>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
    #slider {
        position: relative;
    }

    .slide {
        opacity: 0;
        transition: opacity 1s ease-in-out;
        z-index: 1;
    }

    .slide.active {
        opacity: 1;
        z-index: 2;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom right, rgba(0, 0, 0, 0.6), rgba(10, 10, 10, 0.3));
        z-index: 1;
    }

    .title-box {
        background-color: rgba(20, 20, 20, 0.75);
        color: #fff;
        max-width: 800px;
        margin: 0 auto;
        backdrop-filter: blur(4px);
        border: 2px solid rgba(255, 255, 255, 0.25);
    }

    .arrow-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        padding: 0.6rem 0.9rem;
        border-radius: 50%;
        border: none;
        background-color: rgba(0, 0, 0, 0.6);
        color: #fff;
        font-size: 1.25rem;
        cursor: pointer;
        z-index: 5;
        transition: background 0.3s;
    }

    .arrow-btn:hover {
        background-color: rgba(0, 0, 0, 0.85);
    }

    .arrow-btn.start {
        left: 15px;
    }

    .arrow-btn.end {
        right: 15px;
    }

    .dot {
        width: 14px;
        height: 14px;
        background-color: rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .dot.active {
        background-color: white;
        width: 16px;
        height: 16px;
    }

    @media (max-width: 768px) {
        #slider {
            height: 50vh;
        }

        .display-5 {
            font-size: 1.5rem;
        }

        .lead {
            font-size: 1rem;
        }

        .title-box {
            padding: 1rem;
            max-width: 90%;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll("#slider .slide");
        const dots = document.querySelectorAll("#slider .dot");

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle("active", i === index);
            });

            dots.forEach((dot, i) => {
                dot.classList.toggle("active", i === index);
            });

            currentSlideIndex = index;
        }

        function nextSlide() {
            const nextIndex = (currentSlideIndex + 1) % slides.length;
            showSlide(nextIndex);
        }

        function prevSlide() {
            const prevIndex = (currentSlideIndex - 1 + slides.length) % slides.length;
            showSlide(prevIndex);
        }

        window.nextSlide = nextSlide;
        window.prevSlide = prevSlide;
        window.goToSlide = showSlide;

        setInterval(nextSlide, 8000);
        showSlide(currentSlideIndex);
    });
</script>
