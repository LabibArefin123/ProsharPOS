document.addEventListener("DOMContentLoaded", function () {
    const faqItems = document.querySelectorAll(".custom-faq-item");
    const reducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)",
    ).matches;

    if (!faqItems.length) return;

    function closeFaq(item) {
        const button = item.querySelector(".custom-faq-question");
        const answer = item.querySelector(".custom-faq-answer");
        const icon = button.querySelector(".custom-faq-toggle i");

        if (!button || !answer) return;

        item.classList.remove("active");
        button.setAttribute("aria-expanded", "false");

        if (icon) {
            icon.classList.replace("fa-minus", "fa-plus");
        }

        if (reducedMotion) {
            answer.hidden = true;
            answer.style.maxHeight = "";
            return;
        }

        answer.style.maxHeight = answer.scrollHeight + "px";

        requestAnimationFrame(() => {
            answer.style.maxHeight = "0px";
        });

        answer.addEventListener("transitionend", function handler(event) {
            if (event.propertyName !== "max-height") return;

            answer.removeEventListener("transitionend", handler);

            if (!item.classList.contains("active")) {
                answer.hidden = true;
                answer.style.maxHeight = "";
            }
        });
    }

    function openFaq(item) {
        const button = item.querySelector(".custom-faq-question");
        const answer = item.querySelector(".custom-faq-answer");
        const icon = button.querySelector(".custom-faq-toggle i");

        if (!button || !answer) return;

        item.classList.add("active");
        button.setAttribute("aria-expanded", "true");

        if (icon) {
            icon.classList.replace("fa-plus", "fa-minus");
        }

        answer.hidden = false;

        if (reducedMotion) {
            answer.style.maxHeight = "";
            return;
        }

        answer.style.maxHeight = "0px";

        requestAnimationFrame(() => {
            answer.style.maxHeight = answer.scrollHeight + "px";
        });

        answer.addEventListener("transitionend", function handler(event) {
            if (event.propertyName !== "max-height") return;

            answer.removeEventListener("transitionend", handler);

            if (item.classList.contains("active")) {
                answer.style.maxHeight = "none";
            }
        });
    }

    faqItems.forEach((item) => {
        const button = item.querySelector(".custom-faq-question");
        const answer = item.querySelector(".custom-faq-answer");

        if (!button || !answer) return;

        answer.hidden = true;
        answer.style.maxHeight = "0px";

        button.addEventListener("click", function () {
            const isActive = item.classList.contains("active");

            faqItems.forEach((otherItem) => {
                if (
                    otherItem !== item &&
                    otherItem.classList.contains("active")
                ) {
                    closeFaq(otherItem);
                }
            });

            if (isActive) {
                closeFaq(item);
            } else {
                openFaq(item);
            }
        });
    });

    window.addEventListener("resize", function () {
        const activeAnswer = document.querySelector(
            ".custom-faq-item.active .custom-faq-answer",
        );

        if (
            activeAnswer &&
            activeAnswer.style.maxHeight !== "none" &&
            !reducedMotion
        ) {
            activeAnswer.style.maxHeight = activeAnswer.scrollHeight + "px";
        }
    });
});
