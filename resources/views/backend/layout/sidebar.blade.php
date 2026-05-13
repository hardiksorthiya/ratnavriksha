<aside id="appSidebar" class="sidebar">
    <div class="p-3 border-bottom">
        <a href="{{ route('dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <i class="bi bi-gem fs-4 text-primary"></i>
            <span class="brand-text fw-semibold text-dark">{{ config('app.name', 'Laravel') }}</span>
        </a>
    </div>

    <div class="p-2">
        <div class="nav nav-pills flex-column gap-1">
            <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('dashboard') ? 'active' : 'text-dark' }}">
                <i class="bi bi-speedometer2 fs-5"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('profile.*') ? 'active' : 'text-dark' }}">
                <i class="bi bi-person-circle fs-5"></i>
                <span class="menu-text">Profile</span>
            </a>
        </div>
    </div>
</aside>
