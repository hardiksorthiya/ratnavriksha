@extends('backend.layout.app')

@section('title', 'Categories')
@section('page_heading', isset($category) ? 'Edit Category' : 'Create Category')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">{{ isset($category) ? 'Edit Category' : 'Create Category' }}</h2>
            <p class="dash-subtitle mb-0">{{ isset($category) ? 'Update category name' : 'Add a new product category' }}</p>
        </div>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-dark-auth btn-sm">
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

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card panel-card">
                <div class="card-body">
                    <h5 class="profile-section-title">Category Details</h5>
                    <p class="profile-section-desc mb-4">Enter category name</p>

                    <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST">
                        @csrf
                        @if(isset($category))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" placeholder="e.g. Engagement, Bridal, Loose">
                        </div>

                        <button type="submit" class="btn btn-gold">
                            <i class="bi bi-check-lg me-1"></i> Save Category
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
