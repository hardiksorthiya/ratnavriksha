@php
    $services = [
        [
            'title' => 'Certified<br>Excellence',
            'icon' => 'certified',
        ],
        [
            'title' => 'Ethical &<br>Responsible',
            'icon' => 'ethical',
        ],
        [
            'title' => 'Superior<br>Craftsmanship',
            'icon' => 'craftsmanship',
        ],
        [
            'title' => 'Global<br>Network',
            'icon' => 'network',
        ],
        [
            'title' => 'Trusted<br>Legacy',
            'icon' => 'legacy',
        ],
    ];
@endphp

<section class="service-section py-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="service-content text-center d-flex flex-column align-items-center">
                    <h2 class="service-title font-pilo">Our Best Service For You</h2>
                    <p class="services-subtitle">
                        From certified stones to ethical sourcing and global reach, we deliver the standards
                        jewelers and buyers trust at every step of the journey.
                    </p>
                </div>
            </div>
        </div>

        <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-5 g-4 g-md-5 g-xl-5 mt-5 justify-content-center service-item">
            @foreach ($services as $service)
                <div class="col d-flex justify-content-center">
                    <div class="service-card position-relative">
                        <div class="pentagonal-shape"></div>
                        <div class="service-card-content position-relative d-flex flex-column align-items-center justify-content-center">
                            <h6 class="service-card-title text-center">{!! $service['title'] !!}</h6>

                            <div class="service-card-icon" aria-hidden="true">
                                @include('frontend.component.home.partials.service-icon-' . $service['icon'])
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
