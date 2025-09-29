@extends('layouts.app')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}</p>
    </div>

    {{-- Clickable Stats Grid --}}
    <div class="stats-grid">
        <a href="#vehicles-section" class="stat-card vehicles">
            <h3>Total Vehicles</h3>
            <div class="stat-number">{{ $cars->count() }}</div>
        </a>

        <a href="#users-section" class="stat-card users">
            <h3>Users</h3>
            <div class="stat-number">{{ $users->count() }}</div>
        </a>

        <a href="#reports-section" class="stat-card reports">
            <h3>Reports Sold</h3>
            <div class="stat-number">{{ $reports->count() }}</div>
        </a>

        {{-- ✅ New "Sell a Car" Card --}}
        <a href="{{ route('cars.create') }}" class="stat-card sell">
            <h3>Sell a Car</h3>
            <div class="stat-number">+</div>
        </a>
    </div>

    <div class="tables-section">
        {{-- Users --}}
        <div id="users-section" class="table-container">
            <h2>Users Management</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge admin">Admin</span>
                                @elseif($user->is_verified)
                                    <span class="badge verified">Verified</span>
                                @else
                                    <span class="badge unverified">Unverified</span>
                                @endif
                            </td>
                            <td class="actions">
                                @if(!$user->is_admin)
                                    @if($user->is_verified)
                                        <a href="{{ route('admin.users.unverify', $user->id) }}" class="btn-action unverify">Unverify</a>
                                    @else
                                        <a href="{{ route('admin.users.verify', $user->id) }}" class="btn-action verify">Verify</a>
                                    @endif
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action delete" onclick="return confirm('Delete user?')">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Vehicles --}}
        <div id="vehicles-section" class="table-container">
            <h2>Vehicles Management</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Vehicle</th>
                            <th>Year</th>
                            <th>Owner</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $car)
                        <tr>
                            <td>{{ $car->name }}</td>
                            <td>{{ $car->year }}</td>
                            <td>{{ $car->user->name ?? 'N/A' }}</td>
                            <td class="actions">
                                <a href="{{ route('cars.edit', $car->id) }}" class="btn-action edit">Edit</a>
                                <form action="{{ route('admin.cars.delete', $car->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action delete" onclick="return confirm('Delete car?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Reports --}}
        <div id="reports-section" class="table-container">
            <h2>Reports Sold</h2>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Car</th>
                            <th>Price</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $car)
                        <tr>
                            <td>{{ $car->name }}</td>
                            <td>KSh {{ number_format($car->price, 2) }}</td>
                            <td>{{ $car->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="no-data">No reports sold yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    max-width: 1200px;
    margin-bottom: 70px;
    margin-top: 70px;
    padding: 20px;
}

.dashboard-header {
    background: linear-gradient(45deg, #ffd700, #ff4444);
    color: white;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    text-align: center;
}

.dashboard-header h1 {
    font-size: 2.5rem;
    margin: 0;
    font-weight: 700;
}

.dashboard-header p {
    font-size: 1.1rem;
    margin: 10px 0 0 0;
    opacity: 0.9;
}

/* ✅ Clickable stat cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    display: block;
    background: white;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-top: 4px solid;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}

.stat-card.vehicles { border-top-color: #ffd700; }
.stat-card.users { border-top-color: #ff4444; }
.stat-card.reports { border-top-color: #28a745; }
.stat-card.sell { border-top-color: #007bff; }

.stat-card h3 {
    color: #666;
    font-size: 14px;
    margin: 0 0 10px 0;
    text-transform: uppercase;
    font-weight: 600;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #333;
}

/* Tables */
.tables-section {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.table-container {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.table-container h2 {
    background: #f8f9fa;
    padding: 20px;
    margin: 0;
    color: #333;
    font-size: 1.3rem;
    border-bottom: 1px solid #eee;
}

.table-wrapper { overflow-x: auto; }

table { width: 100%; border-collapse: collapse; }

thead {
    background: linear-gradient(45deg, #ffd700, #ff4444);
    color: white;
}

th, td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

tbody tr:hover { background: #f8f9fa; }

.badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}
.badge.admin { background: #6f42c1; color: white; }
.badge.verified { background: #28a745; color: white; }
.badge.unverified { background: #ffc107; color: #212529; }

.actions { display: flex; gap: 8px; align-items: center; }
.btn-action { padding: 6px 12px; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; text-transform: uppercase; }
.btn-action.verify { background: #28a745; color: white; }
.btn-action.unverify { background: #ffc107; color: #212529; }
.btn-action.edit { background: #007bff; color: white; }
.btn-action.delete { background: #dc3545; color: white; }

.inline { display: inline; }
.no-data { text-align: center; color: #666; font-style: italic; }

@media (max-width: 768px) {
    .stats-grid { grid-template-columns: 1fr; }
    .actions { flex-direction: column; align-items: stretch; }
}
</style>
@endsection
