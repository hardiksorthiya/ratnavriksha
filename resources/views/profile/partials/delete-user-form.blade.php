<div class="profile-section">
    <h5 class="profile-section-title text-danger">Delete Account</h5>
    <p class="profile-section-desc">Once deleted, all your data will be permanently removed.</p>

    <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        Delete Account
    </button>
</div>

<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content panel-card border-0">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title profile-section-title">Delete Account?</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <p class="profile-section-desc">Enter your password to confirm permanent deletion.</p>
                    <label class="form-label" for="delete_password">Password</label>
                    <input type="password" name="password" id="delete_password" class="form-control" placeholder="Enter your password">
                    @error('password', 'userDeletion')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="modal-footer border-secondary border-opacity-25">
                    <button type="button" class="btn btn-outline-secondary btn-outline-dark-auth" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->userDeletion->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new bootstrap.Modal(document.getElementById('deleteAccountModal')).show();
        });
    </script>
@endif
