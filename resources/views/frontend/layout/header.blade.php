<header class="hp-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container hp-header-inner">
                <button class="navbar-toggler hp-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#hpNavbar" aria-controls="hpNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-space-between" id="hpNavbar">
                    <ul class="navbar-nav hp-menu-group">
                        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Diamonds</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Create Your Design</a></li>

                    </ul>

                    <a class="navbar-brand hp-brand" href="{{ route('home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Ratnavriksha" class="img-fluid" width="78" height="100">
                    </a>

                    <ul class="navbar-nav hp-menu-group">
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">News & Events</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Blogs</a></li>
                        <li class="nav-item"><a href="{{ route('contact') }}" class="btn hp-contact-btn">Contact Us</a></li>
                    </ul>
                </div>

                
            </div>
        </nav>
    </header>