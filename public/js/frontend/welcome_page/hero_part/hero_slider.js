/* =========================================
   PROSHARPOS HERO SLIDER
========================================= */
document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector("[data-hero-slider]");

    if (!slider) return;

    const slides = Array.from(slider.querySelectorAll("[data-hero-slide]"));
    const dots = Array.from(document.querySelectorAll("[data-hero-dot]"));
    const previousButton = document.querySelector("[data-hero-prev]");
    const nextButton = document.querySelector("[data-hero-next]");
    const currentNumber = document.querySelector("[data-hero-current]");

    if (slides.length < 2) return;

    let currentIndex = slides.findIndex((slide) =>
        slide.classList.contains("is-active"),
    );
    let isAnimating = false;
    const animationDuration = 800;

    if (currentIndex < 0) currentIndex = 0;

    function updateNavigation() {
        dots.forEach((dot, index) => {
            const active = index === currentIndex;

            dot.classList.toggle("is-active", active);

            if (active) {
                dot.setAttribute("aria-current", "true");
            } else {
                dot.removeAttribute("aria-current");
            }
        });

        if (currentNumber) {
            currentNumber.textContent = String(currentIndex + 1).padStart(
                2,
                "0",
            );
        }
    }

    function goToSlide(nextIndex) {
        if (isAnimating || nextIndex === currentIndex) return;

        const previousSlide = slides[currentIndex];
        const nextSlide = slides[nextIndex];

        if (!nextSlide) return;

        isAnimating = true;

        previousSlide.classList.remove("is-active", "is-entering");
        previousSlide.classList.add("is-exiting");

        nextSlide.classList.add("is-active", "is-entering");

        currentIndex = nextIndex;
        updateNavigation();

        window.setTimeout(function () {
            previousSlide.classList.remove("is-exiting");
            nextSlide.classList.remove("is-entering");

            isAnimating = false;
        }, animationDuration);
    }

    function nextSlide() {
        const nextIndex = (currentIndex + 1) % slides.length;
        goToSlide(nextIndex);
    }

    function previousSlide() {
        const previousIndex =
            (currentIndex - 1 + slides.length) % slides.length;
        goToSlide(previousIndex);
    }

    nextButton?.addEventListener("click", nextSlide);
    previousButton?.addEventListener("click", previousSlide);

    dots.forEach((dot, index) => {
        dot.addEventListener("click", function () {
            goToSlide(index);
        });
    });

    // Public methods used by autoplay.
    slider.prosharNext = nextSlide;
    slider.prosharPrevious = previousSlide;

    updateNavigation();
});
