export function initializeBackToTop() {
    document.addEventListener('DOMContentLoaded', function () {
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', function () {
            if (window.scrollY > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
            } else {
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });

        backToTopButton.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
}