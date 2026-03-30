@extends('layouts.app')

@section('content')
<div class="report-locked-page">
    <div class="locked-container">

        @if($reason === 'pending')
            {{-- Still waiting for admin --}}
            <div class="locked-icon pending">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <h1 class="locked-title">Payment Pending Verification</h1>
            <p class="locked-msg">Your M-Pesa payment has been received and is awaiting admin verification. This usually takes <strong>30 minutes or less</strong>.</p>
            <div class="locked-info-box amber">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>Please check back shortly. Once verified, return to this page with your phone number to access your report.</span>
            </div>

        @elseif($reason === 'not_paid')
            {{-- Never paid --}}
            <div class="locked-icon red">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <h1 class="locked-title">Report Not Unlocked</h1>
            <p class="locked-msg">No verified payment was found for this phone number and vehicle. Purchase the report to gain access.</p>
            <div class="locked-info-box red">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <span>If you already paid, make sure you are entering the same phone number used during payment.</span>
            </div>

        @else
            {{-- No phone provided --}}
            <div class="locked-icon gray">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>
            <h1 class="locked-title">Enter Your Phone Number</h1>
            <p class="locked-msg">Enter the M-Pesa phone number you used to pay for this report.</p>
        @endif

        {{-- Phone access form --}}
        <div class="phone-access-form">
            <label class="form-label">Enter your M-Pesa phone number to access the report</label>
            <div class="phone-row">
                <span class="phone-prefix">+254</span>
                <input
                    type="tel"
                    id="access-phone"
                    class="phone-field"
                    placeholder="7XX XXX XXX"
                    maxlength="9"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                    value="{{ request('phone') ? ltrim(request('phone'), '+254') : '' }}"
                >
                <button class="access-btn" onclick="checkAccess()">
                    Access Report
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </button>
            </div>
            <div id="access-error" class="access-error hidden">Please enter a valid 9-digit phone number</div>
        </div>

        <a href="{{ route('vehicles.show', $car->id) }}" class="back-link">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Back to vehicle listing
        </a>
    </div>
</div>

<script>
function checkAccess() {
    const phone = document.getElementById('access-phone').value.trim();
    if (phone.length < 9) {
        document.getElementById('access-error').classList.remove('hidden');
        return;
    }
    document.getElementById('access-error').classList.add('hidden');
    window.location.href = `/vehicles/{{ $car->id }}/report?phone=+254${phone}`;
}

// Allow Enter key
document.getElementById('access-phone').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') checkAccess();
});
</script>

<style>
.report-locked-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #fff5f5 0%, #fff9e6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}

.locked-container {
    background: white;
    border-radius: 20px;
    padding: 48px 40px;
    max-width: 520px;
    width: 100%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    text-align: center;
}

.locked-icon {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
}
.locked-icon.pending { background: #fffbeb; color: #f59e0b; }
.locked-icon.red     { background: #fff5f5; color: #dc2626; }
.locked-icon.gray    { background: #f7fafc; color: #9ca3af; }

.locked-title {
    font-size: 24px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 12px;
}

.locked-msg {
    font-size: 15px;
    color: #6b7280;
    line-height: 1.7;
    margin-bottom: 24px;
}

.locked-info-box {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 14px 16px;
    border-radius: 10px;
    font-size: 13px;
    line-height: 1.6;
    text-align: left;
    margin-bottom: 28px;
}
.locked-info-box.amber { background: #fffbeb; border: 1px solid #fcd34d; color: #92400e; }
.locked-info-box.red   { background: #fff5f5; border: 1px solid #fca5a5; color: #991b1b; }

.phone-access-form {
    border-top: 1px solid #f0f0f0;
    padding-top: 28px;
    margin-bottom: 24px;
    text-align: left;
}

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
}

.phone-row {
    display: flex;
    align-items: center;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    transition: border-color 0.2s;
}
.phone-row:focus-within { border-color: #d32f2f; box-shadow: 0 0 0 3px rgba(211,47,47,0.1); }

.phone-prefix {
    background: #f9fafb;
    padding: 14px 14px;
    font-size: 15px;
    font-weight: 700;
    color: #4b5563;
    border-right: 2px solid #e5e7eb;
    white-space: nowrap;
}

.phone-field {
    flex: 1;
    border: none;
    outline: none;
    padding: 14px 14px;
    font-size: 15px;
    color: #1a1a1a;
    min-width: 0;
}

.access-btn {
    background: #d32f2f;
    color: white;
    border: none;
    padding: 14px 18px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
}
.access-btn:hover { background: #b91c1c; }

.access-error {
    color: #dc2626;
    font-size: 13px;
    margin-top: 8px;
    padding: 8px 12px;
    background: #fff5f5;
    border-radius: 6px;
    border: 1px solid #fca5a5;
}
.access-error.hidden { display: none; }

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #9ca3af;
    font-size: 14px;
    text-decoration: none;
    transition: color 0.2s;
}
.back-link:hover { color: #4b5563; }

@media (max-width: 480px) {
    .locked-container { padding: 32px 20px; }
    .locked-title { font-size: 20px; }
    .access-btn { padding: 14px 12px; font-size: 13px; }
}
</style>
@endsection
