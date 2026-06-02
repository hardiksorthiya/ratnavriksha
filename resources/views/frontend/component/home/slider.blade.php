@php
    $slides = $sliders ?? collect();
    $defaultSlideImage = asset('images/home/slide1.png');
    $defaultBgImage = asset('images/home/small.png');
    $bgOne = $slides->get(0)?->storageUrl($slides->get(0)?->desktop_image) ?? $defaultBgImage;
    $bgTwo = $slides->get(1)?->storageUrl($slides->get(1)?->desktop_image) ?? $defaultBgImage;
    $bgThree = $slides->get(2)?->storageUrl($slides->get(2)?->desktop_image) ?? $defaultBgImage;
@endphp

<section class="home-hero position-relative">
    <div class="container">
        <div class="hero-slider">
            @forelse ($slides as $slide)
                <div class="hero-slide">
                    <div class="row">
                        <div class="col-md-6">
                            @if (filled($slide->subtitle))
                                <p class="hero-subtitle">{{ $slide->subtitle }}</p>
                            @endif
                            @if (filled($slide->title))
                                <h1 class="hero-title">{{ $slide->title }}</h1>
                            @endif
                            @if (filled($slide->button_text) && filled($slide->button_link))
                                <a href="{{ $slide->button_link }}" class="btn btn-primary-sorath hero-slide-btn mt-3">
                                    {{ $slide->button_text }}
                                </a>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column align-items-end">
                                @if (filled($slide->description))
                                    <p class="hero-description">{{ $slide->description }}</p>
                                @endif
                                <div class="hero-slide-image-wrap">
                                    @php
                                        $mainSrc = $slide->storageUrl($slide->main_image) ?? $defaultSlideImage;
                                        $mobileSrc = $slide->storageUrl($slide->mobile_image);
                                    @endphp
                                    @if ($mobileSrc)
                                        <picture>
                                            <source media="(max-width: 767.98px)" srcset="{{ $mobileSrc }}">
                                            <img src="{{ $mainSrc }}" class="hero-slide-image"
                                                alt="{{ $slide->title ?: 'Hero slide' }}">
                                        </picture>
                                    @else
                                        <img src="{{ $mainSrc }}" class="hero-slide-image"
                                            alt="{{ $slide->title ?: 'Hero slide' }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="hero-slide">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="hero-title">IGI Certified Diamond Manufacturer</h1>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column align-items-end">
                                <p class="hero-description">
                                    A leading grower and manufacturer of CVD diamonds backed by advanced technology and
                                    sustainable production practice.
                                </p>
                                <div class="hero-slide-image-wrap">
                                    <img src="{{ $defaultSlideImage }}" class="hero-slide-image" alt="Diamond">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <img src="{{ $bgOne }}" alt="" class="hero-slider-bg-one" aria-hidden="true">
    <img src="{{ $bgTwo }}" alt="" class="hero-slider-bg-two" aria-hidden="true">
    <img src="{{ $bgThree }}" alt="" class="hero-slider-bg-three" aria-hidden="true">
</section>
