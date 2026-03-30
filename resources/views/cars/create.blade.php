@extends('layouts.dashboard')
@section('dashboard-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=Instrument+Serif:ital@0;1&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --red: #e63232;
    --red-light: #fef2f2;
    --red-mid: #fca5a5;
    --ink: #141010;
    --ink-2: #4a4040;
    --ink-3: #9c8c8c;
    --bg: #f7f3f0;
    --card: #ffffff;
    --border: #ede6e0;
    --warm: #fdf8f5;
    --radius: 16px;
    --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
}

body { background: var(--bg); }

.cl-page {
    font-family: 'Sora', sans-serif;
    color: var(--ink);
    background: var(--bg);
    min-height: 100vh;
    padding: 32px 20px 64px;
}

/* ─── Page Header ─── */
.cl-header {
    max-width: 720px;
    margin: 0 auto 32px;
}
.cl-header-inner {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}
.cl-breadcrumb {
    font-size: 0.75rem;
    color: var(--ink-3);
    margin-bottom: 8px;
    letter-spacing: 0.04em;
}
.cl-breadcrumb span { color: var(--ink-2); }
.cl-title {
    font-family: 'Instrument Serif', serif;
    font-size: 2rem;
    font-weight: 400;
    color: var(--ink);
    line-height: 1.15;
}
.cl-title em { font-style: italic; color: var(--red); }
.cl-subtitle { font-size: 0.875rem; color: var(--ink-3); margin-top: 6px; }

.cl-trust-row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items: center;
}
.cl-trust-chip {
    display: flex;
    align-items: center;
    gap: 6px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 100px;
    padding: 6px 12px;
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--ink-2);
    white-space: nowrap;
}
.cl-trust-chip .dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--red);
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.4; transform:scale(1.6); }
}

/* Progress bar */
.cl-progress-wrap {
    max-width: 720px;
    margin: 0 auto 28px;
}
.cl-progress-steps {
    display: flex;
    align-items: center;
    gap: 0;
    position: relative;
}
.cl-step {
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
    position: relative;
}
.cl-step:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 28px;
    right: 0;
    top: 14px;
    height: 2px;
    background: var(--border);
    z-index: 0;
}
.cl-step-dot {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: var(--card);
    border: 2px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--ink-3);
    flex-shrink: 0;
    position: relative;
    z-index: 1;
    transition: all .2s;
}
.cl-step.active .cl-step-dot {
    background: var(--red);
    border-color: var(--red);
    color: white;
}
.cl-step.done .cl-step-dot {
    background: #22c55e;
    border-color: #22c55e;
    color: white;
}
.cl-step-label {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--ink-3);
    display: none;
    position: relative;
    z-index: 1;
    background: var(--bg);
    padding: 0 4px;
}
.cl-step.active .cl-step-label {
    color: var(--ink);
    background: var(--bg); /* ensure active label also masks the line */
}
@media (min-width: 500px) { .cl-step-label { display: block; } }
.cl-step.active .cl-step-label { color: var(--ink); }

/* ─── Cards ─── */
.cl-form {
    max-width: 720px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.cl-card {
    background: var(--card);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: box-shadow .2s;
}
.cl-card:hover { box-shadow: 0 2px 6px rgba(0,0,0,0.07), 0 8px 24px rgba(0,0,0,0.08); }

.cl-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 22px 16px;
    border-bottom: 1px solid var(--border);
    gap: 12px;
}
.cl-card-head-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.cl-card-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: var(--red-light);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
.cl-card-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--ink);
    letter-spacing: -0.01em;
}
.cl-card-desc {
    font-size: 0.78rem;
    color: var(--ink-3);
    margin-top: 2px;
}
.cl-card-badge {
    font-size: 0.68rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 100px;
    background: var(--red-light);
    color: var(--red);
    letter-spacing: 0.04em;
    white-space: nowrap;
}
.cl-card-badge.optional {
    background: #f0f9f0;
    color: #16a34a;
}

.cl-card-body {
    padding: 22px;
}

/* ─── Fields ─── */
.cl-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.cl-full { grid-column: 1 / -1; }

.cl-field { display: flex; flex-direction: column; gap: 5px; }
.cl-field label {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--ink-2);
    letter-spacing: 0.01em;
}
.cl-req { color: var(--red); }

.cl-hint { font-size: 0.72rem; color: var(--ink-3); }

input[type="text"],
input[type="number"],
select,
textarea {
    width: 100%;
    padding: 11px 14px;
    background: var(--warm);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 0.875rem;
    font-family: 'Sora', sans-serif;
    color: var(--ink);
    transition: border-color .18s, box-shadow .18s, background .18s;
    -webkit-appearance: none;
    appearance: none;
    outline: none;
}
input::placeholder, textarea::placeholder { color: #c4b8b0; }
input:focus, select:focus, textarea:focus {
    border-color: var(--red);
    background: white;
    box-shadow: 0 0 0 3px rgba(230,50,50,0.09);
}
textarea { resize: vertical; }

/* select chevron */
.cl-select-wrap { position: relative; }
.cl-select-wrap::after {
    content: '▾';
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.8rem;
    color: var(--ink-3);
    pointer-events: none;
}
.cl-select-wrap select { padding-right: 34px; }

/* ─── Price input ─── */
.cl-price-wrap { position: relative; }
.cl-price-prefix {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--ink-3);
    pointer-events: none;
}
.cl-price-wrap input { padding-left: 50px; }

/* ─── Photo upload ─── */
.cl-upload-zone {
    border: 2px dashed #ddd4cc;
    border-radius: 12px;
    padding: 36px 20px;
    text-align: center;
    cursor: pointer;
    background: var(--warm);
    transition: all .2s;
    color: var(--ink-2);
    position: relative;
}
.cl-upload-zone:hover,
.cl-upload-zone.drag { border-color: var(--red); background: #fff9f7; }
.cl-upload-zone-icon { font-size: 2.2rem; margin-bottom: 10px; }
.cl-upload-zone-text { font-size: 0.875rem; font-weight: 600; margin-bottom: 4px; }
.cl-upload-zone-sub  { font-size: 0.78rem; color: var(--ink-3); }
.cl-upload-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }

.cl-preview-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-top: 14px;
}
.cl-prev-item {
    position: relative;
    aspect-ratio: 4/3;
    border-radius: 10px;
    overflow: hidden;
    border: 2px solid var(--border);
    cursor: pointer;
    transition: border-color .15s;
}
.cl-prev-item.main { border-color: var(--red); }
.cl-prev-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
.cl-prev-overlay {
    position: absolute; inset: 0;
    background: rgba(0,0,0,.55);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity .15s;
}
.cl-prev-item:hover .cl-prev-overlay { opacity: 1; }
.cl-prev-del {
    background: white;
    color: #e63232;
    border: none;
    border-radius: 50%;
    width: 28px; height: 28px;
    font-size: 1rem;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700;
    line-height: 1;
}
.cl-main-tag {
    position: absolute; bottom: 5px; left: 5px;
    background: var(--red);
    color: white;
    font-size: 0.62rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 4px;
    letter-spacing: 0.04em;
}
.cl-set-main-tag {
    position: absolute; bottom: 5px; left: 5px;
    background: rgba(0,0,0,0.5);
    color: white;
    font-size: 0.62rem;
    font-weight: 600;
    padding: 2px 7px;
    border-radius: 4px;
}

/* ─── Features grid ─── */
.cl-feats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}
.cl-feat-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 14px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    cursor: pointer;
    background: var(--warm);
    transition: all .18s;
    font-size: 0.845rem;
    color: var(--ink-2);
    font-weight: 500;
    user-select: none;
}
.cl-feat-item:hover { border-color: #f4a0a0; background: white; }
.cl-feat-item.checked { border-color: var(--red); background: var(--red-light); color: var(--ink); }
.cl-feat-item input { display: none; }
.cl-feat-tick {
    width: 18px; height: 18px;
    border-radius: 5px;
    border: 1.5px solid #ddd4cc;
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem;
    transition: all .18s;
}
.cl-feat-item.checked .cl-feat-tick {
    background: var(--red);
    border-color: var(--red);
    color: white;
}

/* ─── Info row (inline 2-col tip) ─── */
.cl-info-row {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #fffbf5;
    border: 1px solid #f0e6d2;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.8rem;
    color: #7a5c30;
    margin-top: 4px;
}
.cl-info-icon { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }

/* ─── File input ─── */
.cl-file-label {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: var(--warm);
    border: 1.5px dashed var(--border);
    border-radius: 10px;
    cursor: pointer;
    font-size: 0.86rem;
    color: var(--ink-2);
    transition: all .18s;
}
.cl-file-label:hover { border-color: var(--red); background: white; }
.cl-file-label input { display: none; }
.cl-file-name { color: var(--ink-3); font-size: 0.78rem; margin-top: 3px; }

/* ─── Alert ─── */
.cl-alert {
    background: var(--red-light);
    border: 1.5px solid var(--red-mid);
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 16px;
    color: #991b1b;
    font-size: 0.875rem;
    max-width: 720px;
    margin-left: auto;
    margin-right: auto;
}
.cl-alert ul { margin: 8px 0 0 18px; font-size: 0.82rem; }

/* ─── Submit area ─── */
.cl-submit-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 24px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}
.cl-submit-info { font-size: 0.8rem; color: var(--ink-3); }
.cl-submit-info strong { color: var(--ink-2); display: block; font-size: 0.875rem; margin-bottom: 2px; }
.cl-btn-submit {
    padding: 14px 36px;
    background: var(--red);
    color: white;
    border: none;
    border-radius: 12px;
    font-family: 'Sora', sans-serif;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    transition: background .18s, transform .15s, box-shadow .18s;
    white-space: nowrap;
    letter-spacing: 0.02em;
    box-shadow: 0 4px 16px rgba(230,50,50,0.22);
}
.cl-btn-submit:hover {
    background: #cc2020;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(230,50,50,0.3);
}
.cl-btn-submit:active { transform: translateY(0); }

/* ─── Divider ─── */
.cl-divider { height: 1px; background: var(--border); margin: 4px 0; }

/* ─── Responsive ─── */
@media (max-width: 600px) {
    .cl-grid { grid-template-columns: 1fr; }
    .cl-feats { grid-template-columns: 1fr; }
    .cl-preview-grid { grid-template-columns: repeat(3,1fr); }
    .cl-card-body { padding: 16px; }
    .cl-card-head { padding: 14px 16px 12px; }
    .cl-submit-card { flex-direction: column; align-items: stretch; }
    .cl-btn-submit { width: 100%; text-align: center; }
}
</style>

<div class="cl-page">

    {{-- ── Page Header ── --}}
    <div class="cl-header">
        <div class="cl-header-inner">
            <div>

                <h1 class="cl-title">List your <em>car</em></h1>
                <p class="cl-subtitle">Free to post · reach thousands of verified buyers</p>
            </div>
            <div class="cl-trust-row">
                <div class="cl-trust-chip"><span class="dot"></span> Live marketplace</div>
                <div class="cl-trust-chip">⚡ Avg. 7-day sale</div>
            </div>
        </div>
    </div>

    {{-- ── Progress steps ── --}}
    <div class="cl-progress-wrap">
        <div class="cl-progress-steps">
            <div class="cl-step active">
                <div class="cl-step-dot">1</div>
                <span class="cl-step-label">Details</span>
            </div>
            <div class="cl-step">
                <div class="cl-step-dot">2</div>
                <span class="cl-step-label">Photos</span>
            </div>
            <div class="cl-step">
                <div class="cl-step-dot">3</div>
                <span class="cl-step-label">Specs</span>
            </div>
            <div class="cl-step">
                <div class="cl-step-dot">4</div>
                <span class="cl-step-label">Publish</span>
            </div>
        </div>
    </div>

    {{-- ── Validation errors ── --}}
    @if ($errors->any())
        <div class="cl-alert">
            <strong>⚠️ Please fix these before continuing:</strong>
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" id="carForm" class="cl-form">
        @csrf

        {{-- ── CARD 1: General Details ── --}}
        <div class="cl-card">
            <div class="cl-card-head">
                <div class="cl-card-head-left">
                    <div class="cl-card-icon">🚗</div>
                    <div>
                        <div class="cl-card-title">General Details</div>
                        <div class="cl-card-desc">Basic info about your car</div>
                    </div>
                </div>
                <span class="cl-card-badge">REQUIRED</span>
            </div>
            <div class="cl-card-body">
                <div class="cl-grid">
                    <div class="cl-field lc-full" style="grid-column:1/-1">
                        <label>Car Name <span class="cl-req">*</span></label>
                        <input type="text" name="name" placeholder="e.g., Toyota Camry 2021" value="{{ old('name') }}" required>
                    </div>
                    <div class="cl-field">
                        <label>Year <span class="cl-req">*</span></label>
                        <input type="number" name="year" placeholder="2021" min="1980" max="2025" value="{{ old('year') }}" required>
                    </div>
                    <div class="cl-field">
                        <label>Type <span class="cl-req">*</span></label>
                        <div class="cl-select-wrap">
                            <select name="car_type" required>
                                <option value="">Select type</option>
                                @foreach(['Sedan','SUV','Hatchback','Coupe','Convertible','Pickup','Van','Truck'] as $t)
                                    <option {{ old('car_type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cl-field" style="grid-column:1/-1">
                        <label>Price (KSh) <span class="cl-req">*</span></label>
                        <div class="cl-price-wrap">
                            <span class="cl-price-prefix">KSh</span>
                            <input type="number" name="price" placeholder="1,500,000" value="{{ old('price') }}" required>
                        </div>
                    </div>
                    <div class="cl-field" style="grid-column:1/-1">
                        <label>Description</label>
                        <textarea name="description" rows="3" placeholder="Describe condition, history, key highlights…">{{ old('description') }}</textarea>
                        <span class="cl-hint">A detailed description helps buyers decide faster.</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── CARD 2: Photos ── --}}
        <div class="cl-card">
            <div class="cl-card-head">
                <div class="cl-card-head-left">
                    <div class="cl-card-icon">📸</div>
                    <div>
                        <div class="cl-card-title">Photos</div>
                        <div class="cl-card-desc">Listings with photos get 3× more views</div>
                    </div>
                </div>
                <span class="cl-card-badge">UP TO 10</span>
            </div>
            <div class="cl-card-body">
                <div class="cl-upload-zone" id="uploadZone">
                    <input type="file" id="images" name="images[]" multiple accept="image/*">
                    <div class="cl-upload-zone-icon">🖼️</div>
                    <p class="cl-upload-zone-text">Click to upload or drag &amp; drop</p>
                    <p class="cl-upload-zone-sub">JPG, PNG, WEBP · Max 10 photos · First photo = cover</p>
                </div>
                <div id="previews" class="cl-preview-grid"></div>
            </div>
        </div>

        {{-- ── CARD 3: Origin & Dealer ── --}}
        <div class="cl-card">
            <div class="cl-card-head">
                <div class="cl-card-head-left">
                    <div class="cl-card-icon">🌍</div>
                    <div>
                        <div class="cl-card-title">Origin &amp; Source</div>
                        <div class="cl-card-desc">Where the car is from</div>
                    </div>
                </div>
                <span class="cl-card-badge">REQUIRED</span>
            </div>
            <div class="cl-card-body">
                <div class="cl-grid">
                    <div class="cl-field">
                        <label>Origin <span class="cl-req">*</span></label>
                        <div class="cl-select-wrap">
                            <select name="origin" required>
                                <option value="">Select</option>
                                <option value="kenya"  {{ old('origin') == 'kenya'  ? 'selected' : '' }}>Kenya</option>
                                <option value="import" {{ old('origin') == 'import' ? 'selected' : '' }}>Import</option>
                            </select>
                        </div>
                    </div>
                    <div class="cl-field">
                        <label>Dealer / Source</label>
                        <input type="text" name="source" placeholder="e.g., Auto Mart" value="{{ old('source') }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── CARD 4: Specifications ── --}}
        <div class="cl-card">
            <div class="cl-card-head">
                <div class="cl-card-head-left">
                    <div class="cl-card-icon">⚙️</div>
                    <div>
                        <div class="cl-card-title">Specifications</div>
                        <div class="cl-card-desc">Technical details &amp; performance</div>
                    </div>
                </div>
                <span class="cl-card-badge optional">OPTIONAL</span>
            </div>
            <div class="cl-card-body">
                <div class="cl-grid">
                    <div class="cl-field">
                        <label>Mileage (km)</label>
                        <input type="text" name="mileage" placeholder="50,000" value="{{ old('mileage') }}">
                    </div>
                    <div class="cl-field">
                        <label>Engine (cc)</label>
                        <input type="text" name="engine_size" placeholder="2000" value="{{ old('engine_size') }}">
                    </div>
                    <div class="cl-field">
                        <label>Fuel Type</label>
                        <input type="text" name="fuel_type" placeholder="Petrol" value="{{ old('fuel_type') }}">
                    </div>
                    <div class="cl-field">
                        <label>Horsepower</label>
                        <input type="text" name="horse_power" placeholder="150 hp" value="{{ old('horse_power') }}">
                    </div>
                    <div class="cl-field">
                        <label>Transmission</label>
                        <div class="cl-select-wrap">
                            <select name="transmission">
                                <option value="">Select</option>
                                @foreach(['Manual','Automatic','CVT'] as $t)
                                    <option {{ old('transmission') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cl-field">
                        <label>Drive</label>
                        <div class="cl-select-wrap">
                            <select name="drive">
                                <option value="">Select</option>
                                @foreach(['FWD','RWD','4WD','AWD'] as $d)
                                    <option {{ old('drive') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="cl-field" style="grid-column:1/-1">
                        <label>Availability</label>
                        <div class="cl-select-wrap">
                            <select name="availability">
                                <option value="">Select</option>
                                <option {{ old('availability') == 'Available'   ? 'selected' : '' }}>Available</option>
                                <option {{ old('availability') == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── CARD 5: Features ── --}}
        <div class="cl-card">
            <div class="cl-card-head">
                <div class="cl-card-head-left">
                    <div class="cl-card-icon">✨</div>
                    <div>
                        <div class="cl-card-title">Features</div>
                        <div class="cl-card-desc">Select all that apply</div>
                    </div>
                </div>
                <span class="cl-card-badge optional">OPTIONAL</span>
            </div>
            <div class="cl-card-body">
                <div class="cl-feats">
                    @php
                        $features = [
                            'heatedSeats'              => ['🔥', 'Heated Seats'],
                            'powerWindows'             => ['🪟', 'Power Windows'],
                            'steeringControls'         => ['🎮', 'Steering Controls'],
                            'phoneConnectivity'        => ['📱', 'Phone Connectivity'],
                            'autoStartStop'            => ['⚡', 'Auto Start/Stop'],
                            'isofixAnchors'            => ['👶', 'ISOFIX Anchors'],
                            'keylessEntryAndPushStart' => ['🔑', 'Keyless Entry'],
                        ];
                    @endphp
                    @foreach($features as $key => [$icon, $label])
                        <label class="cl-feat-item{{ old("specification.{$key}") ? ' checked' : '' }}" id="feat-{{ $key }}">
                            <input type="checkbox"
                                   name="specification[{{ $key }}]"
                                   value="1"
                                   {{ old("specification.{$key}") ? 'checked' : '' }}
                                   onchange="toggleFeat(this)">
                            <span class="cl-feat-tick">✓</span>
                            <span>{{ $icon }} {{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ── CARD 6: Running Costs ── --}}
        <div class="cl-card">
            <div class="cl-card-head">
                <div class="cl-card-head-left">
                    <div class="cl-card-icon">💰</div>
                    <div>
                        <div class="cl-card-title">Running Costs</div>
                        <div class="cl-card-desc">Help buyers understand total cost of ownership</div>
                    </div>
                </div>
                <span class="cl-card-badge optional">OPTIONAL</span>
            </div>
            <div class="cl-card-body">
                <div class="cl-grid">
                    <div class="cl-field" style="grid-column:1/-1">
                        <label>Annual Insurance (KSh)</label>
                        <div class="cl-price-wrap">
                            <span class="cl-price-prefix">KSh</span>
                            <input type="text" name="running_cost[insuranceAnnualCost]" placeholder="50,000" value="{{ old('running_cost.insuranceAnnualCost') }}">
                        </div>
                    </div>
                    <div class="cl-field">
                        <label>Fuel Urban (L/100km)</label>
                        <input type="text" name="running_cost[fuelUrban]" placeholder="8.5" value="{{ old('running_cost.fuelUrban') }}">
                    </div>
                    <div class="cl-field">
                        <label>Fuel Highway (L/100km)</label>
                        <input type="text" name="running_cost[fuelHighway]" placeholder="6.2" value="{{ old('running_cost.fuelHighway') }}">
                    </div>
                </div>
                <div class="cl-info-row">
                    <span class="cl-info-icon">💡</span>
                    <span>Listings with running costs get <strong>40% more inquiries</strong> — buyers love knowing what they're signing up for.</span>
                </div>
            </div>
        </div>

        {{-- ── CARD 7: Report ── --}}
        <div class="cl-card">
            <div class="cl-card-head">
                <div class="cl-card-head-left">
                    <div class="cl-card-icon">📄</div>
                    <div>
                        <div class="cl-card-title">Inspection Report</div>
                        <div class="cl-card-desc">PDF report builds buyer confidence</div>
                    </div>
                </div>
                <span class="cl-card-badge optional">OPTIONAL</span>
            </div>
            <div class="cl-card-body">
                <label class="cl-file-label" id="reportLabel">
                    <input type="file" name="report" accept="application/pdf" onchange="updateFileName(this)">
                    <span style="font-size:1.4rem">📎</span>
                    <div>
                        <div>Attach PDF report</div>
                        <div class="cl-file-name" id="reportName">No file chosen</div>
                    </div>
                </label>
            </div>
        </div>

        {{-- ── Submit ── --}}
        <div class="cl-submit-card">
            <div class="cl-submit-info">
                <strong>Ready to publish?</strong>
                Your listing goes live instantly · 100% free
            </div>
            <button type="submit" class="cl-btn-submit">List My Car →</button>
        </div>

    </form>
</div>

<script>
/* ── Photo upload ── */
let files = [], mainIdx = 0;
const input    = document.getElementById('images');
const previews = document.getElementById('previews');
const zone     = document.getElementById('uploadZone');

input.addEventListener('change', e => addFiles(e.target.files));
zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag'); });
zone.addEventListener('dragleave', ()  => zone.classList.remove('drag'));
zone.addEventListener('drop', e => {
    e.preventDefault();
    zone.classList.remove('drag');
    addFiles(e.dataTransfer.files);
});

function addFiles(newFiles) {
    const allowed = ['image/jpeg','image/jpg','image/png','image/webp'];
    for (let f of newFiles) {
        if (files.length >= 10) { alert('Maximum 10 photos allowed'); break; }
        if (allowed.includes(f.type)) files.push(f);
        else alert(`${f.name} is not supported`);
    }
    render();
}

function render() {
    previews.innerHTML = '';
    files.forEach((f, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = `cl-prev-item${i === mainIdx ? ' main' : ''}`;
            div.innerHTML = `
                <img src="${e.target.result}" alt="Photo ${i+1}">
                <div class="cl-prev-overlay">
                    <button type="button" class="cl-prev-del" onclick="event.stopPropagation();removeImg(${i})">×</button>
                </div>
                ${i === mainIdx
                    ? '<span class="cl-main-tag">COVER</span>'
                    : '<span class="cl-set-main-tag">Set cover</span>'}
            `;
            if (i !== mainIdx) {
                div.onclick = () => { mainIdx = i; render(); };
            }
            previews.appendChild(div);
        };
        reader.readAsDataURL(f);
    });
    const dt = new DataTransfer();
    files.forEach(f => dt.items.add(f));
    input.files = dt.files;
}

function removeImg(i) {
    files.splice(i, 1);
    if      (i === mainIdx && files.length > 0) mainIdx = 0;
    else if (i < mainIdx)                       mainIdx--;
    else if (mainIdx >= files.length)           mainIdx = Math.max(0, files.length - 1);
    render();
}

/* ── Feature checkboxes ── */
function toggleFeat(input) {
    input.closest('.cl-feat-item').classList.toggle('checked', input.checked);
}

/* ── File name display ── */
function updateFileName(input) {
    const label = document.getElementById('reportName');
    label.textContent = input.files[0] ? input.files[0].name : 'No file chosen';
}
</script>

@endsection
