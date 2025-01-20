export function initializeImageSlider() {
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Swiper with improved options
        const swiper = new Swiper(".mySwiper", {
            loop: true,
            effect: "fade",
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            spaceBetween: 0,
            speed: 800,
        });
    });
}