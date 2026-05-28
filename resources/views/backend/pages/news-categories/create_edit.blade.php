@extends('backend.layout.app')

@section('title', isset($category) ? 'Edit News Category' : 'Create News Category')
@section('page_heading', isset($category) ? 'Edit News Category' : 'Create News Category')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">{{ isset($category) ? 'Edit News/Event Category' : 'Create News/Event Category' }}</h2>
            <p class="dash-subtitle mb-0">Slug will be generated automatically from name.</p>
        </div>
        <a href="{{ route('news-categories.index') }}" class="btn btn-outline-dark-auth btn-sm">
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

    <form action="{{ isset($category) ? route('news-categories.update', $category->id) : route('news-categories.store') }}" method="POST">
        @csrf
        @if(isset($category))
            @method('PUT')
        @endif

        <div class="card panel-card">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Category Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" placeholder="e.g. Exhibition, Launches" required>
                </div>

                <button type="submit" class="btn btn-gold">
                    <i class="bi bi-check-lg me-1"></i> Save Category
                </button>
            </div>
        </div>
    </form>
@endsection

