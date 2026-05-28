@extends('backend.layout.app')

@section('title', isset($post) ? 'Edit Post' : 'Create Post')
@section('page_heading', isset($post) ? 'Edit Post' : 'Create Post')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">{{ isset($post) ? 'Edit Post' : 'Create Post' }}</h2>
            <p class="dash-subtitle mb-0">Add content, feature image and SEO data.</p>
        </div>
        <a href="{{ route('posts.index') }}" class="btn btn-outline-dark-auth btn-sm">
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

    <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($post))
            @method('PUT')
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">Feature Image</h5>
                        <p class="profile-section-desc mb-3">Upload featured blog image</p>

                        <input type="file" name="feature_image" class="form-control" accept="image/*">
                        @if(isset($post) && $post->feature_image)
                            <div class="slider-preview mt-3">
                                <img src="{{ asset('storage/'.$post->feature_image) }}" alt="{{ $post->title }}">
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
                        <p class="profile-section-desc mb-3">Meta title, description and keywords</p>

                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $post->meta_title ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" rows="3" class="form-control">{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Meta Keywords</label>
                            <textarea name="meta_keywords" rows="3" class="form-control" placeholder="keyword1, keyword2">{{ old('meta_keywords', $post->meta_keywords ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">Post Details</h5>
                        <p class="profile-section-desc mb-4">Title, category, excerpt and content</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Post Title</label>
                                <input type="text" name="title" id="postTitle" class="form-control" value="{{ old('title', $post->title ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" id="postSlug" class="form-control" value="{{ old('slug', $post->slug ?? '') }}" placeholder="auto-generated from title">
                                <small class="text-muted-small">Leave empty to auto-generate from title</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select name="post_category_id" class="form-select">
                                    <option value="">-- Select category --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (string) old('post_category_id', $post->post_category_id ?? '') === (string) $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ old('status', $post->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $post->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Publish Date</label>
                                <input type="date" name="published_at" class="form-control" value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d') : now()->format('Y-m-d')) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Excerpt</label>
                                <textarea name="excerpt" rows="3" class="form-control" placeholder="Short summary">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description (HTML supported)</label>
                                <textarea name="description" rows="12" class="form-control font-monospace" placeholder="<h2>Heading</h2><p>Write blog content with HTML...</p>">{{ old('description', $post->description ?? '') }}</textarea>
                                <small class="text-muted-small">You can use HTML tags like &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;blockquote&gt;, &lt;a&gt;, &lt;img&gt; and &lt;table&gt;.</small>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-gold mt-4">
                            <i class="bi bi-check-lg me-1"></i> Save Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var title = document.getElementById('postTitle');
            var slug = document.getElementById('postSlug');
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

