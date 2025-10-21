{{-- resources/views/admin/verifications/index.blade.php --}}

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
            <h1>User Verifications</h1>
            <p>Review and manage user verification documents</p>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <div class="header-info">
                <h2>All Verifications</h2>
                <span class="count-badge">{{ $verifications->total() }} total</span>
            </div>
            <div class="search-box">
                <form action="{{ route('admin.verifications.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Search by user name..." value="{{ request('search') }}">
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
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($verifications as $verification)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar">{{ substr($verification->user->name ?? 'NA', 0, 2) }}</div>
                                <span class="user-name">{{ $verification->user->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td>
                            @if($verification->user->is_verified ?? false)
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
                                    Pending Review
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="date-text">{{ $verification->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <button class="btn btn-view" onclick="openDocsModal({{ $verification->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                View Documents
                            </button>
                        </td>
                    </tr>

                    {{-- Modal for Documents --}}
                    <div id="docs-modal-{{ $verification->id }}" class="docs-modal">
                        <div class="modal-overlay" onclick="closeDocsModal({{ $verification->id }})"></div>
                        <div class="docs-modal-content">
                            <div class="modal-header">
                                <h3>{{ $verification->user->name ?? 'User' }}'s Documents</h3>
                                <button class="close-btn" onclick="closeDocsModal({{ $verification->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="docs-grid">
                                    @if($verification->driver_license)
                                        <div class="doc-card">
                                            <div class="doc-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                </svg>
                                            </div>
                                            <div class="doc-info">
                                                <h4>Driver License</h4>
                                                <a href="{{ asset('storage/' . $verification->driver_license) }}" target="_blank" class="doc-link">View Document</a>
                                            </div>
                                        </div>
                                    @endif

                                    @if($verification->proof_of_address)
                                        <div class="doc-card">
                                            <div class="doc-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                </svg>
                                            </div>
                                            <div class="doc-info">
                                                <h4>Proof of Address</h4>
                                                <a href="{{ asset('storage/' . $verification->proof_of_address) }}" target="_blank" class="doc-link">View Document</a>
                                            </div>
                                        </div>
                                    @endif

                                    @if($verification->national_id)
                                        <div class="doc-card">
                                            <div class="doc-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                </svg>
                                            </div>
                                            <div class="doc-info">
                                                <h4>National ID</h4>
                                                <a href="{{ asset('storage/' . $verification->national_id) }}" target="_blank" class="doc-link">View Document</a>
                                            </div>
                                        </div>
                                    @endif

                                    @if($verification->photo)
                                        <div class="doc-card photo-card">
                                            <div class="photo-preview">
                                                <img src="{{ asset('storage/' . $verification->photo) }}" alt="User Photo">
                                            </div>
                                            <div class="doc-info">
                                                <h4>User Photo</h4>
                                            </div>
                                        </div>
                                    @endif

                                    @if($verification->verification_video)
                                        <div class="doc-card">
                                            <div class="doc-icon video-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                                </svg>
                                            </div>
                                            <div class="doc-info">
                                                <h4>Verification Video</h4>
                                                <a href="{{ asset('storage/' . $verification->verification_video) }}" target="_blank" class="doc-link">View Video</a>
                                            </div>
                                        </div>
                                    @endif

                                    @if(is_array($verification->additional_docs))
                                        @foreach($verification->additional_docs as $index => $doc)
                                            <div class="doc-card">
                                                <div class="doc-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                        <polyline points="14 2 14 8 20 8"></polyline>
                                                    </svg>
                                                </div>
                                                <div class="doc-info">
                                                    <h4>Additional Doc {{ $index + 1 }}</h4>
                                                    <a href="{{ asset('storage/' . $doc) }}" target="_blank" class="doc-link">View Document</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="4" class="no-data">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <p>No verifications found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $verifications->links() }}
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

.date-text {
    color: #6b7280;
    font-size: 14px;
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
}

.btn-view {
    background: linear-gradient(135deg, #dc2626, #f59e0b);
    color: white;
}

.btn-view:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
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

/* Modal Styles */
.docs-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
}

.modal-overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
}

.docs-modal-content {
    position: relative;
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 800px;
    max-height: 85vh;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-header {
    padding: 25px 30px;
    border-bottom: 2px solid #f3f4f6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #dc2626, #f59e0b);
}

.modal-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: white;
}

.close-btn {
    background: rgba(255, 255, 255, 0.2);
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

.close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.modal-body {
    padding: 30px;
    max-height: calc(85vh - 100px);
    overflow-y: auto;
}

.docs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.doc-card {
    background: #f9fafb;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
    transition: all 0.3s ease;
}

.doc-card:hover {
    border-color: #dc2626;
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(220, 38, 38, 0.15);
}

.doc-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #dc2626, #f59e0b);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    color: white;
}

.video-icon {
    background: linear-gradient(135deg, #f59e0b, #fbbf24);
}

.doc-info h4 {
    margin: 0 0 8px 0;
    font-size: 14px;
    font-weight: 700;
    color: #1f2937;
}

.doc-link {
    color: #dc2626;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: color 0.3s ease;
}

.doc-link:hover {
    color: #991b1b;
}

.photo-card {
    grid-column: span 2;
}

.photo-preview {
    width: 100%;
    height: 200px;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 15px;
    background: #e5e7eb;
}

.photo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
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

    .docs-modal-content {
        width: 95%;
        max-height: 90vh;
    }

    .docs-grid {
        grid-template-columns: 1fr;
    }

    .photo-card {
        grid-column: span 1;
    }

    .modal-body {
        padding: 20px;
    }
}
</style>

<script>
function openDocsModal(id) {
    document.getElementById('docs-modal-' + id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeDocsModal(id) {
    document.getElementById('docs-modal-' + id).style.display = 'none';
    document.body.style.overflow = 'auto';
}
</script>

@endsection
