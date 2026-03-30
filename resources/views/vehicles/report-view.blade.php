@extends('layouts.app')

@section('content')
<div class="report-view-page">
    <div class="report-container">

        {{-- Header --}}
        <div class="report-header">
            <div class="report-header-left">
                <div class="verified-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Payment Verified
                </div>
                <h1 class="report-title">{{ $car->name }} — Vehicle Report</h1>
                <p class="report-meta">
                    <span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        Verified on {{ $payment->verified_at->format('d M Y, H:i') }}
                    </span>
                    <span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/>
                        </svg>
                        M-Pesa: {{ $payment->mpesa_code }}
                    </span>
                </p>
            </div>
            <a href="{{ route('vehicles.show', $car->id) }}" class="back-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Back to Listing
            </a>
        </div>

        {{-- PDF Viewer --}}
        <div class="pdf-wrapper">
            <iframe
                src="{{ asset('storage/' . $car->report) }}#toolbar=1&navpanes=0&scrollbar=1"
                class="pdf-iframe"
                title="{{ $car->name }} Report"
            ></iframe>
        </div>

        {{-- Download Button --}}
        <div class="report-footer">
            <a href="{{ asset('storage/' . $car->report) }}" download class="download-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Download Report PDF
            </a>
            <p class="report-disclaimer">
                This report is confidential and intended only for the purchaser. Do not share or redistribute.
            </p>
        </div>

    </div>
</div>

<style>
.report-view-page {
    min-height: 100vh;
    background: #f3f4f6;
    padding: 40px 20px;
}

.report-container {
    max-width: 1000px;
    margin: 0 auto;
}

.report-header {
    background: white;
    border-radius: 16px 16px 0 0;
    padding: 28px 32px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    border-bottom: 1px solid #e5e7eb;
    flex-wrap: wrap;
}

.verified-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 10px;
}

.report-title {
    font-size: 22px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 10px;
}

.report-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 13px;
    color: #6b7280;
}

.report-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 18px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #4b5563;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
    flex-shrink: 0;
}
.back-btn:hover { background: #f9fafb; border-color: #d1d5db; }

.pdf-wrapper {
    background: #525659;
    border-left: 1px solid #e5e7eb;
    border-right: 1px solid #e5e7eb;
}

.pdf-iframe {
    width: 100%;
    height: 820px;
    border: none;
    display: block;
}

.report-footer {
    background: white;
    border-radius: 0 0 16px 16px;
    padding: 24px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    border-top: 1px solid #e5e7eb;
    flex-wrap: wrap;
    border: 1px solid #e5e7eb;
    border-top: none;
}

.download-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #d32f2f;
    color: white;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
}
.download-btn:hover { background: #b91c1c; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(211,47,47,0.3); }

.report-disclaimer {
    font-size: 12px;
    color: #9ca3af;
    max-width: 400px;
    line-height: 1.5;
    margin: 0;
}

@media (max-width: 640px) {
    .report-header { padding: 20px; flex-direction: column; }
    .report-title  { font-size: 18px; }
    .pdf-iframe    { height: 500px; }
    .report-footer { padding: 20px; flex-direction: column; align-items: flex-start; }
    .download-btn  { width: 100%; justify-content: center; }
}
</style>
@endsection
