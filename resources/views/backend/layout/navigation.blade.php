<nav class="navbar navbar-expand-lg topbar px-3">
            <button id="sidebarToggle" class="btn btn-outline-secondary btn-sm" type="button" aria-label="Toggle sidebar">
                <i class="bi bi-list fs-5"></i>
            </button>
            <span class="navbar-brand ms-2 mb-0 h1 fs-6">@yield('page_heading', 'Dashboard')</span>

            <div class="ms-auto dropdown">
                <button class="btn btn-light border d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @auth
                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D6EFD&color=fff"
                            alt="Profile"
                            width="32"
                            height="32"
                            class="rounded-circle"
                        >
                        <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                    @else
                        <i class="bi bi-person-circle"></i>
                    @endauth
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person me-2"></i>Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>