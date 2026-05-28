@php
    $processSteps = [
        [
            'icon' => 'fa-mountain',
            'title' => 'Sourcing',
            'text' => 'We ethically source rough diamonds from trusted partners worldwide.',
        ],
        [
            'icon' => 'fa-gem',
            'title' => 'Selection',
            'text' => 'Each rough diamond is carefully handpicked for its quality and potential.',
        ],
        [
            'icon' => 'fa-compact-disc',
            'title' => 'Crafting',
            'text' => 'Expert artisans cut and polish every diamond to bring out its brilliance.',
        ],
        [
            'icon' => 'fa-magnifying-glass',
            'title' => 'Inspection',
            'text' => 'Every diamond undergoes strict quality checks and certification.',
        ],
        [
            'icon' => 'fa-box',
            'title' => 'Delivery',
            'text' => 'We deliver your diamond safely and securely, ready to be treasured forever.',
        ],
    ];
@endphp

<section class="about-process py-5">
    <div class="container">
        <div class="about-process-header text-center">
            <span class="about-who-label">Our Process</span>
            <h2 class="about-who-title font-pilo">From Nature to You</h2>
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

        <div class="about-process-timeline">
            <div class="about-process-track" aria-hidden="true">
                <span class="about-process-track-line"></span>
                @for ($i = 0; $i < count($processSteps) - 1; $i++)
                    <span class="about-process-track-dot"></span>
                @endfor
            </div>

            <div class="about-process-steps">
                @foreach ($processSteps as $index => $step)
                    <div class="about-process-step">
                        <div class="about-process-icon">
                            <i class="fa-solid {{ $step['icon'] }}"></i>
                        </div>
                        <h3 class="about-process-step-title">{{ $index + 1 }}. {{ $step['title'] }}</h3>
                        <p class="about-process-step-text">{{ $step['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
