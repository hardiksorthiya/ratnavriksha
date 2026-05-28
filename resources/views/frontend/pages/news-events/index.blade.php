@extends('frontend.layout.app')

@section('title', 'News & Events | ' . config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/frontend/blog.css') }}">
@endpush

@section('content')
    @include('frontend.component.page-breadcrumb')

    <section class="blog-listing py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($newsItems as $news)
                    <div class="col-md-6 col-lg-4">
                        <article class="blog-card h-100">
                            <a href="{{ route('news-events.show', $news->slug) }}" class="blog-card-image">
                                @if($news->feature_image)
                                    <img src="{{ asset('storage/'.$news->feature_image) }}" alt="{{ $news->title }}" loading="lazy">
                                @else
                                    <div class="blog-card-image-placeholder"><i class="fa-solid fa-bullhorn"></i></div>
                                @endif
                            </a>
                            <div class="blog-card-body">
                                <span class="blog-card-cat">{{ $news->category?->name ?? 'General' }}</span>
                                <h2 class="blog-card-title font-pilo">
                                    <a href="{{ route('news-events.show', $news->slug) }}">{{ $news->title }}</a>
                                </h2>
                                <p class="blog-card-excerpt">{{ \Illuminate\Support\Str::limit($news->excerpt ?: strip_tags($news->description), 120) }}</p>
                                <a href="{{ route('news-events.show', $news->slug) }}" class="blog-card-link">Read More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="blog-empty">No news/events available right now.</div>
                    </div>
                @endforelse
            </div>

            @if($newsItems->hasPages())
                <div class="blog-pagination mt-4">
                    {{ $newsItems->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

