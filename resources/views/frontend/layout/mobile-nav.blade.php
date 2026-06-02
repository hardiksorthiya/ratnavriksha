<div class="offcanvas offcanvas-start hp-mobile-nav" tabindex="-1" id="hpMobileNav"
    aria-labelledby="hpMobileNavLabel">
    <div class="offcanvas-header hp-mobile-nav-header">
        <span class="hp-mobile-nav-label" id="hpMobileNavLabel">Navigation</span>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close menu"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav hp-mobile-menu">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('diamonds') ? 'active' : '' }}" href="{{ route('diamonds') }}">Diamonds</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('jewellery') ? 'active' : '' }}" href="{{ route('jewellery') }}">Jewellery</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('news-events.*') ? 'active' : '' }}" href="{{ route('news-events.index') }}">News & Events</a>
            </li>
            <li class="nav-item hp-mobile-menu-contact">
                <a href="{{ route('contact') }}" class="btn hp-contact-btn w-100 {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
            </li>
        </ul>
    </div>
</div>
