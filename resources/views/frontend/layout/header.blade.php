<header class="hp-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container hp-header-inner">
                <button class="navbar-toggler hp-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#hpNavbar" aria-controls="hpNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-space-between" id="hpNavbar">
                    <ul class="navbar-nav hp-menu-group">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('diamonds') ? 'active' : '' }}" href="{{ route('diamonds') }}">Diamonds</a></li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
                            </li>
                    </ul>

                    <a class="navbar-brand hp-brand" href="{{ route('home') }}">
                        <img src="{{ asset('images/logo_white.png') }}" alt="Ratnavriksha" class="img-fluid" width="100" height="100">
                    </a>

                    <ul class="navbar-nav hp-menu-group">
                        
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('news-events.*') ? 'active' : '' }}" href="{{ route('news-events.index') }}">News & Events</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}" href="{{ route('blogs.index') }}">Blogs</a></li>
                        <li class="nav-item">
                            <a href="{{ route('contact') }}" class="btn hp-contact-btn {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
                        </li>
                    </ul>
                </div>

                
            </div>
        </nav>
    </header>