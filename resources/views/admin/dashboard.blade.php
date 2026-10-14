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
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
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
                    <path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H5.24a2 2 0 0 0-1.8 1.1l-.8 1.63A6 6 0 0 0 2 12.42V16h2"/>
                    <circle cx="6.5" cy="16.5" r="2.5"/>
                    <circle cx="16.5" cy="16.5" r="2.5"/>
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
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Verification Documents</h3>
                <div class="stat-number">{{ $verifications->count() }}</div>
                <p class="stat-description">View verification documents</p>
            </div>
        </a>

        <a href="{{ route('admin.reports.index') }}" class="stat-card reports">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Vehicle Reports</h3>
                <div class="stat-number">{{ $reports->count() }}</div>
                <p class="stat-description">Vehicle Reports</p>
            </div>
        </a>

        <!-- Home Slides Card -->
        <a href="{{ route('admin.hero-slides.index') }}" class="stat-card slides">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Home Slides</h3>
                <div class="stat-number">{{ \Illuminate\Support\Facades\Schema::hasTable('hero_slides') ? \App\Models\HeroSlide::count() : 0 }}</div>
                <p class="stat-description">Manage home page images</p>
            </div>
        </a>

        <!-- NEW: Pending Payments Card -->
        <a href="#pending-payments-section" class="stat-card payments" onclick="scrollToPending(event)">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                    <path d="M2 10h20"/>
                </svg>
            </div>
            <div class="stat-content">
                <h3>Pending Payments</h3>
                <div class="stat-number" id="pending-count">{{ isset($pendingPayments) ? $pendingPayments->count() : 0 }}</div>
                <p class="stat-description">Awaiting verification</p>
            </div>
            @if(isset($pendingPayments) && $pendingPayments->count() > 0)
                <span class="pending-badge">{{ $pendingPayments->count() }}</span>
            @endif
        </a>
    </div>

    <!-- Pending M-Pesa Payments Panel -->
    <div class="payments-panel" id="pending-payments-section">
        <div class="panel-header">
            <div class="panel-title-wrap">
                <div class="panel-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="2"/>
                        <path d="M2 10h20"/>
                    </svg>
                </div>
                <div>
                    <h2 class="panel-title">M-Pesa Report Payments</h2>
                    <p class="panel-subtitle">Review and verify customer payments to grant report access</p>
                </div>
            </div>
            <div class="panel-tabs">
                <button class="tab-btn active" onclick="filterPayments('pending', this)">
                    Pending
                    @if(isset($pendingPayments) && $pendingPayments->count() > 0)
                        <span class="tab-count">{{ $pendingPayments->count() }}</span>
                    @endif
                </button>
                <button class="tab-btn" onclick="filterPayments('verified', this)">Verified</button>
                <button class="tab-btn" onclick="filterPayments('all', this)">All</button>
            </div>
        </div>

        <div class="payments-table-wrap">
            <table class="payments-table" id="payments-table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Customer</th>
                        <th>Vehicle</th>
                        <th>M-Pesa Code</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="payments-tbody">
                    @forelse(isset($allPayments) ? $allPayments : [] as $payment)
                        <tr class="payment-row" data-status="{{ $payment->status }}" data-id="{{ $payment->id }}">
                            <td class="td-date">
                                <span class="date-main">{{ $payment->created_at->format('d M Y') }}</span>
                                <span class="date-time">{{ $payment->created_at->format('H:i') }}</span>
                            </td>
                            <td class="td-customer">
                                <span class="customer-phone">{{ $payment->phone }}</span>
                            </td>
                            <td class="td-vehicle">
                                <span class="vehicle-name">{{ $payment->car->name ?? 'N/A' }}</span>
                                <span class="vehicle-id">ID: {{ $payment->car_id }}</span>
                            </td>
                            <td class="td-code">
                                <span class="mpesa-code-tag">{{ $payment->mpesa_code }}</span>
                            </td>
                            <td class="td-amount">
                                <strong>KSh {{ number_format($payment->amount) }}</strong>
                            </td>
                            <td class="td-status">
                                @if($payment->status === 'verified')
                                    <span class="status-chip verified">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                        Verified
                                    </span>
                                @elseif($payment->status === 'rejected')
                                    <span class="status-chip rejected">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                        </svg>
                                        Rejected
                                    </span>
                                @else
                                    <span class="status-chip pending">
                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                                            <circle cx="12" cy="12" r="5"/>
                                        </svg>
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="td-actions">
                                @if($payment->status === 'pending')
                                    <button class="action-verify-btn"
                                        onclick="verifyPayment({{ $payment->id }}, 'verified', this)"
                                        title="Approve & grant report access">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                        Approve
                                    </button>
                                    <button class="action-reject-btn"
                                        onclick="verifyPayment({{ $payment->id }}, 'rejected', this)"
                                        title="Reject payment">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                                        </svg>
                                        Reject
                                    </button>
                                @elseif($payment->status === 'verified')
                                    <span class="action-done">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                        Access Granted
                                    </span>
                                @else
                                    <span class="action-done rejected-text">Rejected</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-row">
                            <td colspan="7" class="empty-state">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                                    <path d="M2 10h20"/>
                                </svg>
                                <p>No payment submissions yet</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirm-modal" class="confirm-overlay" onclick="closeConfirmModal(event)">
    <div class="confirm-box">
        <div class="confirm-icon" id="confirm-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <h3 id="confirm-title">Confirm Action</h3>
        <p id="confirm-msg">Are you sure?</p>
        <div class="confirm-btns">
            <button class="confirm-cancel" onclick="closeConfirmModal()">Cancel</button>
            <button class="confirm-ok" id="confirm-ok-btn">Confirm</button>
        </div>
    </div>
</div>

<div id="admin-toast" class="admin-toast"></div>

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
.dashboard-header h1 { font-size: 36px; font-weight: 700; color: #dc2626; margin-bottom: 10px; }
.dashboard-header p  { font-size: 16px; color: #666; }

.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.stat-card {
    background: white; border-radius: 16px; padding: 28px;
    text-decoration: none; color: inherit;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease; display: flex; align-items: center;
    gap: 20px; border: 2px solid transparent;
    position: relative; overflow: hidden;
}
.stat-card::before {
    content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px;
    background: linear-gradient(90deg, #dc2626, #fbbf24);
}
.stat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 30px rgba(220,38,38,0.15); border-color: #dc2626; }

.stat-card.users .stat-icon,
.stat-card.verifications .stat-icon { color: #dc2626; }
.stat-card.cars .stat-icon,
.stat-card.reports .stat-icon      { color: #f59e0b; }
.stat-card.payments .stat-icon     { color: #7c3aed; }
.stat-card.slides .stat-icon       { color: #D94F16; }

.stat-icon {
    flex-shrink: 0; width: 70px; height: 70px;
    display: flex; align-items: center; justify-content: center;
    background: #fff5f5; border-radius: 12px;
}
.stat-card.payments .stat-icon { background: #f5f3ff; }

.stat-content h3 { font-size: 14px; font-weight: 600; color: #666; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
.stat-number     { font-size: 32px; font-weight: 700; color: #1f2937; margin-bottom: 5px; }
.stat-description { font-size: 13px; color: #9ca3af; margin: 0; }

.pending-badge {
    position: absolute; top: 14px; right: 14px;
    background: #dc2626; color: white; font-size: 11px; font-weight: 700;
    width: 22px; height: 22px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    animation: badge-pulse 1.5s ease-in-out infinite;
}
@keyframes badge-pulse {
    0%, 100% { transform: scale(1); }
    50%       { transform: scale(1.15); }
}

/* PAYMENTS PANEL */
.payments-panel {
    background: white; border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;
    margin-bottom: 40px;
}

.panel-header {
    padding: 28px 32px 0;
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: 20px; border-bottom: 1px solid #f0f0f0;
}

.panel-title-wrap { display: flex; align-items: flex-start; gap: 16px; padding-bottom: 20px; }
.panel-icon {
    width: 48px; height: 48px; background: #f5f3ff; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #7c3aed; flex-shrink: 0;
}
.panel-title    { font-size: 20px; font-weight: 700; color: #1f2937; margin: 0 0 4px; }
.panel-subtitle { font-size: 14px; color: #9ca3af; margin: 0; }

.panel-tabs { display: flex; gap: 4px; padding-bottom: 0; align-self: flex-end; }
.tab-btn {
    padding: 10px 18px; border: none; background: transparent;
    font-size: 14px; font-weight: 600; color: #9ca3af; cursor: pointer;
    border-bottom: 3px solid transparent; transition: all 0.2s;
    display: flex; align-items: center; gap: 6px;
}
.tab-btn:hover  { color: #4a5568; }
.tab-btn.active { color: #dc2626; border-bottom-color: #dc2626; }
.tab-count {
    background: #dc2626; color: white; font-size: 11px; font-weight: 700;
    padding: 2px 7px; border-radius: 10px;
}

.payments-table-wrap { overflow-x: auto; }

.payments-table {
    width: 100%; border-collapse: collapse; font-size: 14px;
}
.payments-table thead tr { background: #f8fafc; }
.payments-table th {
    padding: 14px 20px; text-align: left; font-size: 12px; font-weight: 700;
    color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;
    white-space: nowrap; border-bottom: 1px solid #f0f0f0;
}
.payments-table td { padding: 16px 20px; border-bottom: 1px solid #f9fafb; vertical-align: middle; }
.payment-row:last-child td { border-bottom: none; }
.payment-row:hover td { background: #fafafa; }

.td-date .date-main { display: block; font-weight: 600; color: #1f2937; font-size: 13px; }
.td-date .date-time { display: block; color: #9ca3af; font-size: 12px; margin-top: 2px; }

.td-customer .customer-phone { font-weight: 600; color: #1f2937; }

.td-vehicle .vehicle-name { display: block; font-weight: 600; color: #1f2937; }
.td-vehicle .vehicle-id   { display: block; font-size: 12px; color: #9ca3af; margin-top: 2px; }

.mpesa-code-tag {
    font-family: 'Courier New', monospace; font-weight: 700; font-size: 14px;
    background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;
    padding: 4px 10px; border-radius: 6px; letter-spacing: 1px;
}

.td-amount strong { color: #1f2937; font-size: 15px; }

.status-chip {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
}
.status-chip.pending  { background: #fffbeb; color: #92400e; border: 1px solid #fcd34d; }
.status-chip.verified { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.status-chip.rejected { background: #fff5f5; color: #c53030; border: 1px solid #fc8181; }

.action-verify-btn, .action-reject-btn {
    padding: 7px 14px; border-radius: 7px; font-size: 12px; font-weight: 700;
    cursor: pointer; border: none; transition: all 0.2s;
    display: inline-flex; align-items: center; gap: 5px; margin-right: 6px;
}
.action-verify-btn { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.action-verify-btn:hover { background: #16a34a; color: white; transform: translateY(-1px); }
.action-reject-btn { background: #fff5f5; color: #c53030; border: 1px solid #fc8181; }
.action-reject-btn:hover { background: #dc2626; color: white; transform: translateY(-1px); }
.action-reject-btn:disabled, .action-verify-btn:disabled { opacity: 0.5; cursor: not-allowed; }

.action-done { font-size: 12px; font-weight: 600; color: #16a34a; display: inline-flex; align-items: center; gap: 4px; }
.action-done.rejected-text { color: #dc2626; }

.empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }
.empty-state svg { margin: 0 auto 16px; display: block; }
.empty-state p { font-size: 15px; margin: 0; }

/* Confirm Modal */
.confirm-overlay {
    display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45);
    backdrop-filter: blur(3px); z-index: 9999;
    align-items: center; justify-content: center; padding: 20px;
}
.confirm-overlay.open { display: flex; }

.confirm-box {
    background: white; border-radius: 16px; padding: 32px; max-width: 380px;
    width: 100%; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    animation: modalSlideIn 0.25s ease;
}
@keyframes modalSlideIn { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }

.confirm-icon { margin: 0 auto 16px; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.confirm-icon.approve { background: #f0fdf4; color: #16a34a; }
.confirm-icon.reject  { background: #fff5f5; color: #dc2626; }

.confirm-box h3 { font-size: 18px; font-weight: 700; color: #1f2937; margin-bottom: 10px; }
.confirm-box p  { font-size: 14px; color: #6b7280; margin-bottom: 24px; line-height: 1.6; }

.confirm-btns { display: flex; gap: 12px; }
.confirm-cancel { flex: 1; padding: 12px; background: #f7fafc; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; font-weight: 600; color: #4a5568; cursor: pointer; transition: all 0.2s; }
.confirm-cancel:hover { background: #e2e8f0; }
.confirm-ok { flex: 1; padding: 12px; border: none; border-radius: 8px; font-size: 14px; font-weight: 700; color: white; cursor: pointer; transition: all 0.2s; }
.confirm-ok.approve { background: #16a34a; }
.confirm-ok.approve:hover { background: #15803d; }
.confirm-ok.reject  { background: #dc2626; }
.confirm-ok.reject:hover  { background: #b91c1c; }

/* Toast */
.admin-toast {
    position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%) translateY(20px);
    background: #1f2937; color: white; padding: 12px 24px; border-radius: 10px;
    font-size: 14px; font-weight: 600; opacity: 0; transition: all 0.3s ease;
    pointer-events: none; z-index: 99999; display: flex; align-items: center; gap: 8px;
}
.admin-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
.admin-toast.success { background: #166534; }
.admin-toast.error   { background: #b91c1c; }

@media (max-width: 768px) {
    .admin-dashboard { padding: 20px; margin: 70px 10px 50px; }
    .dashboard-header h1 { font-size: 28px; }
    .stats-container { grid-template-columns: 1fr; gap: 15px; }
    .stat-card { padding: 20px; }
    .stat-number { font-size: 28px; }
    .panel-header { flex-direction: column; padding: 20px 20px 0; }
    .panel-tabs { align-self: flex-start; }
    .payments-table th, .payments-table td { padding: 12px 14px; }
    .action-verify-btn, .action-reject-btn { padding: 6px 10px; font-size: 11px; }
}
</style>

<script>
function scrollToPending(e) {
    e.preventDefault();
    const section = document.getElementById('pending-payments-section');
    if (section) section.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function filterPayments(status, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.payment-row').forEach(row => {
        row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
    });
}

let pendingAction = null;

function verifyPayment(paymentId, action, btn) {
    pendingAction = { paymentId, action, btn };

    const isApprove = action === 'verified';
    const modal = document.getElementById('confirm-modal');

    document.getElementById('confirm-icon').className = 'confirm-icon ' + (isApprove ? 'approve' : 'reject');
    document.getElementById('confirm-icon').innerHTML = isApprove
        ? `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>`
        : `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`;

    document.getElementById('confirm-title').textContent = isApprove ? 'Approve Payment?' : 'Reject Payment?';
    document.getElementById('confirm-msg').textContent   = isApprove
        ? 'This will verify the M-Pesa code and grant the customer access to the vehicle report immediately.'
        : 'This will reject this payment submission. The customer will not receive report access.';

    const okBtn = document.getElementById('confirm-ok-btn');
    okBtn.className = 'confirm-ok ' + (isApprove ? 'approve' : 'reject');
    okBtn.textContent = isApprove ? 'Yes, Approve' : 'Yes, Reject';
    okBtn.onclick = executeVerification;

    modal.classList.add('open');
}

function executeVerification() {
    if (!pendingAction) return;
    const { paymentId, action, btn } = pendingAction;
    pendingAction = null;

    closeConfirmModal();

    const row     = btn.closest('tr');
    const allBtns = row.querySelectorAll('button');
    allBtns.forEach(b => { b.disabled = true; b.style.opacity = '0.5'; });

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        showAdminToast('CSRF token missing — add <meta name="csrf-token"> to your layout head.', 'error');
        allBtns.forEach(b => { b.disabled = false; b.style.opacity = '1'; });
        return;
    }

    // URL matches route: prefix 'admin' + '/report-payments/{id}/verify'
    fetch(`/admin/report-payments/${paymentId}/verify`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.getAttribute('content')
        },
        body: JSON.stringify({ status: action })
    })
    .then(res => {
        if (!res.ok) throw new Error('HTTP ' + res.status);
        return res.json();
    })
    .then(data => {
        if (data.success) {
            row.dataset.status = action;

            const statusTd  = row.querySelector('.td-status');
            const actionsTd = row.querySelector('.td-actions');

            if (action === 'verified') {
                statusTd.innerHTML  = `<span class="status-chip verified">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    Verified</span>`;
                actionsTd.innerHTML = `<span class="action-done">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    Access Granted</span>`;
            } else {
                statusTd.innerHTML  = `<span class="status-chip rejected">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Rejected</span>`;
                actionsTd.innerHTML = `<span class="action-done rejected-text">Rejected</span>`;
            }

            // Refresh pending count badge
            const remaining = document.querySelectorAll('.payment-row[data-status="pending"]').length;
            const countEl   = document.getElementById('pending-count');
            if (countEl) countEl.textContent = remaining;

            showAdminToast(
                action === 'verified' ? '✓ Payment approved — report access granted' : '✗ Payment rejected',
                action === 'verified' ? 'success' : 'error'
            );
        } else {
            allBtns.forEach(b => { b.disabled = false; b.style.opacity = '1'; });
            showAdminToast('Error: ' + (data.message || 'Something went wrong'), 'error');
        }
    })
    .catch(err => {
        allBtns.forEach(b => { b.disabled = false; b.style.opacity = '1'; });
        showAdminToast('Request failed (' + err.message + '). Check console for details.', 'error');
        console.error('verifyPayment error:', err);
    });
}

function closeConfirmModal(e) {
    if (!e || e.target === document.getElementById('confirm-modal')) {
        document.getElementById('confirm-modal').classList.remove('open');
    }
}

function showAdminToast(msg, type = '') {
    const t = document.getElementById('admin-toast');
    if (!t) return;
    t.textContent = msg;
    t.className   = 'admin-toast show ' + type;
    setTimeout(() => { t.className = 'admin-toast'; }, 3500);
}
</script>
@endsection
