@extends('layouts.guest')

@section('title', 'Forgot Password')
@section('heading', 'Forgot Password')
@section('subheading', 'Enter your email and we will send you a reset link')

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

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label class="auth-label" for="email">Email Address</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
            </div>
        </div>

        <button type="submit" class="btn btn-auth">Send Reset Link</button>
    </form>

    <p class="auth-footer">
        <a href="{{ route('login') }}" class="auth-link">Back to Login</a>
    </p>
@endsection
