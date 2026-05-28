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

            <a href="{{ route('pages.index') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('pages.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text fs-5"></i>
                <span class="menu-text">Static Pages</span>
            </a>

            @php
                $postMenuOpen = request()->routeIs('post-categories.*') || request()->routeIs('posts.*');
            @endphp

            <div class="sidebar-dropdown">
                <button type="button"
                    class="nav-link sidebar-dropdown-toggle d-flex align-items-center gap-2 w-100 {{ $postMenuOpen ? '' : 'collapsed' }} {{ $postMenuOpen ? 'active' : '' }}"
                    data-bs-toggle="collapse"
                    data-bs-target="#postMenu"
                    aria-expanded="{{ $postMenuOpen ? 'true' : 'false' }}">
                    <i class="bi bi-journal-text fs-5"></i>
                    <span class="menu-text">Posts</span>
                    <i class="bi bi-chevron-down ms-auto submenu-chevron menu-text"></i>
                </button>

                <div class="collapse {{ $postMenuOpen ? 'show' : '' }}" id="postMenu">
                    <a href="{{ route('post-categories.index') }}" class="nav-link submenu-link d-flex align-items-center gap-2 {{ request()->routeIs('post-categories.*') ? 'active' : '' }}">
                        <i class="bi bi-tags fs-5"></i>
                        <span class="menu-text">Post Category</span>
                    </a>
                    <a href="{{ route('posts.index') }}" class="nav-link submenu-link d-flex align-items-center gap-2 {{ request()->routeIs('posts.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-richtext fs-5"></i>
                        <span class="menu-text">Post List</span>
                    </a>
                </div>
            </div>

            @php
                $newsMenuOpen = request()->routeIs('news-categories.*') || request()->routeIs('news.*');
            @endphp

            <div class="sidebar-dropdown">
                <button type="button"
                    class="nav-link sidebar-dropdown-toggle d-flex align-items-center gap-2 w-100 {{ $newsMenuOpen ? '' : 'collapsed' }} {{ $newsMenuOpen ? 'active' : '' }}"
                    data-bs-toggle="collapse"
                    data-bs-target="#newsMenu"
                    aria-expanded="{{ $newsMenuOpen ? 'true' : 'false' }}">
                    <i class="bi bi-megaphone fs-5"></i>
                    <span class="menu-text">News & Events</span>
                    <i class="bi bi-chevron-down ms-auto submenu-chevron menu-text"></i>
                </button>

                <div class="collapse {{ $newsMenuOpen ? 'show' : '' }}" id="newsMenu">
                    <a href="{{ route('news-categories.index') }}" class="nav-link submenu-link d-flex align-items-center gap-2 {{ request()->routeIs('news-categories.*') ? 'active' : '' }}">
                        <i class="bi bi-bookmarks fs-5"></i>
                        <span class="menu-text">News Category</span>
                    </a>
                    <a href="{{ route('news.index') }}" class="nav-link submenu-link d-flex align-items-center gap-2 {{ request()->routeIs('news.*') ? 'active' : '' }}">
                        <i class="bi bi-newspaper fs-5"></i>
                        <span class="menu-text">News List</span>
                    </a>
                </div>
            </div>

            @php
                $enquiryMenuOpen = request()->routeIs('enquiries.product.*') || request()->routeIs('enquiries.contact.*');
            @endphp

            <div class="sidebar-dropdown">
                <button type="button"
                    class="nav-link sidebar-dropdown-toggle d-flex align-items-center gap-2 w-100 {{ $enquiryMenuOpen ? '' : 'collapsed' }} {{ $enquiryMenuOpen ? 'active' : '' }}"
                    data-bs-toggle="collapse"
                    data-bs-target="#enquiryMenu"
                    aria-expanded="{{ $enquiryMenuOpen ? 'true' : 'false' }}">
                    <i class="bi bi-envelope-paper fs-5"></i>
                    <span class="menu-text">Enquiries</span>
                    <i class="bi bi-chevron-down ms-auto submenu-chevron menu-text"></i>
                </button>

                <div class="collapse {{ $enquiryMenuOpen ? 'show' : '' }}" id="enquiryMenu">
                    <a href="{{ route('enquiries.product.index') }}" class="nav-link submenu-link d-flex align-items-center gap-2 {{ request()->routeIs('enquiries.product.*') ? 'active' : '' }}">
                        <i class="bi bi-gem fs-5"></i>
                        <span class="menu-text">Product Enquiries</span>
                    </a>
                    <a href="{{ route('enquiries.contact.index') }}" class="nav-link submenu-link d-flex align-items-center gap-2 {{ request()->routeIs('enquiries.contact.*') ? 'active' : '' }}">
                        <i class="bi bi-chat-left-text fs-5"></i>
                        <span class="menu-text">Contact Enquiries</span>
                    </a>
                </div>
            </div>

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
