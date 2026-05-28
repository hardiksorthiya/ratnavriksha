@extends('frontend.layout.app')

@section('title', 'Blogs | ' . config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/frontend/blog.css') }}">
@endpush

@section('content')
    @include('frontend.component.page-breadcrumb')

    <section class="blog-listing py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <article class="blog-card h-100">
                            <a href="{{ route('blogs.show', $post->slug) }}" class="blog-card-image">
                                @if($post->feature_image)
                                    <img src="{{ asset('storage/'.$post->feature_image) }}" alt="{{ $post->title }}" loading="lazy">
                                @else
                                    <div class="blog-card-image-placeholder"><i class="fa-solid fa-newspaper"></i></div>
                                @endif
                            </a>
                            <div class="blog-card-body">
                                <span class="blog-card-cat">{{ $post->category?->name ?? 'General' }}</span>
                                <h2 class="blog-card-title font-pilo">
                                    <a href="{{ route('blogs.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <p class="blog-card-excerpt">{{ \Illuminate\Support\Str::limit($post->excerpt ?: strip_tags($post->description), 120) }}</p>
                                <a href="{{ route('blogs.show', $post->slug) }}" class="blog-card-link">Read More <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="blog-empty">No blogs available right now.</div>
                    </div>
                @endforelse
            </div>

            @if($posts->hasPages())
                <div class="blog-pagination mt-4">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

