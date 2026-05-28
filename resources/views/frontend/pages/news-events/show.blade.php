@extends('frontend.layout.app')

@section('title', $news->meta_title ?: ($news->title . ' | ' . config('app.name')))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/frontend/blog.css') }}">
@endpush

@section('content')
    @include('frontend.component.breadcrumb', [
        'label' => 'News Detail',
        'heading' => $news->title,
        'description' => $news->excerpt,
        'bgImage' => asset('images/pages/breadcrumb-bg.png'),
    ])

    <section class="blog-detail py-5">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-8">
                    <article class="blog-article">
                        @if($news->feature_image)
                            <img src="{{ asset('storage/'.$news->feature_image) }}" alt="{{ $news->title }}" class="blog-article-feature">
                        @endif

                        <div class="blog-article-content">
                            <h1 class="blog-article-title font-pilo">{{ $news->title }}</h1>
                            <p class="blog-article-meta">
                                <span>{{ optional($news->published_at)->format('d M Y') ?: $news->created_at->format('d M Y') }}</span>
                                <span>•</span>
                                <span>{{ $news->category?->name ?? 'General' }}</span>
                            </p>
                            <div class="blog-article-description">
                                {!! $news->description !!}
                            </div>
                        </div>
                    </article>

                    <div class="blog-nav-posts">
                        <a class="blog-nav-post {{ $previousNews ? '' : 'is-disabled' }}" href="{{ $previousNews ? route('news-events.show', $previousNews->slug) : 'javascript:void(0)' }}">
                            <i class="fa-solid fa-arrow-left"></i> Previous News
                        </a>
                        <a class="blog-nav-post {{ $nextNews ? '' : 'is-disabled' }}" href="{{ $nextNews ? route('news-events.show', $nextNews->slug) : 'javascript:void(0)' }}">
                            Next News <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="blog-comments">
                        <h3 class="font-pilo">Comments ({{ $news->comments->count() }})</h3>

                        @if(session('news_comment_success'))
                            <div class="alert alert-success">{{ session('news_comment_success') }}</div>
                        @endif

                        <form action="{{ route('news-events.comments.store', $news->slug) }}" method="POST" class="blog-comment-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Your Name">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Your Email">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <textarea name="comment" rows="4" class="form-control @error('comment') is-invalid @enderror" placeholder="Write your comment...">{{ old('comment') }}</textarea>
                                    @error('comment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary-sorath" type="submit">Post Comment</button>
                                </div>
                            </div>
                        </form>

                        <div class="blog-comment-list">
                            @forelse($news->comments as $comment)
                                <div class="blog-comment-item">
                                    <div class="blog-comment-head">
                                        <strong>{{ $comment->name }}</strong>
                                        <span>{{ $comment->created_at->format('d M Y') }}</span>
                                    </div>
                                    <p>{{ $comment->comment }}</p>
                                </div>
                            @empty
                                <p class="text-muted">No comments yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <aside class="blog-sidebar">
                        <div class="blog-sidebar-card">
                            <h4 class="font-pilo">Need Assistance?</h4>
                            <p>Contact our team for updates on events and diamond guidance.</p>
                            <a href="{{ route('contact') }}" class="blog-sidebar-link">Contact Us <i class="fa-solid fa-chevron-right"></i></a>
                        </div>

                        <div class="blog-sidebar-card">
                            <h4 class="font-pilo">Latest News</h4>
                            <ul class="blog-latest-list">
                                @forelse($latestNews as $latest)
                                    <li><a href="{{ route('news-events.show', $latest->slug) }}">{{ $latest->title }}</a></li>
                                @empty
                                    <li class="text-muted">No latest items.</li>
                                @endforelse
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>

            @if($relatedNews->count())
                <div class="blog-related mt-5">
                    <h3 class="font-pilo mb-4">Related News</h3>
                    <div class="row g-4">
                        @foreach($relatedNews as $related)
                            <div class="col-md-6 col-lg-4">
                                <article class="blog-card h-100">
                                    <a href="{{ route('news-events.show', $related->slug) }}" class="blog-card-image">
                                        @if($related->feature_image)
                                            <img src="{{ asset('storage/'.$related->feature_image) }}" alt="{{ $related->title }}" loading="lazy">
                                        @else
                                            <div class="blog-card-image-placeholder"><i class="fa-solid fa-bullhorn"></i></div>
                                        @endif
                                    </a>
                                    <div class="blog-card-body">
                                        <span class="blog-card-cat">{{ $related->category?->name ?? 'General' }}</span>
                                        <h4 class="blog-card-title font-pilo">
                                            <a href="{{ route('news-events.show', $related->slug) }}">{{ $related->title }}</a>
                                        </h4>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

