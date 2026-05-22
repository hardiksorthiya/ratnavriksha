@extends('backend.layout.app')

@section('title', 'Profile')
@section('page_heading', 'Profile')

@section('content')
    <div class="dash-card mb-4">
        <h2 class="dash-title">My Profile</h2>
        <p class="dash-subtitle mb-0">Manage your account information and security</p>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card panel-card h-100">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card panel-card h-100">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card panel-card panel-card-danger">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
