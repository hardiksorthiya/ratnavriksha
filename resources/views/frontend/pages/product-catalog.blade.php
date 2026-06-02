@extends('frontend.layout.app')

@section('title', ($page->meta_title ?? ucfirst($catalogLabel)) . ' | ' . config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/frontend/diamonds.css') }}">
@endpush

@section('content')
    @include('frontend.component.page-breadcrumb')

    <section class="diamonds-listing py-5">
        <div class="container">
            <div class="row g-4">
                @unless($hideSidebar ?? false)
                    <div class="col-lg-4">
                        @include('frontend.component.diamonds.sidebar', [
                            'shapes' => $shapes,
                            'colors' => $colors,
                            'cuts' => $cuts,
                            'clarities' => $clarities,
                            'categories' => $categories,
                            'activeShapeId' => $activeShapeId,
                            'activeColorId' => $activeColorId,
                            'activeCutId' => $activeCutId,
                            'activeClarityId' => $activeClarityId,
                            'activeCategoryId' => $activeCategoryId,
                            'filterRoute' => $filterRoute ?? 'diamonds',
                            'hideCategoryFilter' => $hideCategoryFilter ?? false,
                        ])
                    </div>
                @endunless

                <div class="{{ ($hideSidebar ?? false) ? 'col-12' : 'col-lg-8' }}">
                    <div class="diamonds-toolbar">
                        <h2 class="diamonds-title font-pilo">
                            @if(!empty($activeCategoryId))
                                {{ $categories->firstWhere('id', $activeCategoryId)->name ?? $defaultListTitle }}
                            @elseif(!empty($activeShapeId))
                                {{ $shapes->firstWhere('id', $activeShapeId)->name ?? $defaultListTitle }}
                            @else
                                {{ $defaultListTitle }}
                            @endif
                        </h2>
                        <p class="diamonds-subtitle">
                            {{ $products->total() }} {{ $catalogLabel }} found
                        </p>
                    </div>

                    <div class="diamonds-grid">
                        @forelse ($products as $product)
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
                        @empty
                            <div class="diamonds-empty col-12">
                                <p>No {{ $catalogLabel }} available right now.</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($products->hasPages() || $products->total() > 0)
                        <div class="diamonds-pagination">
                            {{ $products->links('vendor.pagination.catalog') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
