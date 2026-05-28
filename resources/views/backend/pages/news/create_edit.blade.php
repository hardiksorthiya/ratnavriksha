@extends('backend.layout.app')

@section('title', isset($news) ? 'Edit News/Event' : 'Create News/Event')
@section('page_heading', isset($news) ? 'Edit News/Event' : 'Create News/Event')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">{{ isset($news) ? 'Edit News/Event' : 'Create News/Event' }}</h2>
            <p class="dash-subtitle mb-0">Add title, excerpt, description, image and SEO.</p>
        </div>
        <a href="{{ route('news.index') }}" class="btn btn-outline-dark-auth btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($news) ? route('news.update', $news->id) : route('news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($news))
            @method('PUT')
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">Feature Image</h5>
                        <input type="file" name="feature_image" class="form-control" accept="image/*">
                        @if(isset($news) && $news->feature_image)
                            <div class="slider-preview mt-3">
                                <img src="{{ asset('storage/'.$news->feature_image) }}" alt="{{ $news->title }}">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="remove_feature_image" value="1" class="form-check-input" id="remove_feature_image">
                                    <label class="form-check-label" for="remove_feature_image">Remove feature image</label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">SEO</h5>
                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $news->meta_title ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" rows="3" class="form-control">{{ old('meta_description', $news->meta_description ?? '') }}</textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Meta Keywords</label>
                            <textarea name="meta_keywords" rows="3" class="form-control">{{ old('meta_keywords', $news->meta_keywords ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">News/Event Details</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" id="newsTitle" class="form-control" value="{{ old('title', $news->title ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" id="newsSlug" class="form-control" value="{{ old('slug', $news->slug ?? '') }}" placeholder="auto-generated from title">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select name="news_category_id" class="form-select">
                                    <option value="">-- Select category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (string) old('news_category_id', $news->news_category_id ?? '') === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ old('status', $news->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $news->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Publish Date</label>
                                <input type="date" name="published_at" class="form-control" value="{{ old('published_at', isset($news) && $news->published_at ? $news->published_at->format('Y-m-d') : now()->format('Y-m-d')) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Excerpt</label>
                                <textarea name="excerpt" rows="3" class="form-control">{{ old('excerpt', $news->excerpt ?? '') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description (HTML supported)</label>
                                <textarea name="description" rows="12" class="form-control font-monospace">{{ old('description', $news->description ?? '') }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-gold mt-4">
                            <i class="bi bi-check-lg me-1"></i> Save News/Event
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var title = document.getElementById('newsTitle');
            var slug = document.getElementById('newsSlug');
            if (!title || !slug) return;
            title.addEventListener('input', function () {
                if (slug.dataset.touched === '1') return;
                slug.value = title.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').trim().replace(/\s+/g, '-').replace(/-+/g, '-');
            });
            slug.addEventListener('input', function () {
                slug.dataset.touched = slug.value ? '1' : '0';
            });
        });
    </script>
@endsection

