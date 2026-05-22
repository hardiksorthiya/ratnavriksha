@extends('layouts.guest')

@section('title', 'Login')
@section('heading', 'Welcome Back')
@section('subheading', 'Sign in to continue to your account')

@section('content')
    @if (session('status'))
        <div class="alert alert-success auth-alert">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger auth-alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="auth-label" for="email">Email Address</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check auth-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">Forgot Password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-auth">Login</button>
    </form>

    <p class="auth-footer">
        Don't have an account? <a href="{{ route('register') }}" class="auth-link">Register</a>
    </p>
@endsection
