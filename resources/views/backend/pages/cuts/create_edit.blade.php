@extends('backend.layout.app')

@section('title', 'Cuts')
@section('page_heading', isset($cut) ? 'Edit Cut' : 'Create Cut')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">{{ isset($cut) ? 'Edit Cut' : 'Create Cut' }}</h2>
            <p class="dash-subtitle mb-0">{{ isset($cut) ? 'Update diamond cut name' : 'Add a new diamond cut grade' }}</p>
        </div>
        <a href="{{ route('cuts.index') }}" class="btn btn-outline-dark-auth btn-sm">
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
                    <h5 class="profile-section-title">Cut Details</h5>
                    <p class="profile-section-desc mb-4">Enter diamond cut name (e.g. Excellent, Very Good, Good)</p>

                    <form action="{{ isset($cut) ? route('cuts.update', $cut->id) : route('cuts.store') }}" method="POST">
                        @csrf
                        @if(isset($cut))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label class="form-label">Cut Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $cut->name ?? '') }}" placeholder="e.g. Excellent, Very Good">
                        </div>

                        <button type="submit" class="btn btn-gold">
                            <i class="bi bi-check-lg me-1"></i> Save Cut
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
