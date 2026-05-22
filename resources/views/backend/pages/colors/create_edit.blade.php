@extends('backend.layout.app')

@section('title', 'Colors')
@section('page_heading', isset($color) ? 'Edit Color' : 'Create Color')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">{{ isset($color) ? 'Edit Color' : 'Create Color' }}</h2>
            <p class="dash-subtitle mb-0">{{ isset($color) ? 'Update diamond color name' : 'Add a new diamond color grade' }}</p>
        </div>
        <a href="{{ route('colors.index') }}" class="btn btn-outline-dark-auth btn-sm">
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
                    <h5 class="profile-section-title">Color Details</h5>
                    <p class="profile-section-desc mb-4">Enter diamond color name (e.g. D, E, F, M, L)</p>

                    <form action="{{ isset($color) ? route('colors.update', $color->id) : route('colors.store') }}" method="POST">
                        @csrf
                        @if(isset($color))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label class="form-label">Color Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $color->name ?? '') }}" placeholder="e.g. M, L, D, E">
                        </div>

                        <button type="submit" class="btn btn-gold">
                            <i class="bi bi-check-lg me-1"></i> Save Color
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
