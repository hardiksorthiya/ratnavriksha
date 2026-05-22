@extends('backend.layout.app')

@section('title', 'Sliders')
@section('page_heading', isset($slider) ? 'Edit Slider' : 'Create Slider')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">{{ isset($slider) ? 'Edit Slider' : 'Create Slider' }}</h2>
            <p class="dash-subtitle mb-0">{{ isset($slider) ? 'Update slider details and images' : 'Add a new homepage slider' }}</p>
        </div>
        <a href="{{ route('sliders.index') }}" class="btn btn-outline-dark-auth btn-sm">
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

    <form action="{{ isset($slider) ? route('sliders.update', $slider->id) : route('sliders.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @if(isset($slider))
            @method('PUT')
        @endif

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="card panel-card h-100">
                    <div class="card-body">
                        <h5 class="profile-section-title">Images</h5>
                        <p class="profile-section-desc mb-4">Upload or remove slider images</p>

                        <div class="mb-4">
                            <label class="form-label">Main Image</label>
                            <input type="file" name="main_image" class="form-control">
                            @if(isset($slider) && $slider->main_image)
                                <div class="slider-preview mt-2">
                                    <img src="{{ asset('storage/'.$slider->main_image) }}" alt="Main image">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="remove_main_image" value="1" class="form-check-input" id="remove_main_image" {{ old('remove_main_image') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remove_main_image">Remove main image</label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Background Image</label>
                            <input type="file" name="desktop_image" class="form-control">
                            @if(isset($slider) && $slider->desktop_image)
                                <div class="slider-preview mt-2">
                                    <img src="{{ asset('storage/'.$slider->desktop_image) }}" alt="Background image">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="remove_desktop_image" value="1" class="form-check-input" id="remove_desktop_image" {{ old('remove_desktop_image') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remove_desktop_image">Remove background image</label>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Mobile Image</label>
                            <input type="file" name="mobile_image" class="form-control">
                            @if(isset($slider) && $slider->mobile_image)
                                <div class="slider-preview mt-2">
                                    <img src="{{ asset('storage/'.$slider->mobile_image) }}" alt="Mobile image">
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="remove_mobile_image" value="1" class="form-check-input" id="remove_mobile_image" {{ old('remove_mobile_image') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remove_mobile_image">Remove mobile image</label>
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
                        <h5 class="profile-section-title">Slider Details</h5>
                        <p class="profile-section-desc mb-4">Text content and button settings</p>

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $slider->title ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subtitle</label>
                            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $slider->subtitle ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $slider->description ?? '') }}</textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Button Text</label>
                                <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $slider->button_text ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Button Link</label>
                                <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $slider->button_link ?? '') }}">
                            </div>
                        </div>

                        <div class="mb-4 mt-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">-- Select status --</option>
                                <option value="active" {{ old('status', $slider->status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $slider->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-gold">
                            <i class="bi bi-check-lg me-1"></i> Save Slider
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
