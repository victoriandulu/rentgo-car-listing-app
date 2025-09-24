<nav class="navbar">
    {{-- Logo --}}
    <div class="navbar-logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/rent-go.jpg') }}" alt="Logo" class="logo" />
        </a>
    </div>

    {{-- Hamburger Button for Small Screens --}}
    <button class="menu-btn" onclick="toggleSidebar(true)">
        ☰
    </button>

    {{-- Desktop Navigation --}}
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
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>

{{-- Sidebar Overlay --}}
<div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar(false)"></div>

{{-- Sidebar for Small Screens --}}
<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="{{ url('/') }}" onclick="toggleSidebar(false)">
                <img src="{{ asset('images/rent-go.jpg') }}" alt="Logo" class="logo" />
            </a>
        </div>
        <button class="close-btn" onclick="toggleSidebar(false)">✖</button>
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

        @auth
        <div class="sidebar-user">
            <div class="sidebar-user-info">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <a href="{{ url('/profile') }}" onclick="toggleSidebar(false)">Profile</a>
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
        @endauth
    </div>

    <div class="sidebar-footer">
        <p>© {{ date('Y') }} Rent-Go. All rights reserved.</p>
    </div>
</div>

<script>
    function toggleSidebar(open) {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('open', open);
        overlay.classList.toggle('active', open);
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
</script>

<style>
    /* User Profile Dropdown */
    .dropdown {
        position: relative;
        cursor: pointer;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0.8rem;
        background: linear-gradient(135deg, #dc2626 0%, #fbbf24 100%);
        border-radius: 20px;
        color: white;
        transition: all 0.3s ease;
    }

    .user-profile:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3);
    }

    .user-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .user-name {
        font-weight: 500;
        font-size: 0.9rem;
    }

    .dropdown-arrow {
        font-size: 0.7rem;
        transition: transform 0.2s ease;
    }

    .dropdown.open .dropdown-arrow {
        transform: rotate(180deg);
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        top: calc(100% + 5px);
        right: 0;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 160px;
        z-index: 1000;
        overflow: hidden;
    }

    .dropdown.open .dropdown-menu {
        display: block;
    }

    .dropdown-menu a {
        display: block;
        padding: 0.8rem 1.2rem;
        color: #374151;
        text-decoration: none;
        transition: background 0.2s ease;
        border: none;
        font-size: 0.9rem;
    }

    .dropdown-menu a:hover {
        background: #f3f4f6;
    }

    .logout-btn {
        width: 100%;
        padding: 0.8rem 1.2rem;
        background: none;
        border: none;
        color: #dc2626;
        cursor: pointer;
        text-align: left;
        transition: background 0.2s ease;
        font-size: 0.9rem;
    }

    .logout-btn:hover {
        background: #fef2f2;
    }

    /* Sidebar User */
    .sidebar-user {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .sidebar-user-info {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.8rem;
        background: linear-gradient(135deg, #dc2626 0%, #fbbf24 100%);
        color: white;
        border-radius: 8px;
        margin-bottom: 0.8rem;
        font-weight: 500;
    }

    .sidebar-user a {
        display: block;
        padding: 0.8rem 1rem;
        color: #374151;
        text-decoration: none;
        border-radius: 6px;
        margin-bottom: 0.4rem;
        font-size: 0.9rem;
    }

    .sidebar-user a:hover {
        background: #f3f4f6;
    }

    .sidebar-user .logout-btn {
        width: 100%;
        padding: 0.8rem 1rem;
        background: none;
        border: none;
        color: #dc2626;
        cursor: pointer;
        text-align: left;
        border-radius: 6px;
        font-size: 0.9rem;
    }

    .sidebar-user .logout-btn:hover {
        background: #fef2f2;
    }
</style>
