@extends('frontend.layout.app')

@section('title', 'Diamonds | ' . config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/frontend/diamonds.css') }}">
@endpush

@section('content')
    @include('frontend.component.page-breadcrumb')

    <section class="diamonds-listing py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    @include('frontend.component.diamonds.sidebar', [
                        'shapes' => $shapes,
                        'colors' => $colors,
                        'cuts' => $cuts,
                        'clarities' => $clarities,
                        'activeShapeId' => $activeShapeId,
                        'activeColorId' => $activeColorId,
                        'activeCutId' => $activeCutId,
                        'activeClarityId' => $activeClarityId,
                    ])
                </div>

                <div class="col-lg-8">
                    <div class="diamonds-toolbar">
                        <h2 class="diamonds-title font-pilo">
                            {!!
                                $activeShapeId
                                    ? ($shapes->firstWhere('id', $activeShapeId)->name ?? 'Diamonds')
                                    : 'All Diamonds'
                            !!}
                        </h2>
                        <p class="diamonds-subtitle">
                            {{ $products->total() }} diamonds found
                        </p>
                    </div>

                    <div class="diamonds-grid">
                        @foreach ($products as $product)
                            <div class="diamonds-card-wrap">
                                <article class="diamonds-card">
                                    <a class="diamonds-card-media" href="{{ route('product.show', $product->slug) }}" aria-label="{{ $product->name }}">
                                        @if($product->list_media_type === 'video')
                                            <video autoplay muted loop playsinline preload="metadata">
                                                <source src="{{ $product->list_media_src }}">
                                            </video>
                                        @else
                                            <img src="{{ $product->list_media_src }}"
                                                alt="{{ $product->name }}"
                                                class="{{ empty($product->featured_path) ? 'diamonds-card-logo' : '' }}"
                                                loading="lazy">
                                        @endif

                                        <div class="diamonds-card-overlay">
                                            <span class="diamonds-card-link">
                                                View Details
                                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </a>

                                    <div class="diamonds-card-body">
                                        <h3 class="diamonds-card-title font-pilo">
                                            <a href="{{ route('product.show', $product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>

                                        <p class="diamonds-card-stone-id">
                                            {{ $product->stone_id ? 'ID: '.$product->stone_id : 'ID: —' }}
                                        </p>

                                       
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>

                    @if ($products->hasPages())
                        <div class="diamonds-pagination">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

