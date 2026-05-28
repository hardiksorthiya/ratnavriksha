@php
    $ctaImage = file_exists(public_path('images/about/cta-banner.jpg'))
        ? asset('images/about/cta-banner.jpg')
        : (file_exists(public_path('images/about/cta-banner.png'))
            ? asset('images/about/cta-banner.png')
            : asset('images/home/vis3.png'));
@endphp

<section class="about-cta py-5">
    <div class="container">
        <div class="about-cta-banner" style="--about-cta-bg: url('{{ $ctaImage }}');">
            <div class="about-cta-content">
                <span class="about-cta-label">A Promise That Lasts</span>
                <h2 class="about-cta-title font-pilo">More Than a Diamond.<br>A Bond Forever.</h2>
                <div class="about-cta-divider" aria-hidden="true"></div>
                <p class="about-cta-text">We are honored to be a part of your most precious moments and are committed to making them truly unforgettable.</p>
                <a href="{{ route('contact') }}" class="about-cta-btn">
                    Connect with Us
                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</section>
