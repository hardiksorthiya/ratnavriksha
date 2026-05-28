@php
    $founders = [
        [
            'name' => 'Amit Shah',
            'role' => 'Co-Founder & CEO',
            'bio' => 'With decades in the diamond trade, Amit leads our vision for ethical sourcing and lasting client relationships.',
            'initials' => 'AS',
            'image' => 'images/about/founders/founder-1.jpg',
        ],
        [
            'name' => 'Priya Mehta',
            'role' => 'Co-Founder & Creative Director',
            'bio' => 'Priya shapes how every stone is presented — ensuring brilliance, storytelling, and design excellence at every touchpoint.',
            'initials' => 'PM',
            'image' => 'images/about/founders/founder-2.jpg',
        ],
        [
            'name' => 'Vikram Patel',
            'role' => 'Co-Founder & Operations',
            'bio' => 'Vikram oversees quality, certification, and delivery — so every diamond reaches you with confidence and care.',
            'initials' => 'VP',
            'image' => 'images/about/founders/founder-3.jpg',
        ],
    ];
@endphp

<section class="about-founder py-5">
    <div class="container">
        <div class="about-founder-header text-center">
            <span class="about-who-label">Our Leadership</span>
            <h2 class="about-who-title font-pilo">Meet Our Founders</h2>
            <div class="about-who-divider mx-auto" aria-hidden="true">
                <span class="about-who-divider-line"></span>
                <span class="about-who-divider-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L20 12L12 22L4 12L12 2Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </span>
                <span class="about-who-divider-line"></span>
            </div>
            <p class="about-founder-intro">The people behind Ratnavriksha — united by a passion for natural diamonds and unwavering integrity.</p>
        </div>

        <div class="row g-4 g-lg-5 justify-content-center">
            @foreach ($founders as $founder)
                @php
                    $hasImage = ! empty($founder['image']) && file_exists(public_path($founder['image']));
                @endphp
                <div class="col-md-6 col-lg-4">
                    <article class="about-founder-card h-100">
                        <div class="about-founder-photo-wrap">
                            @if ($hasImage)
                                <img
                                    src="{{ asset($founder['image']) }}"
                                    alt="{{ $founder['name'] }}"
                                    class="about-founder-photo"
                                    loading="lazy"
                                >
                            @else
                                <div class="about-founder-photo about-founder-photo--placeholder" aria-hidden="true">
                                    <span>{{ $founder['initials'] }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="about-founder-body">
                            <h3 class="about-founder-name font-pilo">{{ $founder['name'] }}</h3>
                            <p class="about-founder-role">{{ $founder['role'] }}</p>
                            <div class="about-founder-line" aria-hidden="true"></div>
                            <p class="about-founder-bio">{{ $founder['bio'] }}</p>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>
