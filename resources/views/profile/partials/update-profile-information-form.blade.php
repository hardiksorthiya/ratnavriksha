<div class="profile-section">
    <h5 class="profile-section-title">Profile Information</h5>
    <p class="profile-section-desc">Update your name and email address.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label class="form-label" for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <p class="profile-section-desc mt-2 mb-0">
                    Your email is unverified.
                    <button form="send-verification" type="submit" class="btn btn-link auth-link p-0 align-baseline">Resend verification email</button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <p class="text-success small mt-1 mb-0">A new verification link has been sent.</p>
                @endif
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-gold">Save</button>
            @if (session('status') === 'profile-updated')
                <span class="text-success small">Saved.</span>
            @endif
        </div>
    </form>
</div>
