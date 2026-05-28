@php
    $commitments = [
        [
            'icon' => 'fa-regular fa-gem',
            'title' => 'Authenticity',
            'text' => 'Every diamond is 100% natural and comes with an authentic certificate.',
        ],
        [
            'icon' => 'fa-regular fa-magnifying-glass',
            'title' => 'Transparency',
            'text' => 'We believe in complete transparency in pricing, quality, and origin.',
        ],
        [
            'icon' => 'fa-solid fa-hands-holding',
            'title' => 'Ethical Sourcing',
            'text' => 'Our diamonds are ethically sourced, ensuring respect for people and the planet.',
        ],
        [
            'icon' => 'fa-regular fa-circle-check',
            'title' => 'Quality Assurance',
            'text' => 'Rigorous quality checks ensure only the finest diamonds reach you.',
        ],
    ];
@endphp

<section class="about-commitment py-5">
    <div class="container">
        <div class="about-commitment-header text-center">
            <span class="about-who-label">Our Commitment</span>
            <h2 class="about-who-title font-pilo">Excellence in Every Facet</h2>
            <div class="about-who-divider mx-auto" aria-hidden="true">
                <span class="about-who-divider-line"></span>
                <span class="about-who-divider-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L20 12L12 22L4 12L12 2Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </span>
                <span class="about-who-divider-line"></span>
            </div>
        </div>

        <div class="row g-4 g-lg-4">
            @foreach ($commitments as $item)
                <div class="col-sm-6 col-lg-3">
                    <article class="about-commitment-card h-100">
                        <div class="about-commitment-card-icon" aria-hidden="true">
                            <i class="{{ $item['icon'] }}"></i>
                        </div>
                        <h3 class="about-commitment-card-title font-pilo">{{ $item['title'] }}</h3>
                        <p class="about-commitment-card-text">{{ $item['text'] }}</p>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
