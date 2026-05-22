@extends('backend.layout.app')

@section('title', 'Shapes')
@section('page_heading', isset($shape) ? 'Edit Shape' : 'Create Shape')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">{{ isset($shape) ? 'Edit Shape' : 'Create Shape' }}</h2>
            <p class="dash-subtitle mb-0">{{ isset($shape) ? 'Update shape details and image' : 'Add a new diamond shape' }}</p>
        </div>
        <a href="{{ route('shapes.index') }}" class="btn btn-outline-dark-auth btn-sm">
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

    <form action="{{ isset($shape) ? route('shapes.update', $shape->id) : route('shapes.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @if(isset($shape))
            @method('PUT')
        @endif

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card panel-card h-100">
                    <div class="card-body">
                        <h5 class="profile-section-title">Shape Image</h5>
                        <p class="profile-section-desc mb-4">Upload or remove shape image</p>

                        <div class="mb-0">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if(isset($shape) && $shape->image)
                                <div class="slider-preview mt-2">
                                    <img src="{{ asset('storage/'.$shape->image) }}" alt="{{ $shape->name }}">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="remove_image" value="1" class="form-check-input" id="remove_image" {{ old('remove_image') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remove_image">Remove image</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card panel-card h-100">
                    <div class="card-body">
                        <h5 class="profile-section-title">Shape Details</h5>
                        <p class="profile-section-desc mb-4">Name, slug and status</p>

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="shapeName" class="form-control" value="{{ old('name', $shape->name ?? '') }}" placeholder="e.g. Round">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" id="shapeSlug" class="form-control" value="{{ old('slug', $shape->slug ?? '') }}" placeholder="auto-generated from name">
                            <small class="text-muted-small">Leave empty to auto-generate from name</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">-- Select status --</option>
                                <option value="active" {{ old('status', $shape->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $shape->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-gold">
                            <i class="bi bi-check-lg me-1"></i> Save Shape
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
