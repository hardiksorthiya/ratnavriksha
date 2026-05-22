<aside id="appSidebar" class="sidebar">
    <div class="p-3 border-bottom">
        <a href="{{ route('dashboard') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <i class="bi bi-gem fs-4 sidebar-brand-icon"></i>
            <span class="brand-text fw-semibold">{{ config('app.name', 'Ratnavriksha') }}</span>
        </a>
    </div>

    <div class="p-2">
        <div class="nav nav-pills flex-column gap-1">
            <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 fs-5"></i>
                <span class="menu-text">Dashboard</span>
            </a>

            <a href="{{ route('profile.edit') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle fs-5"></i>
                <span class="menu-text">Profile</span>
            </a>

            <a href="{{ route('sliders.index') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('sliders.*') ? 'active' : '' }}">
                <i class="bi bi-images fs-5"></i>
                <span class="menu-text">Sliders</span>
            </a>

            @php
                $productMenuOpen = request()->routeIs('shapes.*') || request()->routeIs('colors.*') || request()->routeIs('clarities.*') || request()->routeIs('cuts.*') || request()->routeIs('products.*');
            @endphp

            <div class="sidebar-dropdown">
                <button type="button"
                    class="nav-link sidebar-dropdown-toggle d-flex align-items-center gap-2 w-100 {{ $productMenuOpen ? '' : 'collapsed' }} {{ $productMenuOpen ? 'active' : '' }}"
                    data-bs-toggle="collapse"
                    data-bs-target="#productMenu"
                    aria-expanded="{{ $productMenuOpen ? 'true' : 'false' }}">
                    <i class="bi bi-box-seam fs-5"></i>
                    <span class="menu-text">Product</span>
                    <i class="bi bi-chevron-down ms-auto submenu-chevron menu-text"></i>
                </button>

                <div class="collapse {{ $productMenuOpen ? 'show' : '' }}" id="productMenu">
                    <a href="{{ route('shapes.index') }}" class="nav-link submenu-link d-flex align-items-center gap-2 {{ request()->routeIs('shapes.*') ? 'active' : '' }}">
                        <i class="bi bi-diamond fs-5"></i>
                        <span class="menu-text">Shapes</span>
                    </a>
                    <a href="{{ route('colors.index') }}" class="nav-link submenu-link d-flex align-items-center gap-2 {{ request()->routeIs('colors.*') ? 'active' : '' }}">
                        <i class="bi bi-palette fs-5"></i>
                        <span class="menu-text">Colors</span>
                    </a>
                    <a href="{{ route('clarities.index') }}" class="nav-link submenu-link d-flex align-items-center gap-2 {{ request()->routeIs('clarities.*') ? 'active' : '' }}">
                        <i class="bi bi-eye fs-5"></i>
                        <span class="menu-text">Clarities</span>
                    </a>
                    <a href="{{ route('cuts.index') }}" class="nav-link submenu-link d-flex align-items-center gap-2 {{ request()->routeIs('cuts.*') ? 'active' : '' }}">
                        <i class="bi bi-scissors fs-5"></i>
                        <span class="menu-text">Cuts</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="nav-link submenu-link d-flex align-items-center gap-2 {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="bi bi-list-ul fs-5"></i>
                        <span class="menu-text">Product List</span>
                    </a>
                </div>
            </div>        </div>
    </div>
</aside>
