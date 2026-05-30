@php
    $processSteps = [
        [
            'icon' => 'fa-leaf',
            'title' => 'Ethical Sourcing',
            'text' => 'We partner with trusted suppliers and responsible mining networks to source premium-quality diamonds that meet the highest ethical and industry standards.',
        ],
        [
            'icon' => 'fa-gem',
            'title' => 'Expert Selection',
            'text' => 'Every diamond is carefully evaluated by experienced professionals who assess its cut potential, clarity, color, and overall quality before selection.',
        ],
        [
            'icon' => 'fa-wand-magic-sparkles',
            'title' => 'Precision Craftsmanship',
            'text' => 'Our skilled craftsmen and diamond specialists transform carefully chosen stones into brilliant masterpieces through precision cutting and polishing techniques.',
        ],
        [
            'icon' => 'fa-clipboard-check',
            'title' => 'Quality Inspection',
            'text' => 'Each diamond undergoes rigorous quality control and certification checks to ensure it meets our strict standards for brilliance, authenticity, and excellence.',
        ],
        [
            'icon' => 'fa-truck-fast',
            'title' => 'Global Delivery',
            'text' => 'Once approved, every diamond is securely packaged and delivered through trusted logistics partners, ensuring safe and timely delivery to clients worldwide.',
        ],
    ];
@endphp

<section class="about-process py-5">
    <div class="container">
        <div class="about-process-header text-center">
            <span class="about-who-label">Our Process</span>
            <h2 class="about-who-title font-pilo">From Mine to Masterpiece</h2>
            <div class="about-who-divider mx-auto" aria-hidden="true">
                <span class="about-who-divider-line"></span>
                <span class="about-who-divider-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L20 12L12 22L4 12L12 2Z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </span>
                <span class="about-who-divider-line"></span>
            </div>
            <p class="about-mission-intro">A meticulous journey of craftsmanship, precision, and trust behind every diamond we deliver.</p>
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
