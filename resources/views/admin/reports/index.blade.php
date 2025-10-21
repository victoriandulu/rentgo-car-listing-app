{{-- resources/views/admin/reports/index.blade.php --}}

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
            <h1>Vehicle Reports</h1>
            <p>View and manage all vehicle inspection reports</p>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <div class="header-info">
                <h2>All Reports</h2>
                <span class="count-badge">{{ $reports->total() }} total</span>
            </div>
            <div class="search-box">
                <form action="{{ route('admin.reports.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Search by car name or owner..." value="{{ request('search') }}">
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
                        <th>Car</th>
                        <th>Owner</th>
                        <th>Generated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td>
                            <div class="car-cell">
                                <div class="car-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"></path>
                                        <circle cx="6.5" cy="16.5" r="2.5"></circle>
                                        <circle cx="16.5" cy="16.5" r="2.5"></circle>
                                    </svg>
                                </div>
                                <div class="car-info">
                                    <span class="car-name">{{ $report->name }}</span>
                                    <span class="car-price">KSh {{ number_format($report->price, 2) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="owner-cell">
                                <div class="owner-avatar">{{ substr($report->user->name ?? 'NA', 0, 2) }}</div>
                                <span class="owner-name">{{ $report->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="date-cell">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <span class="date-text">{{ $report->created_at->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ $report->report_url }}" target="_blank" class="btn btn-view-report">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                        <line x1="16" y1="13" x2="8" y2="13"></line>
                                        <line x1="16" y1="17" x2="8" y2="17"></line>
                                        <polyline points="10 9 9 9 8 9"></polyline>
                                    </svg>
                                    View Report
                                </a>
                                <a href="{{ $report->report_url }}" download class="btn btn-download">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="no-data">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            <p>No reports found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $reports->links() }}
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

.car-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.car-icon {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.car-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.car-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 14px;
}

.car-price {
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
}

.owner-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.owner-avatar {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    background: linear-gradient(135deg, #dc2626, #f59e0b);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
}

.owner-name {
    color: #374151;
    font-size: 14px;
    font-weight: 500;
}

.date-cell {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6b7280;
}

.date-cell svg {
    flex-shrink: 0;
}

.date-text {
    font-size: 14px;
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
    display: inline-flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}

.btn-view-report {
    background: linear-gradient(135deg, #dc2626, #f59e0b);
    color: white;
}

.btn-view-report:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

.btn-download {
    background: #fbbf24;
    color: #1f2937;
}

.btn-download:hover {
    background: #f59e0b;
    transform: translateY(-2px);
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
        font-size: 13px;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        text-align: center;
        justify-content: center;
    }
}
</style>
@endsection
