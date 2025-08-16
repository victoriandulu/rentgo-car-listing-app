<nav class="navbar">
    {{-- Logo (Visible on Big Screens) --}}
    <div class="navbar-logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/rent-go.jpg') }}" alt="Logo" class="logo" />
        </a>
    </div>

    {{-- Hamburger Button (Visible on Small Screens) --}}
    <button class="menu-btn" onclick="toggleSidebar(true)">
        ☰
    </button>

    {{-- Desktop Navigation --}}
    <div class="nav-links">
        <div class="dropdown"
             onmouseover="toggleDropdown(true)"
             onmouseout="toggleDropdown(false)">
            <a href="{{ url('/vehicles') }}">Vehicles</a>
        </div>

        <a href="{{ url('/sell') }}">Sell Your Car</a>
        <a href="{{ url('/about') }}">About Us</a>
        <a href="{{ url('/contact') }}">Contact Us</a>
        <a href="{{ url('/faqs') }}">FAQs</a>
    </div>
</nav>

{{-- Sidebar Overlay --}}
<div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar(false)"></div>

{{-- Sidebar for Small Screens --}}
<div id="sidebar" class="sidebar">
    {{-- Sidebar Header with Logo and Close Button --}}
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="{{ url('/') }}" onclick="toggleSidebar(false)">
                <img src="{{ asset('images/rent-go.jpg') }}" alt="Logo" class="logo" />
            </a>
        </div>
        <button class="close-btn" onclick="toggleSidebar(false)">
            ✖
        </button>
    </div>

    {{-- Sidebar Content --}}
    <div class="sidebar-content">
        <div class="dropdown">
            <a href="{{ url('/vehicles') }}">Vehicles</a>
        </div>

        <a href="{{ url('/sell') }}" onclick="toggleSidebar(false)">Sell Your Car</a>
        <a href="{{ url('/about') }}" onclick="toggleSidebar(false)">About Us</a>
        <a href="{{ url('/contact') }}" onclick="toggleSidebar(false)">Contact Us</a>
        <a href="{{ url('/faqs') }}" onclick="toggleSidebar(false)">FAQs</a>
    </div>

    {{-- Sidebar Footer --}}
    <div class="sidebar-footer">
        <p>© {{ date('Y') }} Rent-Go. All rights reserved.</p>
    </div>
</div>

{{-- Simple JavaScript for Sidebar Toggle --}}
<script>
    function toggleSidebar(open) {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if(open) {
            sidebar.classList.add('open');
            overlay.classList.add('active');
        } else {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }
    }

    function toggleDropdown(open) {
        const dropdown = document.querySelector('.dropdown');
        if(open) {
            dropdown.classList.add('open');
        } else {
            dropdown.classList.remove('open');
        }
    }
</script>
