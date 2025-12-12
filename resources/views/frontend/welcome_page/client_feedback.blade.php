<section id="client-feedback" class="py-5">
    <div class="container">

        <div class="text-center mb-4">
            <h2 class="fw-bold">Client Feedback</h2>
            <p class="text-muted">Trusted by business owners across Bangladesh</p>
        </div>

        <div class="position-relative">

            <!-- Left Fade -->
            <div class="position-absolute top-0 start-0 h-100"
                style="width:80px; background:linear-gradient(to right, #f8f9fa, transparent); z-index:5;"></div>

            <!-- Right Fade -->
            <div class="position-absolute top-0 end-0 h-100"
                style="width:80px; background:linear-gradient(to left, #f8f9fa, transparent); z-index:5;"></div>

            <!-- Left Arrow -->
            <button id="prevBtn" class="arrow-btn position-absolute top-50 start-0 translate-middle-y shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M5.854 4.146a.5.5 0 0 1 0 .708L2.707 8l3.147 3.146a.5.5 0 0 1-.708.708l-3.5-3.5a.5.5 0 0 1 0-.708l3.5-3.5a.5.5 0 0 1 .708 0z" />
                    <path fill-rule="evenodd"
                        d="M13 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H12.5A.5.5 0 0 1 13 8z" />
                </svg>
            </button>

            <!-- Right Arrow -->
            <button id="nextBtn" class="arrow-btn position-absolute top-50 end-0 translate-middle-y shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M10.146 4.146a.5.5 0 0 1 .708 0l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L13.293 8 10.146 4.854a.5.5 0 0 1 0-.708z" />
                    <path fill-rule="evenodd"
                        d="M3 8a.5.5 0 0 1 .5-.5h8.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L12.293 8.5H3.5A.5.5 0 0 1 3 8z" />
                </svg>
            </button>


            <!-- Scrollable Row -->
            <div id="reviewRail" class="d-flex overflow-auto py-3"
                style="scroll-behavior:smooth; gap:16px; scrollbar-width:none;">
            </div>
        </div>

        <!-- Pointers / Dots -->
        <div id="reviewDots" class="d-flex justify-content-center mt-3 gap-2"></div>
    </div>
</section>

<style>
    #reviewRail::-webkit-scrollbar {
        display: none;
    }

    .review-card {
        min-width: 280px;
        border-radius: 18px;
        background: #ffffff;
        transition: transform .3s ease, box-shadow .3s ease;
        flex-shrink: 0;
    }

    .review-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, .1);
    }

    .dot {
        width: 10px;
        height: 10px;
        background: #ddd;
        border-radius: 50%;
        cursor: pointer;
    }

    .dot.active {
        background: #0d6efd;
    }

    /* Arrow Buttons */
    .arrow-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: none;
        background: #fff;
        cursor: pointer;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s, transform 0.2s;
    }

    .arrow-btn:hover {
        background: #d0e7ff;
        transform: scale(1.1);
    }
</style>

<script>
    const reviewData = [{
            name: "Abdul Kader",
            text: "ProsharPOS changed the way I manage my shop.",
            stars: 4
        },
        {
            name: "Mahmud Hasan",
            text: "Stock tracking is now super easy!",
            stars: 4
        },
        {
            name: "Ayesha Siddika",
            text: "The reports are extremely useful.",
            stars: 4
        },
        {
            name: "Rafiul Islam",
            text: "Very stable and easy to use.",
            stars: 4
        },
        {
            name: "Nazia Rahman",
            text: "Customer support deserves 5 stars!",
            stars: 5
        },
        {
            name: "Sakib Khan",
            text: "Ideal POS for growing stores.",
            stars: 4
        },
        {
            name: "Farzana Akter",
            text: "The UI is clean and beginner friendly.",
            stars: 4
        },
        {
            name: "Tareq Mahmud",
            text: "Perfect for multi-branch control.",
            stars: 4
        },
        {
            name: "Rubel Hossain",
            text: "Daily sales checking became simple.",
            stars: 4
        },
        {
            name: "Mizanur Rahman",
            text: "Cloud backup gives peace of mind.",
            stars: 4
        },
        {
            name: "Shamima Begum",
            text: "A great experience overall.",
            stars: 4
        },
        {
            name: "Arifur Rahman",
            text: "Fast billing features.",
            stars: 4
        },
        {
            name: "Shahidul Islam",
            text: "Loyalty program is awesome.",
            stars: 4
        },
        {
            name: "Rehana Parvin",
            text: "Best value for small businesses.",
            stars: 4
        },
        {
            name: "Jaber Karim",
            text: "Smooth and quick interface.",
            stars: 4
        },
        {
            name: "Shaila Munni",
            text: "Very easy for staff training.",
            stars: 4
        },
        {
            name: "Mehedi Hasan",
            text: "5 stars for analytics!",
            stars: 5
        },
        {
            name: "Monir Uddin",
            text: "I like the inventory alerts.",
            stars: 4
        },
        {
            name: "Asma Binte Ali",
            text: "Perfect POS for retail.",
            stars: 4
        },
        {
            name: "Hasibul Alam",
            text: "Support team is outstanding!",
            stars: 4
        },
    ];

    const rail = document.getElementById("reviewRail");
    const dotsContainer = document.getElementById("reviewDots");

    // Create cards & dots
    reviewData.forEach((item, i) => {
        const stars = "★".repeat(item.stars) + "☆".repeat(5 - item.stars);
        rail.innerHTML += `
        <div class="review-card shadow-sm p-4 text-center mx-1">
            <img src="images/default.jpg" class="rounded-circle mb-3"
                 style="width:70px;height:70px;object-fit:cover;">
            <h6 class="fw-bold mb-1">${item.name}</h6>
            <div style="color:#f4b400;font-size:18px;">${stars}</div>
            <p class="text-muted mt-2" style="font-size:14px;">${item.text}</p>
        </div>
    `;
        dotsContainer.innerHTML += `<div class="dot" data-index="${i}"></div>`;
    });

    const dots = document.querySelectorAll('.dot');
    let currentIndex = 0;

    function updateDots() {
        dots.forEach(d => d.classList.remove('active'));
        dots[currentIndex].classList.add('active');
    }

    function scrollToIndex(i) {
        const cardWidth = 280 + 16;
        rail.scrollTo({
            left: i * cardWidth,
            behavior: 'smooth'
        });
        currentIndex = i;
        updateDots();
    }

    // Arrow events
    document.getElementById('prevBtn').addEventListener('click', () => {
        let i = currentIndex - 1;
        if (i < 0) i = reviewData.length - 1;
        scrollToIndex(i);
    });
    document.getElementById('nextBtn').addEventListener('click', () => {
        let i = (currentIndex + 1) % reviewData.length;
        scrollToIndex(i);
    });

    // Dot events
    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            scrollToIndex(parseInt(dot.dataset.index));
        });
    });

    // Auto-scroll
    setInterval(() => {
        let i = (currentIndex + 1) % reviewData.length;
        scrollToIndex(i);
    }, 6000);

    updateDots();
</script>
