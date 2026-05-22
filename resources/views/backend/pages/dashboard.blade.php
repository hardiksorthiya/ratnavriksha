@extends('backend.layout.app')

@section('title', 'Dashboard')
@section('page_heading', 'Dashboard')

@section('content')
    <div class="dash-card mb-4">
        <h2 class="dash-title">Welcome Back</h2>
        <p class="dash-subtitle">You're logged in to {{ config('app.name', 'Ratnavriksha') }}</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="panel-card card h-100">
                <div class="card-body">
                    <i class="bi bi-images fs-3 text-primary mb-2 d-block"></i>
                    <h5 class="card-title">Sliders</h5>
                    <p class="dash-subtitle mb-3">Manage homepage sliders</p>
                    <a href="{{ route('sliders.index') }}" class="btn btn-gold btn-sm">View Sliders</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel-card card h-100">
                <div class="card-body">
                    <i class="bi bi-person-circle fs-3 text-primary mb-2 d-block"></i>
                    <h5 class="card-title">Profile</h5>
                    <p class="dash-subtitle mb-3">Update your account details</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-gold btn-sm">Edit Profile</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel-card card h-100">
                <div class="card-body">
                    <i class="bi bi-house fs-3 text-primary mb-2 d-block"></i>
                    <h5 class="card-title">Website</h5>
                    <p class="dash-subtitle mb-3">View the frontend home page</p>
                    <a href="{{ route('home') }}" class="btn btn-gold btn-sm" target="_blank">Open Site</a>
                </div>
            </div>
        </div>
    </div>
@endsection
