{{-- resources/views/admin/users/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <div class="header-left">
            <a href="{{ route('admin.dashboard') }}" class="back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Back to Dashboard
            </a>
            <h1>User Management</h1>
            <p>Manage and verify platform users</p>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <div class="header-info">
                <h2>All Users</h2>
                <span class="count-badge">{{ $users->total() }} total</span>
            </div>
            <div class="search-box">
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}">
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.35-4.35"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">{{ substr($user->name, 0, 2) }}</div>
                                <span class="user-name">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_verified)
                                <span class="badge badge-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    Verified
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    </svg>
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge badge-admin">Admin</span>
                            @else
                                <span class="badge badge-user">User</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                @if(!$user->is_admin)
                                    @if(!$user->is_verified)
                                        <a href="{{ route('admin.users.verify', $user->id) }}" class="btn btn-verify">
                                            Verify
                                        </a>
                                    @else
                                        <a href="{{ route('admin.users.unverify', $user->id) }}" class="btn btn-unverify">
                                            Unverify
                                        </a>
                                    @endif
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">Protected</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="no-data">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <p>No users found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>
    </div>
</div>

<style>
.admin-page {
    padding: 30px;
    margin: 80px 20px 60px 20px;
    min-height: calc(100vh - 200px);
    background: linear-gradient(135deg, #fff5f5 0%, #fff9e6 100%);
}

.page-header {
    margin-bottom: 30px;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #666;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 15px;
    transition: color 0.3s ease;
}

.back-btn:hover {
    color: #dc2626;
}

.page-header h1 {
    font-size: 32px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 5px;
}

.page-header p {
    color: #666;
    font-size: 15px;
}

.content-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.card-header {
    padding: 25px 30px;
    border-bottom: 2px solid #f3f4f6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.header-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.header-info h2 {
    font-size: 20px;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.count-badge {
    background: linear-gradient(135deg, #dc2626, #f59e0b);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.search-box form {
    display: flex;
    align-items: center;
    position: relative;
}

.search-box input {
    width: 320px;
    padding: 12px 45px 12px 18px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.search-box input:focus {
    outline: none;
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.search-box button {
    position: absolute;
    right: 8px;
    background: linear-gradient(135deg, #dc2626, #f59e0b);
    border: none;
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.search-box button:hover {
    transform: scale(1.05);
}

.table-wrapper {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: #f9fafb;
}

.data-table th {
    padding: 18px 30px;
    text-align: left;
    font-size: 13px;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.data-table td {
    padding: 20px 30px;
    border-bottom: 1px solid #f3f4f6;
    font-size: 14px;
    color: #374151;
}

.data-table tbody tr {
    transition: background 0.2s ease;
}

.data-table tbody tr:hover {
    background: #fef2f2;
}

.user-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #dc2626, #f59e0b);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    text-transform: uppercase;
}

.user-name {
    font-weight: 600;
    color: #1f2937;
}

.badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.badge-admin {
    background: #dbeafe;
    color: #1e40af;
}

.badge-user {
    background: #e5e7eb;
    color: #374151;
}

.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-verify {
    background: #10b981;
    color: white;
}

.btn-verify:hover {
    background: #059669;
}

.btn-unverify {
    background: #fbbf24;
    color: #1f2937;
}

.btn-unverify:hover {
    background: #f59e0b;
}

.btn-delete {
    background: #ef4444;
    color: white;
}

.btn-delete:hover {
    background: #dc2626;
}

.text-muted {
    color: #9ca3af;
    font-size: 13px;
}

.no-data {
    text-align: center;
    padding: 60px 20px !important;
}

.no-data svg {
    color: #d1d5db;
    margin-bottom: 15px;
}

.no-data p {
    color: #9ca3af;
    font-size: 15px;
    margin: 0;
}

.pagination-wrapper {
    padding: 25px 30px;
    border-top: 2px solid #f3f4f6;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .admin-page {
        padding: 20px 10px;
        margin: 70px 10px 50px 10px;
    }

    .card-header {
        flex-direction: column;
        align-items: stretch;
    }

    .search-box input {
        width: 100%;
    }

    .data-table th,
    .data-table td {
        padding: 12px 15px;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        text-align: center;
    }
}
</style>
@endsection
