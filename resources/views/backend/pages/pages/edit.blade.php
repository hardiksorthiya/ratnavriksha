@extends('backend.layout.app')

@section('title', 'Edit Page')
@section('page_heading', 'Edit Page')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">Edit: {{ $page->name }}</h2>
            <p class="dash-subtitle mb-0">Breadcrumb hero only — body in <code>frontend/pages/{{ $page->slug }}.blade.php</code></p>
        </div>
        <a href="{{ route('pages.index') }}" class="btn btn-outline-dark-auth btn-sm">
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

    <form action="{{ route('pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card panel-card h-100">
                    <div class="card-body">
                        <h5 class="profile-section-title">Background Image</h5>
                        <p class="profile-section-desc mb-4">Hero / breadcrumb background</p>

                        <input type="file" name="bg_image" class="form-control" accept="image/*">
                        @if($page->bg_image)
                            <div class="slider-preview mt-3">
                                <img src="{{ asset('storage/'.$page->bg_image) }}" alt="Background">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="remove_bg_image" value="1" class="form-check-input" id="remove_bg_image">
                                    <label class="form-check-label" for="remove_bg_image">Remove background</label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card panel-card h-100">
                    <div class="card-body">
                        <h5 class="profile-section-title">Breadcrumb Content</h5>
                        <p class="profile-section-desc mb-4">Browser tab title + hero section</p>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Page</label>
                                <input type="text" class="form-control" value="{{ $page->name }}" readonly disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">URL</label>
                                <input type="text" class="form-control" value="/{{ $page->slug }}" readonly disabled>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Page Title (browser tab)</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title) }}" placeholder="About Us | Ratnavriksha">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" name="label" class="form-control" value="{{ old('label', $page->label) }}" placeholder="e.g. About Us">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Heading</label>
                            <textarea name="heading" class="form-control" rows="3">{{ old('heading', $page->heading) }}</textarea>
                            <small class="text-muted-small">New line = second line in heading</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $page->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ old('status', $page->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $page->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-gold">
                            <i class="bi bi-check-lg me-1"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
