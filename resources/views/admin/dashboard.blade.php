{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p>Welcome back! Here's an overview of your platform.</p>
    </div>

    <div class="stats-container">
        <a href="{{ route('admin.users.index') }}" class="stat-card users">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total Users</h3>
                <div class="stat-number">{{ $users->count() }}</div>
                <p class="stat-description">Registered users</p>
            </div>
        </a>

        <a href="{{ route('admin.cars.index') }}" class="stat-card cars">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"></path>
                    <circle cx="6.5" cy="16.5" r="2.5"></circle>
                    <circle cx="16.5" cy="16.5" r="2.5"></circle>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Total Cars</h3>
                <div class="stat-number">{{ $cars->count() }}</div>
                <p class="stat-description">Listed vehicles</p>
            </div>
        </a>

        <a href="{{ route('admin.verifications.index') }}" class="stat-card verifications">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Verifications</h3>
                <div class="stat-number">{{ $verifications->count() }}</div>
                <p class="stat-description">View verification Documents </p>
            </div>
        </a>

        <a href="{{ route('admin.reports.index') }}" class="stat-card reports">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Reports</h3>
                <div class="stat-number">{{ $reports->count() }}</div>
                <p class="stat-description">Generated reports</p>
            </div>
        </a>
    </div>


</div>

<style>
.admin-dashboard {
    padding: 30px;
    margin: 80px 20px 60px 20px;
    min-height: calc(100vh - 200px);
    background: linear-gradient(135deg, #fff5f5 0%, #fff9e6 100%);
}

.dashboard-header {
    margin-bottom: 40px;
    text-align: center;
}

.dashboard-header h1 {
    font-size: 36px;
    font-weight: 700;
    color: #dc2626;
    margin-bottom: 10px;
}

.dashboard-header p {
    font-size: 16px;
    color: #666;
}

.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 50px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 20px;
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #dc2626, #fbbf24);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(220, 38, 38, 0.15);
    border-color: #dc2626;
}

.stat-card.users .stat-icon {
    color: #dc2626;
}

.stat-card.cars .stat-icon {
    color: #f59e0b;
}

.stat-card.verifications .stat-icon {
    color: #dc2626;
}

.stat-card.reports .stat-icon {
    color: #fbbf24;
}

.stat-icon {
    flex-shrink: 0;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff5f5;
    border-radius: 12px;
}

.stat-content h3 {
    font-size: 14px;
    font-weight: 600;
    color: #666;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-number {
    font-size: 32px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 5px;
}

.stat-description {
    font-size: 13px;
    color: #9ca3af;
    margin: 0;
}

.quick-actions {
    background: white;
    border-radius: 16px;
    padding: 35px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.quick-actions h2 {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 25px;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.action-btn {
    background: linear-gradient(135deg, #dc2626 0%, #f59e0b 100%);
    color: white;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.2);
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(220, 38, 38, 0.3);
}

@media (max-width: 768px) {
    .admin-dashboard {
        padding: 20px;
        margin: 70px 10px 50px 10px;
    }

    .dashboard-header h1 {
        font-size: 28px;
    }

    .stats-container {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .stat-card {
        padding: 20px;
    }

    .stat-number {
        font-size: 28px;
    }

    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
