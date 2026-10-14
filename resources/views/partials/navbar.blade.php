<nav class="navbar" id="siteNavbar">
    {{-- Logo --}}
    <div class="navbar-logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="WeSellGaris" class="logo" />
        </a>
    </div>

    {{-- Desktop Navigation (centre) --}}
    <div class="nav-links">
        <a href="{{ url('/vehicles') }}">Vehicles</a>

        @auth
            <a href="{{ route('cars.create') }}">Sell Your Car</a>
        @endauth
        @guest
            <a href="{{ url('/sell') }}">Sell Your Car</a>
        @endguest

        <a href="{{ url('/about') }}">About Us</a>
        <a href="{{ url('/contact') }}">Contact Us</a>
        <a href="{{ url('/faqs') }}">FAQs</a>

        {{-- ADMIN MANAGEMENT LINK - Only visible to admin users --}}
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ url('/admin/dashboard') }}" class="admin-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 5px;">
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                        <circle cx="12" cy="12" r="4"/>
                    </svg>
                    Management
                </a>
            @endif
        @endauth
    </div>

    {{-- Right side: search, CTA, user --}}
    <div class="nav-actions">
        <a href="{{ url('/vehicles') }}#js-search" class="nav-search" aria-label="Search vehicles" title="Search vehicles">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        </a>

        <a href="{{ url('/vehicles') }}" class="nav-cta">View All Vehicles →</a>

        {{-- User Dropdown --}}
        @auth
        <div class="dropdown" onclick="toggleDropdown()">
            <div class="user-profile">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="dropdown-arrow">▼</span>
            </div>

            <div class="dropdown-menu">
                <a href="{{ url('/profile') }}">Profile</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ url('/admin/dashboard') }}" class="admin-dropdown-item">
                        <span class="admin-badge">Admin</span> Dashboard
                    </a>
                    <a href="{{ route('admin.hero-slides.index') }}" class="admin-dropdown-item">
                        <span class="admin-badge">Admin</span> Home Slides
                    </a>
                @endif
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
        @endauth
    </div>

    {{-- Hamburger Button for Small Screens --}}
    <button class="menu-btn" onclick="toggleSidebar(true)" aria-label="Open menu" aria-controls="sidebar">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
</nav>

{{-- Sidebar Overlay --}}
<div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar(false)"></div>

{{-- Sidebar for Small Screens --}}
<div id="sidebar" class="sidebar" aria-hidden="true">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="{{ url('/') }}" onclick="toggleSidebar(false)">
                <img src="{{ asset('images/logo.png') }}" alt="WeSellGaris" class="logo" />
            </a>
        </div>
        <button class="close-btn" onclick="toggleSidebar(false)" aria-label="Close menu">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    <div class="sidebar-content">
        <a href="{{ url('/vehicles') }}" onclick="toggleSidebar(false)">Vehicles</a>

        @auth
            <a href="{{ route('cars.create') }}" onclick="toggleSidebar(false)">Sell Your Car</a>
        @endauth
        @guest
            <a href="{{ url('/sell') }}" onclick="toggleSidebar(false)">Sell Your Car</a>
        @endguest

        <a href="{{ url('/about') }}" onclick="toggleSidebar(false)">About Us</a>
        <a href="{{ url('/contact') }}" onclick="toggleSidebar(false)">Contact Us</a>
        <a href="{{ url('/faqs') }}" onclick="toggleSidebar(false)">FAQs</a>

        {{-- ADMIN MANAGEMENT LINK IN SIDEBAR --}}
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ url('/admin/dashboard') }}" class="admin-link-sidebar" onclick="toggleSidebar(false)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                        <circle cx="12" cy="12" r="4"/>
                    </svg>
                    Management Dashboard
                    <span class="admin-badge-sidebar">Admin</span>
                </a>
                <a href="{{ route('admin.hero-slides.index') }}" class="admin-link-sidebar" onclick="toggleSidebar(false)">
                    Home Slides
                    <span class="admin-badge-sidebar">Admin</span>
                </a>
            @endif
        @endauth

        <a href="{{ url('/vehicles') }}" class="sidebar-cta" onclick="toggleSidebar(false)">View All Vehicles →</a>

        @auth
        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span>{{ auth()->user()->name }}</span>
                @if(auth()->user()->is_admin)
                    <span class="admin-tag">Admin</span>
                @endif
            </div>
            <a href="{{ url('/profile') }}" onclick="toggleSidebar(false)">Profile</a>
            @if(auth()->user()->is_admin)
                <a href="{{ url('/admin/dashboard') }}" onclick="toggleSidebar(false)" class="sidebar-admin-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
                        <circle cx="12" cy="12" r="4"/>
                    </svg>
                    Admin Dashboard
                </a>
            @endif
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
        @endauth
    </div>

    <div class="sidebar-footer">
        <p>© {{ date('Y') }} WeSellGaris. All rights reserved.</p>
    </div>
</div>

<script>
    function toggleSidebar(open) {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (!sidebar || !overlay) return;
        sidebar.classList.toggle('open', open);
        overlay.classList.toggle('active', open);
        sidebar.setAttribute('aria-hidden', open ? 'false' : 'true');
        document.body.style.overflow = open ? 'hidden' : '';
    }

    function toggleDropdown() {
        const dropdown = document.querySelector('.dropdown');
        if (dropdown) {
            dropdown.classList.toggle('open');
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('.dropdown');
        if (dropdown && !dropdown.contains(event.target)) {
            dropdown.classList.remove('open');
        }
    });

    // Close sidebar with Escape, and if the window grows to desktop size
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') toggleSidebar(false);
    });
    window.addEventListener('resize', function() {
        if (window.innerWidth > 900) toggleSidebar(false);
    });
</script>

<style>
    /* ═══════════ NAVBAR (big screens) ═══════════ */
    nav.navbar {
        position: sticky;
        top: 0;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        height: auto;
        min-height: 68px;
        padding: 6px 32px;
        background: #FCFAF7;
        border-bottom: 1px solid #EAD9C6;
        box-shadow: none;
        overflow: visible;
        font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif;
    }

    .navbar-logo {
        display: flex;
        align-items: center;
        flex-shrink: 0;
        overflow: visible;
    }

    .logo {
        height: 54px;
        width: auto;
        max-width: none;
        display: block;
        object-fit: contain;
        transform: none;
    }

    nav.navbar .nav-links {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 38px;
        flex: 1;
        margin: 0;
        padding: 0;
    }

    nav.navbar .nav-links > a:not(.admin-link) {
        position: relative;
        color: #3A2920;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        padding: 8px 0;
        background: none;
        transition: color .2s ease;
    }

    nav.navbar .nav-links > a:not(.admin-link)::after {
        content: "";
        position: absolute;
        left: 0; right: 0; bottom: 2px;
        height: 2px;
        background: #D94F16;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .25s ease;
    }

    nav.navbar .nav-links > a:not(.admin-link):hover { color: #D94F16; }
    nav.navbar .nav-links > a:not(.admin-link):hover::after { transform: scaleX(1); }

    .nav-actions {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-shrink: 0;
    }

    .nav-search {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #3A2920;
        transition: background .2s ease, color .2s ease;
    }
    .nav-search:hover { background: #F5EBDD; color: #D94F16; }

    .nav-cta {
        display: inline-flex;
        align-items: center;
        background: #D94F16;
        color: #fff !important;
        padding: 12px 24px;
        border-radius: 100px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
    }
    .nav-cta:hover {
        background: #B94314;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(217, 79, 22, .28);
    }

    /* Hamburger: hidden on big screens */
    .menu-btn {
        display: none;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        background: #F5EBDD;
        border: 1px solid #EAD9C6;
        border-radius: 10px;
        color: #3A2920;
        cursor: pointer;
        padding: 0;
        font-size: 0;
    }

    /* ═══════════ USER DROPDOWN / ADMIN ═══════════ */
    .dropdown { position: relative; cursor: pointer; }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0.8rem;
        background: #3A2920;
        border-radius: 20px;
        color: #fff;
        transition: all 0.3s ease;
    }
    .user-profile:hover { transform: translateY(-1px); box-shadow: 0 4px 8px rgba(58, 41, 32, 0.3); }

    .user-avatar {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: #F5C400;
        color: #3A2920;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.8rem;
    }
    .user-name { font-weight: 500; font-size: 0.9rem; }
    .dropdown-arrow { font-size: 0.7rem; transition: transform 0.2s ease; }
    .dropdown.open .dropdown-arrow { transform: rotate(180deg); }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        background: #fff;
        border: 1px solid #EAD9C6;
        border-radius: 10px;
        box-shadow: 0 8px 24px rgba(58, 41, 32, 0.15);
        min-width: 180px;
        z-index: 1100;
        overflow: hidden;
    }
    .dropdown.open .dropdown-menu { display: block; }

    .dropdown-menu a {
        display: block;
        padding: 0.8rem 1.2rem;
        color: #3A2920;
        text-decoration: none;
        transition: background 0.2s ease;
        border: none;
        font-size: 0.9rem;
    }
    .dropdown-menu a:hover { background: #F5EBDD; }

    .admin-link {
        background: #3A2920;
        color: #fff !important;
        padding: 0.4rem 1rem !important;
        border-radius: 20px !important;
        display: inline-flex;
        align-items: center;
        font-weight: 500;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.3s ease;
        margin: 0 4px;
    }
    .admin-link:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(58, 41, 32, 0.3); }
    .admin-link svg { stroke: #F5C400; }

    .admin-dropdown-item { display: flex; align-items: center; justify-content: space-between; gap: 8px; }

    .admin-badge {
        background: #D94F16; color: #fff;
        padding: 2px 8px; border-radius: 12px;
        font-size: 0.7rem; font-weight: 600; letter-spacing: 0.5px;
    }

    .logout-btn {
        width: 100%;
        padding: 0.8rem 1.2rem;
        background: none;
        border: none;
        color: #B94314;
        cursor: pointer;
        text-align: left;
        transition: background 0.2s ease;
        font-size: 0.9rem;
        font-family: inherit;
    }
    .logout-btn:hover { background: #FDF1EA; }

    /* ═══════════ SIDEBAR (small screens) ═══════════ */
    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(26, 20, 16, .55);
        opacity: 0;
        visibility: hidden;
        transition: opacity .3s ease, visibility .3s ease;
        z-index: 1998;
    }
    .sidebar-overlay.active { opacity: 1; visibility: visible; }

    .sidebar {
        position: fixed;
        top: 0; left: 0; bottom: 0;
        width: 300px;
        max-width: 86vw;
        background: #FCFAF7;
        z-index: 1999;
        display: flex;
        flex-direction: column;
        transform: translateX(-100%);
        transition: transform .3s ease;
        box-shadow: 8px 0 30px rgba(26, 20, 16, .2);
        font-family: 'DM Sans', ui-sans-serif, system-ui, sans-serif;
        overflow: hidden;
    }
    .sidebar.open { transform: translateX(0); }

    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 16px;
        border-bottom: 1px solid #EAD9C6;
        background: #F5EBDD;
    }
    .sidebar-logo .logo { height: 46px; width: auto; }

    .close-btn {
        width: 38px; height: 38px;
        display: flex; align-items: center; justify-content: center;
        background: #fff;
        border: 1px solid #EAD9C6;
        border-radius: 10px;
        color: #3A2920;
        cursor: pointer;
        padding: 0;
        font-size: 0;
    }
    .close-btn:hover { background: #3A2920; color: #fff; }

    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .sidebar-content > a:not(.admin-link-sidebar):not(.sidebar-cta) {
        display: block;
        padding: 13px 14px;
        color: #3A2920;
        font-size: 15px;
        font-weight: 500;
        text-decoration: none;
        border-radius: 10px;
        border-left: 3px solid transparent;
        transition: background .2s ease, border-color .2s ease, color .2s ease;
    }
    .sidebar-content > a:not(.admin-link-sidebar):not(.sidebar-cta):hover {
        background: #F5EBDD;
        border-left-color: #D94F16;
        color: #D94F16;
    }

    .sidebar-cta {
        display: block;
        text-align: center;
        margin-top: 14px;
        background: #D94F16;
        color: #fff !important;
        padding: 13px 16px;
        border-radius: 100px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: background .2s ease;
    }
    .sidebar-cta:hover { background: #B94314; }

    .admin-link-sidebar {
        background: #3A2920 !important;
        color: #fff !important;
        margin: 8px 0 !important;
        border-radius: 10px !important;
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        padding: 0.8rem 1rem !important;
        text-decoration: none;
        font-size: 14px;
    }
    .admin-link-sidebar:hover { transform: translateX(4px); }
    .admin-link-sidebar svg { stroke: #F5C400; }

    .admin-badge-sidebar {
        background: rgba(255, 255, 255, 0.2); color: #fff;
        padding: 2px 8px; border-radius: 12px;
        font-size: 0.7rem; font-weight: 600;
    }

    .admin-tag {
        background: #D94F16; color: #fff;
        padding: 2px 8px; border-radius: 12px;
        font-size: 0.65rem; font-weight: 600;
        margin-left: auto;
    }

    .sidebar-admin-link {
        display: flex !important;
        align-items: center;
        gap: 8px;
        background: #F5EBDD;
        margin-top: 4px;
        border-left: 3px solid #D94F16;
    }
    .sidebar-admin-link:hover { background: #EAD9C6; }
    .sidebar-admin-link svg { stroke: #D94F16; }

    .sidebar-user { margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #EAD9C6; }

    .sidebar-user-info {
        display: flex; align-items: center; gap: 0.6rem;
        padding: 0.8rem;
        background: #3A2920; color: #fff;
        border-radius: 10px;
        margin-bottom: 0.8rem;
        font-weight: 500;
    }

    .sidebar-user a {
        display: block;
        padding: 0.8rem 1rem;
        color: #3A2920;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 0.4rem;
        font-size: 0.9rem;
    }
    .sidebar-user a:hover { background: #F5EBDD; }

    .sidebar-user .logout-btn {
        width: 100%;
        padding: 0.8rem 1rem;
        border-radius: 8px;
    }

    .sidebar-footer {
        padding: 14px 18px;
        border-top: 1px solid #EAD9C6;
        background: #F5EBDD;
        font-size: 12px;
        color: #8A7A6E;
        text-align: center;
    }
    .sidebar-footer p { margin: 0; }

    /* ═══════════ RESPONSIVE ═══════════ */
    @media (max-width: 1100px) {
        nav.navbar .nav-links { gap: 24px; }
        nav.navbar { padding: 6px 20px; }
    }

    /* Small screens: links + CTA move into the sidebar */
    @media (max-width: 900px) {
        nav.navbar .nav-links,
        .nav-actions { display: none !important; }
        .menu-btn { display: flex; }
        nav.navbar { padding: 6px 16px; min-height: 62px; }
        .logo { height: 46px; }
    }
</style>
