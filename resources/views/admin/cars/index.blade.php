{{-- resources/views/admin/cars/index.blade.php --}}

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
            <h1>Car Management</h1>
            <p>Manage all listed vehicles on the platform</p>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <div class="header-info">
                <h2>All Cars</h2>
                <span class="count-badge">{{ $cars->total() }} total</span>
            </div>
            <div class="search-box">
                <form action="{{ route('admin.cars.index') }}" method="GET">
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
                        <th>Price</th>
                        <th>Status</th>
                        <th>Report</th>
                        <th>Report Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $car)
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
                                <span class="car-name">{{ $car->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="owner-name">{{ $car->user->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="price-badge">KSh {{ number_format($car->price, 2) }}</span>
                        </td>
                        <td>
                            @if($car->status === 'available')
                                <span class="badge badge-available">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    Available
                                </span>
                            @elseif($car->status === 'sold')
                                <span class="badge badge-sold">Sold</span>
                            @else
                                <span class="badge badge-pending">{{ ucfirst($car->status) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($car->report)
                                <a href="{{ $car->report_url }}" target="_blank" class="report-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                        <polyline points="14 2 14 8 20 8"></polyline>
                                    </svg>
                                    View Report
                                </a>
                            @else
                                <span class="text-muted">No Report</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.cars.update-report-price', $car->id) }}" method="POST" class="report-price-form">
                                @csrf
                                @method('PATCH')
                                <div class="price-input-group">
                                    <span class="currency-prefix">KSh</span>
                                    <input
                                        type="number"
                                        name="report_price"
                                        value="{{ $car->report_price ?? '' }}"
                                        placeholder="N/A"
                                        class="report-price-input"
                                        min="0"
                                        step="1"
                                    >
                                    <button type="submit" class="btn-save-price">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <form action="{{ route('admin.cars.delete', $car->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this car?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="no-data">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"></path>
                                <circle cx="6.5" cy="16.5" r="2.5"></circle>
                                <circle cx="16.5" cy="16.5" r="2.5"></circle>
                            </svg>
                            <p>No cars found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $cars->links() }}
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
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.car-name {
    font-weight: 600;
    color: #1f2937;
}

.owner-name {
    color: #6b7280;
    font-size: 14px;
}

.price-badge {
    background: #f0fdf4;
    color: #166534;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: 700;
    font-size: 13px;
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

.badge-available {
    background: #d1fae5;
    color: #065f46;
}

.badge-sold {
    background: #fee2e2;
    color: #991b1b;
}

.badge-pending {
    background: #fef3c7;
    color: #92400e;
}

.report-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #dc2626;
    text-decoration: none;
    font-weight: 600;
    font-size: 13px;
    transition: color 0.3s ease;
}

.report-link:hover {
    color: #991b1b;
}

/* Report Price Input Styles */
.report-price-form {
    display: inline-block;
}

.price-input-group {
    display: flex;
    align-items: center;
    gap: 4px;
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 4px 8px;
    transition: all 0.3s ease;
}

.price-input-group:focus-within {
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.currency-prefix {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
}

.report-price-input {
    width: 100px;
    border: none;
    background: transparent;
    padding: 6px 4px;
    font-size: 14px;
    font-weight: 600;
    color: #1f2937;
    outline: none;
}

.report-price-input::placeholder {
    color: #9ca3af;
    font-weight: 400;
}

.report-price-input::-webkit-outer-spin-button,
.report-price-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.report-price-input[type=number] {
    -moz-appearance: textfield;
}

.btn-save-price {
    background: linear-gradient(135deg, #10b981, #059669);
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.btn-save-price:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
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
        font-size: 13px;
    }

    .report-price-input {
        width: 80px;
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
