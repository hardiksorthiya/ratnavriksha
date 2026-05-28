document.addEventListener('DOMContentLoaded', function () {
    var header = document.querySelector('.hp-header');
    var lastScrollY = window.scrollY;
    var scrollThreshold = 80;

    function updateStickyHeader() {
        if (!header) {
            return;
        }

        var currentScrollY = window.scrollY;

        if (currentScrollY <= scrollThreshold) {
            header.classList.remove('hp-header--hidden', 'hp-header--sticky');
            header.classList.add('hp-header--top');
        } else {
            header.classList.remove('hp-header--top');
            header.classList.add('hp-header--sticky');

            if (currentScrollY < lastScrollY) {
                header.classList.remove('hp-header--hidden');
            } else {
                header.classList.add('hp-header--hidden');
            }
        }

        lastScrollY = currentScrollY;
    }

    if (header) {
        header.classList.add('hp-header--top');
        updateStickyHeader();
        window.addEventListener('scroll', updateStickyHeader, { passive: true });
    }

    function normalizePath(href) {
        if (!href || href === '#') {
            return null;
        }

        try {
            var path = new URL(href, window.location.origin).pathname;
            if (path.length > 1 && path.endsWith('/')) {
                path = path.slice(0, -1);
            }
            return path;
        } catch (e) {
            return null;
        }
    }

    var currentPath = window.location.pathname;
    if (currentPath.length > 1 && currentPath.endsWith('/')) {
        currentPath = currentPath.slice(0, -1);
    }

    var navLinks = document.querySelectorAll('.hp-header .nav-link, .hp-header .hp-contact-btn');

    navLinks.forEach(function (link) {
        var linkPath = normalizePath(link.getAttribute('href'));

        if (linkPath && linkPath === currentPath) {
            link.classList.add('active');
        }

        link.addEventListener('click', function () {
            if (link.getAttribute('href') === '#') {
                return;
            }

            navLinks.forEach(function (item) {
                item.classList.remove('active');
            });
            link.classList.add('active');
        });
    });

    function runCounter(el) {
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;
        var suffix = el.getAttribute('data-suffix') || '';
        var duration = parseInt(el.getAttribute('data-duration'), 10) || 2000;
        var startTime = null;

        function step(timestamp) {
            if (!startTime) {
                startTime = timestamp;
            }

            var progress = Math.min((timestamp - startTime) / duration, 1);
            var value = Math.floor(progress * target);

            el.textContent = value + suffix;

            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                el.textContent = target + suffix;
            }
        }

        window.requestAnimationFrame(step);
    }

    var counters = document.querySelectorAll('.about-stats-counter');

    if (counters.length && 'IntersectionObserver' in window) {
        var counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting && !entry.target.dataset.counted) {
                    entry.target.dataset.counted = 'true';
                    runCounter(entry.target);
                }
            });
        }, { threshold: 0.35 });

        counters.forEach(function (counter) {
            counterObserver.observe(counter);
        });
    } else if (counters.length) {
        counters.forEach(function (counter) {
            runCounter(counter);
        });
    }
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

    var faqAccordion = document.getElementById('contactFaqAccordion');

    if (faqAccordion) {
        var faqItems = faqAccordion.querySelectorAll('.contact-faq-item');

        faqItems.forEach(function (item) {
            var trigger = item.querySelector('.contact-faq-trigger');

            if (!trigger) {
                return;
            }

            trigger.addEventListener('click', function () {
                var isOpen = item.classList.contains('is-open');

                faqItems.forEach(function (otherItem) {
                    otherItem.classList.remove('is-open');
                    var otherTrigger = otherItem.querySelector('.contact-faq-trigger');
                    if (otherTrigger) {
                        otherTrigger.setAttribute('aria-expanded', 'false');
                    }
                });

                if (!isOpen) {
                    item.classList.add('is-open');
                    trigger.setAttribute('aria-expanded', 'true');
                }
            });
        });
    }
});
