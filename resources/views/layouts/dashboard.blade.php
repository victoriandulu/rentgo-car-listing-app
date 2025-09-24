@extends('layouts.app')
@section('content')
<div class="dashboard-container">
    <!-- Navigation -->
    {{-- <nav class="dashboard-nav">
        <div class="nav-content">
            <h1 class="app-name">RENT-GO</h1>
            <span class="welcome-text">Welcome, {{ auth()->user()->first_name ?? 'User' }}!</span>
        </div>
    </nav> --}}

    <!-- Main Content -->
    <main class="dashboard-main">
        <div class="content-wrapper">
            <!-- Navigation Menu -->
            <div class="nav-menu">
                <a href="{{ route('cars.create') }}"
                   class="nav-item {{ request()->routeIs('cars.create') ? 'active' : '' }}">
                    <i class="fas fa-car"></i>
                    List Your Car
                </a>
                <a href="{{ route('cars.my') }}"
                   class="nav-item {{ request()->routeIs('cars.my') ? 'active' : '' }}">
                    <i class="fas fa-list"></i>
                    Listed Cars
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    My Profile
                </a>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                @yield('dashboard-content')
            </div>
        </div>
    </main>
</div>

<style>
:root {
    --rentgo-red: #e53e3e;
    --rentgo-yellow: #ffd700;
    --rentgo-dark: #4a5568;
    --rentgo-light-red: #fed7d7;
    --shadow-soft: 0 10px 30px rgba(229, 62, 62, 0.1);
    --transition: all 0.3s ease;
}

.dashboard-container {
    min-height: 100vh;
    display: flex;
    margin-top: 70px;
    flex-direction: column;
    margin-bottom: 100px; /* Footer margin */
}

.dashboard-nav {
    background: var(--rentgo-dark);
    color: white;
    padding: 1rem 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.nav-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.app-name {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--rentgo-yellow);
}

.welcome-text {
    font-size: 0.9rem;
    opacity: 0.8;
}

.dashboard-main {
    flex: 1;
    padding: 2rem;
}

.content-wrapper {
    max-width: 1200px;
    margin: 0 auto;
}

.nav-menu {
    display: flex;
    justify-content: center;
    gap: 1rem;
    background: white;
    border-radius: 20px;
    padding: 1rem;
    box-shadow: var(--shadow-soft);
    margin-bottom: 2rem;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 15px;
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
    color: var(--rentgo-dark);
}

.nav-item:hover {
    background: var(--rentgo-light-red);
    color: var(--rentgo-red);
    text-decoration: none;
}

.nav-item.active {
    background: var(--rentgo-red);
    color: white;
    box-shadow: var(--shadow-soft);
}

.content-area {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--shadow-soft);
}

@media (max-width: 768px) {
    .dashboard-main {
        padding: 1rem;
    }

    .nav-menu {
        flex-direction: column;
        align-items: center;
    }

    .nav-item {
        width: 100%;
        justify-content: center;
    }

    .nav-content {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }
}
</style>
@endsection
