<div class="profile-section">
    <h5 class="profile-section-title">Update Password</h5>
    <p class="profile-section-desc">Use a strong password to keep your account secure.</p>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label class="form-label" for="update_password_current_password">Current Password</label>
            <input type="password" name="current_password" id="update_password_current_password" class="form-control" autocomplete="current-password">
            @error('current_password', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="update_password_password">New Password</label>
            <input type="password" name="password" id="update_password_password" class="form-control" autocomplete="new-password">
            @error('password', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label" for="update_password_password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="update_password_password_confirmation" class="form-control" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-gold">Save</button>
            @if (session('status') === 'password-updated')
                <span class="text-success small">Saved.</span>
            @endif
        </div>
    </form>
</div>
