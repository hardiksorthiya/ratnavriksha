@extends('backend.layout.app')

@section('title', 'Products')
@section('page_heading', isset($product) ? 'Edit Product' : 'Create Product')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">{{ isset($product) ? 'Edit Product' : 'Create Product' }}</h2>
            <p class="dash-subtitle mb-0">{{ isset($product) ? 'Update product details, media and SEO' : 'Add a new diamond product' }}</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-dark-auth btn-sm">
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

    <form action="{{ isset($product) ? route('products.update', optional($product)->id) : route('products.store') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">Featured Media</h5>
                        <p class="profile-section-desc mb-4">One image or video</p>

                        <input type="file" name="featured_media" class="form-control" accept="image/*,video/*">
                        @if($product && optional($product)->featured_path)
                            <div class="slider-preview mt-3">
                                @if(optional($product)->featured_type === 'video')
                                    <video src="{{ asset('storage/'.optional($product)->featured_path) }}" controls class="w-100 rounded"></video>
                                @else
                                    <img src="{{ asset('storage/'.optional($product)->featured_path) }}" alt="Featured">
                                @endif
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="remove_featured" value="1" class="form-check-input" id="remove_featured" {{ old('remove_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remove_featured">Remove featured media</label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">Gallery</h5>
                        <p class="profile-section-desc mb-4">Add multiple images or videos</p>

                        <input type="file" name="gallery[]" class="form-control" accept="image/*,video/*" multiple>

                        @if($product && optional($product)->media->isNotEmpty())
                            <div class="product-gallery-grid mt-3">
                                @foreach(optional($product)->media as $media)
                                    <div class="product-gallery-item">
                                        @if($media->type === 'video')
                                            <video src="{{ asset('storage/'.$media->path) }}" muted class="rounded"></video>
                                            <span class="badge badge-active mt-1">Video</span>
                                        @else
                                            <img src="{{ asset('storage/'.$media->path) }}" alt="Gallery" class="rounded">
                                        @endif
                                        <div class="form-check mt-1">
                                            <input type="checkbox" name="remove_gallery[]" value="{{ $media->id }}" class="form-check-input" id="remove_gallery_{{ $media->id }}">
                                            <label class="form-check-label small" for="remove_gallery_{{ $media->id }}">Remove</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">Attributes</h5>
                        <p class="profile-section-desc mb-4">Shape, color, clarity and cut</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Shape</label>
                                <select name="shape_id" class="form-select">
                                    <option value="">-- Select shape --</option>
                                    @foreach($shapes as $shape)
                                        <option value="{{ $shape->id }}" {{ (string) old('shape_id', optional($product)->shape_id ?? '') === (string) $shape->id ? 'selected' : '' }}>{{ $shape->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Color</label>
                                <select name="color_id" class="form-select">
                                    <option value="">-- Select color --</option>
                                    @foreach($colors as $color)
                                        <option value="{{ $color->id }}" {{ (string) old('color_id', optional($product)->color_id ?? '') === (string) $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Clarity</label>
                                <select name="clarity_id" class="form-select">
                                    <option value="">-- Select clarity --</option>
                                    @foreach($clarities as $clarity)
                                        <option value="{{ $clarity->id }}" {{ (string) old('clarity_id', optional($product)->clarity_id ?? '') === (string) $clarity->id ? 'selected' : '' }}>{{ $clarity->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Cut</label>
                                <select name="cut_id" class="form-select">
                                    <option value="">-- Select cut --</option>
                                    @foreach($cuts as $cut)
                                        <option value="{{ $cut->id }}" {{ (string) old('cut_id', optional($product)->cut_id ?? '') === (string) $cut->id ? 'selected' : '' }}>{{ $cut->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">SEO</h5>
                        <p class="profile-section-desc mb-4">Meta title, description and keywords</p>

                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', optional($product)->meta_title ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', optional($product)->meta_description ?? '') }}</textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Meta Keywords</label>
                            <textarea name="meta_keywords" class="form-control" rows="2" placeholder="keyword1, keyword2">{{ old('meta_keywords', optional($product)->meta_keywords ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">Basic Info</h5>
                        <p class="profile-section-desc mb-4">Name, slug, stone ID and status</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" id="productName" class="form-control" value="{{ old('name', optional($product)->name ?? '') }}" placeholder="Product name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" id="productSlug" class="form-control" value="{{ old('slug', optional($product)->slug ?? '') }}" placeholder="auto-generated from name">
                                <small class="text-muted-small">Leave empty to auto-generate from name</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stone ID</label>
                                <input type="text" name="stone_id" class="form-control" value="{{ old('stone_id', optional($product)->stone_id ?? '') }}" placeholder="Stone ID">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">-- Select status --</option>
                                    <option value="active" {{ old('status', optional($product)->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', optional($product)->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

               

                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">Measurements</h5>
                        <p class="profile-section-desc mb-4">Weights and dimensions</p>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Row Weight</label>
                                <input type="text" name="row_weight" class="form-control" value="{{ old('row_weight', optional($product)->row_weight ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Polish Weight</label>
                                <input type="text" name="polish_weight" class="form-control" value="{{ old('polish_weight', optional($product)->polish_weight ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Length</label>
                                <input type="text" name="length" class="form-control" value="{{ old('length', optional($product)->length ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Width</label>
                                <input type="text" name="width" class="form-control" value="{{ old('width', optional($product)->width ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Table</label>
                                <input type="text" name="table_percent" class="form-control" value="{{ old('table_percent', optional($product)->table_percent ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">TD (Total Depth)</label>
                                <input type="text" name="total_depth" class="form-control" value="{{ old('total_depth', optional($product)->total_depth ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Ratio</label>
                                <input type="text" name="ratio" class="form-control" value="{{ old('ratio', optional($product)->ratio ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card panel-card mb-4">
                    <div class="card-body">
                        <h5 class="profile-section-title">Descriptions</h5>
                        <p class="profile-section-desc mb-4">Remarks and product copy</p>

                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" class="form-control" rows="3">{{ old('short_description', optional($product)->short_description ?? '') }}</textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Long Description</label>
                            <textarea name="long_description" class="form-control" rows="6">{{ old('long_description', optional($product)->long_description ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2">{{ old('remarks', optional($product)->remarks ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

            

                <button type="submit" class="btn btn-gold">
                    <i class="bi bi-check-lg me-1"></i> Save Product
                </button>
            </div>
        </div>
    </form>
@endsection
