@extends('backend.layout.app')

@section('title', 'Clarities')
@section('page_heading', isset($clarity) ? 'Edit Clarity' : 'Create Clarity')

@section('content')
    <div class="dash-card mb-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="dash-title mb-1">{{ isset($clarity) ? 'Edit Clarity' : 'Create Clarity' }}</h2>
            <p class="dash-subtitle mb-0">{{ isset($clarity) ? 'Update diamond clarity name' : 'Add a new diamond clarity grade' }}</p>
        </div>
        <a href="{{ route('clarities.index') }}" class="btn btn-outline-dark-auth btn-sm">
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
                    <h5 class="profile-section-title">Clarity Details</h5>
                    <p class="profile-section-desc mb-4">Enter diamond clarity name (e.g. FL, VVS1, VS1, SI1)</p>

                    <form action="{{ isset($clarity) ? route('clarities.update', $clarity->id) : route('clarities.store') }}" method="POST">
                        @csrf
                        @if(isset($clarity))
                            @method('PUT')
                        @endif

                        <div class="mb-4">
                            <label class="form-label">Clarity Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $clarity->name ?? '') }}" placeholder="e.g. VVS1, VS1, SI1">
                        </div>

                        <button type="submit" class="btn btn-gold">
                            <i class="bi bi-check-lg me-1"></i> Save Clarity
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
