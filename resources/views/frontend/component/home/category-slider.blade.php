@php
    $shapes = [
        ['name' => 'Oval', 'img' => 'oval.png'],
        ['name' => 'Cushion', 'img' => 'cushion.png'],
        ['name' => 'Round', 'img' => 'round.png'],
        ['name' => 'Princess', 'img' => 'princess.png'],
        ['name' => 'Pear', 'img' => 'pear.png'],
    ];
    $sliderShapes = array_merge($shapes, $shapes);
@endphp

<section class="category-sorath py-5">
    <div class="container">
        <div class="category-head row align-items-end g-4 mb-4">
            <div class="col-lg-8">
                <h2 class="category-title">
                    <span>Certified Diamonds</span>
                    <span class="category-title-right">In Diverse Shapes</span>
                </h2>
                <p class="category-desc">Explore the possibilities of tailored craftsmanship and unlimited capabilities.</p>
            </div>
            <div class="col-lg-4">
                <div class="category-nav d-flex justify-content-lg-end align-items-center gap-3">
                    <button type="button" class="category-arrow category-prev" aria-label="Previous shape">&larr;</button>
                    <button type="button" class="category-arrow category-next" aria-label="Next shape">
                        Next Shape <span>&rarr;</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="category-slider-wrap position-relative">
            <span class="category-track" aria-hidden="true"></span>
            <div class="category-slider">
                @foreach ($sliderShapes as $shape)
                    <div>
                        <div class="category-item">
                            <div class="category-item-visual">
                                <div class="category-item-circle">
                                    <img src="{{ asset('images/home/shapes/' . $shape['img']) }}"
                                        alt="{{ $shape['name'] }}" class="category-item-img">
                                </div>
                            </div>
                            <p class="category-item-label">{{ $shape['name'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
