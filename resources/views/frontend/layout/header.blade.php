<header class="hp-header">
    <nav class="navbar navbar-expand-lg p-0">
        <div class="container hp-header-inner">
            <button class="navbar-toggler hp-toggler d-lg-none" type="button"
                data-bs-toggle="offcanvas" data-bs-target="#hpMobileNav"
                aria-controls="hpMobileNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand hp-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo_white.png') }}" alt="Ratnavriksha" class="hp-brand-logo img-fluid"
                    width="100" height="100">
            </a>

            <div class="hp-navbar-desktop d-none d-lg-flex">
                <ul class="navbar-nav hp-menu-group hp-menu-group--left">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('diamonds') ? 'active' : '' }}" href="{{ route('diamonds') }}">Diamonds</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('jewellery') ? 'active' : '' }}" href="{{ route('jewellery') }}">Jewellery</a>
                    </li>
                </ul>

                <ul class="navbar-nav hp-menu-group hp-menu-group--right">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('news-events.*') ? 'active' : '' }}" href="{{ route('news-events.index') }}">News & Events</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('contact') }}" class="btn hp-contact-btn {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
