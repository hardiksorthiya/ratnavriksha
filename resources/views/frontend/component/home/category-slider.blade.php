@php
    $shapes = ($homeShapes ?? collect())
        ->map(fn ($shape) => [
            'name' => $shape->name ?? 'Shape',
            'img' => $shape->image_src ?? asset('images/home/shapes/round.png'),
        ])
        ->values()
        ->all();

    if (empty($shapes)) {
        $shapes = [
            ['name' => 'Oval', 'img' => asset('images/home/shapes/oval.png')],
            ['name' => 'Cushion', 'img' => asset('images/home/shapes/cushion.png')],
            ['name' => 'Round', 'img' => asset('images/home/shapes/round.png')],
            ['name' => 'Princess', 'img' => asset('images/home/shapes/princess.png')],
            ['name' => 'Pear', 'img' => asset('images/home/shapes/pear.png')],
        ];
    }

    $sliderShapes = $shapes;
    if (count($sliderShapes) < 6) {
        $sliderShapes = array_merge($shapes, $shapes);
    }
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
                                    <img src="{{ $shape['img'] }}"
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
