@extends('layouts.guest')

@section('title', 'Register')
@section('heading', 'Create Account')
@section('subheading', 'Sign up to get started')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger auth-alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="auth-label" for="name">Full Name</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" value="{{ old('name') }}" required autofocus>
            </div>
        </div>

        <div class="mb-3">
            <label class="auth-label" for="email">Email Address</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="auth-label" for="password">Password</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                <button type="button" class="btn btn-toggle-pass" data-target="#password"><i class="bi bi-eye"></i></button>
            </div>
        </div>

        <div class="mb-4">
            <label class="auth-label" for="password_confirmation">Confirm Password</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm your password" required>
                <button type="button" class="btn btn-toggle-pass" data-target="#password_confirmation"><i class="bi bi-eye"></i></button>
            </div>
        </div>

        <button type="submit" class="btn btn-auth">Register</button>
    </form>

    <p class="auth-footer">
        Already have an account? <a href="{{ route('login') }}" class="auth-link">Login</a>
    </p>
@endsection
