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
    if ($('.hero-slider').length) {
        $('.hero-slider').slick({
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
            appendArrows: $('.hero-slider')
        });
    }

    const $categorySlider = $('.category-slider');

    if ($categorySlider.length) {
        function setCategorySizes() {
            const $slides = $categorySlider.find('.slick-slide');

            $slides.removeClass('is-center is-near is-far');

            const $center = $slides.filter('.slick-center');
            if (!$center.length) {
                return;
            }

            $center.addClass('is-center');
            $center.prev('.slick-slide').add($center.next('.slick-slide')).addClass('is-near');
            $slides.filter('.slick-active').not('.is-center, .is-near').addClass('is-far');
        }

        $categorySlider.on('init reInit afterChange setPosition', setCategorySizes);

        $categorySlider.slick({
            dots: false,
            arrows: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            speed: 600,
            adaptiveHeight: false,
            centerMode: true,
            centerPadding: '0px',
            slidesToShow: 5,
            slidesToScroll: 1,
            initialSlide: 2,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        autoplay: true,
                        centerMode: true,
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        autoplay: true,
                        centerMode: true,
                        slidesToShow: 1,
                        centerPadding: '30px',
                        slidesToScroll: 1
                    }
                }
            ]
        });

        setCategorySizes();

        $('.category-prev').on('click', function () {
            $categorySlider.slick('slickPrev');
        });

        $('.category-next').on('click', function () {
            $categorySlider.slick('slickNext');
        });
    }
});