document.addEventListener('DOMContentLoaded', () => {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.hp-menu-group .nav-link');

    navLinks.forEach((link) => {
        const href = link.getAttribute('href');
        if (href && href !== '#' && href === currentPath) {
            link.classList.add('active');
        }
    });
});

$(document).ready(function () {
    const $heroSlider = $('.hero-slider');

    if (!$heroSlider.length) {
        return;
    }

    $heroSlider.slick({
        dots: false,
        arrows: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3500,
        speed: 700,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="hero-arrow hero-prev" aria-label="Previous slide">&larr;</button>',
        nextArrow: '<button type="button" class="hero-arrow hero-next" aria-label="Next slide">&rarr;</button>',
        appendArrows: $heroSlider
    });
});