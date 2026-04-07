@extends('layouts.app')

@section('content')

@php
/*
 * ─────────────────────────────────────────────
 *  HELPER: resolve video for a car model
 *  Returns ['has_video' => bool, 'url' => string|null]
 * ─────────────────────────────────────────────
 */
function resolveVideo($car): array {
    $raw = trim((string) ($car->video ?? ''));
    if ($raw === '' || $raw === 'null') {
        return ['has_video' => false, 'url' => null];
    }
    // Avoid double-prefixing if the value already contains "storage/"
    $path = str_starts_with($raw, 'storage/') ? $raw : 'storage/' . $raw;
    return ['has_video' => true, 'url' => asset($path)];
}
@endphp

{{-- ── Font preload (replaces slow @import inside CSS) ── --}}
@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style"
      href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;1,600&family=Outfit:wght@300;400;500;600&display=swap"
      onload="this.rel='stylesheet'">
<noscript>
<link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;1,600&family=Outfit:wght@300;400;500;600&display=swap">
</noscript>
@endpush

<div class="vp">

    {{-- ╔══════════════════════════════════════╗
         ║           HERO / SEARCH             ║
         ╚══════════════════════════════════════╝ --}}
    <header class="vp-hero">
        <div class="vp-wrap">

            <div class="vp-hero-text">
                <p class="vp-eyebrow">
                    <span class="vp-dot"></span>
                    {{ $cars->count() }} vehicles available
                </p>
                <h1 class="vp-title">Find your <em>perfect</em> car.</h1>
                <p class="vp-sub">Browse quality vehicles from trusted dealers across Kenya.</p>
            </div>

            {{-- Search + Currency + Price pills --}}
            <div class="vp-search-bar">
                <div class="vp-search-left">
                    <svg class="vp-search-ico" width="17" height="17" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.2">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input id="js-search" type="text" placeholder="Make, model, keyword…"
                           oninput="VP.filter()" autocomplete="off">

                    <div class="vp-currency">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="2" y1="12" x2="22" y2="12"/>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                        </svg>
                        <select id="js-currency" onchange="VP.currency()">
                            <option value="KES" data-rate="1"       data-sym="KSh">KES</option>
                            <option value="USD" data-rate="0.0077"  data-sym="$">USD</option>
                            <option value="GBP" data-rate="0.0061"  data-sym="£">GBP</option>
                            <option value="EUR" data-rate="0.0071"  data-sym="€">EUR</option>
                            <option value="ZAR" data-rate="0.14"    data-sym="R">ZAR</option>
                            <option value="AED" data-rate="0.028"   data-sym="AED">AED</option>
                        </select>
                    </div>
                </div>

                <div class="vp-divider"></div>

                <div class="vp-pills-wrap">
                    <span class="vp-pills-lbl">Budget</span>
                    <div class="vp-pills">
                        <button class="vp-pill active" data-min="0"        data-max="99000000" onclick="VP.pill(this,0,99000000)">All</button>
                        <button class="vp-pill"        data-min="0"        data-max="500000"   onclick="VP.pill(this,0,500000)">Under 500K</button>
                        <button class="vp-pill"        data-min="500000"   data-max="1000000"  onclick="VP.pill(this,500000,1000000)">500K–1M</button>
                        <button class="vp-pill"        data-min="1000000"  data-max="2000000"  onclick="VP.pill(this,1000000,2000000)">1M–2M</button>
                        <button class="vp-pill"        data-min="2000000"  data-max="3000000"  onclick="VP.pill(this,2000000,3000000)">2M–3M</button>
                        <button class="vp-pill"        data-min="3000000"  data-max="5000000"  onclick="VP.pill(this,3000000,5000000)">3M–5M</button>
                        <button class="vp-pill"        data-min="5000000"  data-max="10000000" onclick="VP.pill(this,5000000,10000000)">5M–10M</button>
                        <button class="vp-pill"        data-min="10000000" data-max="99000000" onclick="VP.pill(this,10000000,99000000)">Above 10M</button>
                    </div>
                </div>
            </div>

            {{-- Quick filters --}}
            <div class="vp-quick">
                <button class="vp-qbtn active" data-filter="all"       onclick="VP.quick('all')">All Vehicles</button>
                <button class="vp-qbtn"        data-filter="local"     onclick="VP.quick('local')">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    In Kenya
                </button>
                <button class="vp-qbtn"        data-filter="imports"   onclick="VP.quick('imports')">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                    Imports
                </button>
                <button class="vp-qbtn"        data-filter="verified"  onclick="VP.quick('verified')">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Verified
                </button>
                <button class="vp-qbtn vp-qbtn--video" data-filter="has-video" onclick="VP.quick('has-video')">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                    Has Video
                </button>

                <button class="vp-adv-toggle" id="js-adv-toggle" onclick="VP.toggleAdv()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/>
                        <line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/>
                        <line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/>
                        <line x1="17" y1="16" x2="23" y2="16"/>
                    </svg>
                    <span id="js-adv-label">More Filters</span>
                    <svg class="vp-chev" id="js-adv-chev" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
            </div>

            {{-- Advanced filters panel --}}
            <div class="vp-adv" id="js-adv-panel">
                <div class="vp-adv-grid">
                    <div class="vp-fg">
                        <label class="vp-fl">Make</label>
                        <select id="js-make" class="vp-fs" onchange="VP.filter()">
                            <option value="">All Makes</option>
                            <option value="toyota">Toyota</option>
                            <option value="honda">Honda</option>
                            <option value="nissan">Nissan</option>
                            <option value="mazda">Mazda</option>
                            <option value="subaru">Subaru</option>
                            <option value="mercedes">Mercedes-Benz</option>
                            <option value="bmw">BMW</option>
                            <option value="audi">Audi</option>
                            <option value="volkswagen">Volkswagen</option>
                            <option value="ford">Ford</option>
                            <option value="landrover">Land Rover</option>
                            <option value="mitsubishi">Mitsubishi</option>
                        </select>
                    </div>
                    <div class="vp-fg">
                        <label class="vp-fl">Body Type</label>
                        <select id="js-body" class="vp-fs" onchange="VP.filter()">
                            <option value="">All Types</option>
                            <option value="suv">SUV</option>
                            <option value="sedan">Sedan</option>
                            <option value="hatchback">Hatchback</option>
                            <option value="pickup">Pickup</option>
                        </select>
                    </div>
                    <div class="vp-fg">
                        <label class="vp-fl">Year From</label>
                        <select id="js-year-from" class="vp-fs" onchange="VP.filter()">
                            <option value="">Any Year</option>
                            @for($y = 2024; $y >= 2000; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="vp-fg">
                        <label class="vp-fl">Year To</label>
                        <select id="js-year-to" class="vp-fs" onchange="VP.filter()">
                            <option value="">Any Year</option>
                            @for($y = 2024; $y >= 2000; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="vp-fg">
                        <label class="vp-fl">Transmission</label>
                        <select id="js-trans" class="vp-fs" onchange="VP.filter()">
                            <option value="">All</option>
                            <option value="automatic">Automatic</option>
                            <option value="manual">Manual</option>
                        </select>
                    </div>
                    <div class="vp-fg">
                        <label class="vp-fl">Fuel Type</label>
                        <select id="js-fuel" class="vp-fs" onchange="VP.filter()">
                            <option value="">All</option>
                            <option value="petrol">Petrol</option>
                            <option value="diesel">Diesel</option>
                            <option value="hybrid">Hybrid</option>
                            <option value="electric">Electric</option>
                        </select>
                    </div>
                    <div class="vp-fg">
                        <label class="vp-fl">Min Mileage (km)</label>
                        <input id="js-mil-from" type="number" class="vp-fs" placeholder="e.g. 0" oninput="VP.filter()">
                    </div>
                    <div class="vp-fg">
                        <label class="vp-fl">Max Mileage (km)</label>
                        <input id="js-mil-to" type="number" class="vp-fs" placeholder="e.g. 150,000" oninput="VP.filter()">
                    </div>
                    <div class="vp-fg vp-fg--action">
                        <button class="vp-clear-btn" onclick="VP.clear()">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            Clear All
                        </button>
                    </div>
                </div>
            </div>

        </div>{{-- /wrap --}}
    </header>


    {{-- ╔══════════════════════════════════════╗
         ║         RESULTS SECTION             ║
         ╚══════════════════════════════════════╝ --}}
    <section class="vp-results vp-wrap">

        {{-- Toolbar --}}
        <div class="vp-toolbar">
            <div class="vp-count-wrap">
                <span class="vp-count" id="js-count">{{ $cars->count() }}</span>
                <span class="vp-count-lbl">vehicles found</span>
            </div>
            <div class="vp-toolbar-right">
                <div class="vp-sort-wrap">
                    <label>Sort by</label>
                    <select id="js-sort" class="vp-sort-sel" onchange="VP.sort()">
                        <option value="featured">Featured</option>
                        <option value="price-low">Price: Low → High</option>
                        <option value="price-high">Price: High → Low</option>
                        <option value="year-new">Newest First</option>
                        <option value="year-old">Oldest First</option>
                        <option value="mileage-low">Lowest Mileage</option>
                    </select>
                </div>
                <div class="vp-view-toggle">
                    <button class="vp-view active" data-view="grid" onclick="VP.view('grid')" title="Grid">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    </button>
                    <button class="vp-view" data-view="list" onclick="VP.view('list')" title="List">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><rect x="3" y="4" width="2" height="4"/><rect x="3" y="10" width="2" height="4"/><rect x="3" y="16" width="2" height="4"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Cards grid --}}
        <div class="vp-grid" id="js-grid">
            @forelse($cars as $car)
                @php
                    /* ── Images ── */
                    $rawImages = $car->images ?? null;
                    $images    = $rawImages
                        ? (is_string($rawImages) ? json_decode($rawImages, true) : (array) $rawImages)
                        : [];
                    $images    = array_filter((array) $images); // drop nulls / empty strings
                    $mainImage = count($images)
                        ? asset('storage/' . ltrim($images[0], '/'))
                        : 'https://via.placeholder.com/600x400/f5ede0/9b8b7e?text=No+Photo';

                    /* ── Video ── */
                    $videoRaw  = trim((string) ($car->video ?? ''));
                    $hasVideo  = ($videoRaw !== '' && $videoRaw !== 'null' && $videoRaw !== '0');
                    $videoPath = $hasVideo
                        ? (str_starts_with($videoRaw, 'storage/') ? $videoRaw : 'storage/' . $videoRaw)
                        : null;
                    $videoUrl  = $hasVideo ? asset($videoPath) : '';

                    /* ── Misc ── */
                    $isVerified = $car->user && $car->user->is_verified;
                    $isFeatured = (bool) ($car->featured ?? false);
                    $carPrice   = (int)   ($car->price   ?? 0);
                    $carMileage = (int)   ($car->mileage ?? 0);
                    $carYear    = (int)   ($car->year    ?? date('Y'));
                    $carName    = $car->name ?? 'Vehicle';
                    $carMake    = strtolower($car->make ?? '');
                    $carTrans   = strtolower($car->transmission_type ?? 'Auto');
                    $carFuel    = strtolower($car->fuel_type ?? 'Petrol');
                    $carBody    = strtolower($car->body_type ?? '');
                    $carCat     = strtolower($car->category ?? 'local');
                    $carLoc     = $car->location ?? 'Kenya';
                    $carId      = $car->id ?? 0;
                @endphp

                <article class="vp-card"
                    data-make="{{ $carMake }}"
                    data-year="{{ $carYear }}"
                    data-price="{{ $carPrice }}"
                    data-mileage="{{ $carMileage }}"
                    data-category="{{ $carCat }}"
                    data-body="{{ $carBody }}"
                    data-trans="{{ $carTrans }}"
                    data-fuel="{{ $carFuel }}"
                    data-verified="{{ $isVerified ? 'true' : 'false' }}"
                    data-has-video="{{ $hasVideo ? 'true' : 'false' }}"
                    data-name="{{ strtolower($carName) }}">

                    {{-- ── Image wrapper ── --}}
                    <div class="vp-card-img">
                        <a href="{{ route('vehicles.show', $carId) }}" class="vp-img-link" tabindex="-1">
                            <img src="{{ $mainImage }}"
                                 alt="{{ $carName }}"
                                 loading="lazy"
                                 onerror="this.src='https://via.placeholder.com/600x400/f5ede0/9b8b7e?text=No+Photo'">
                        </a>

                        {{-- Video play button — rendered ONLY when car has a video --}}
                        @if($hasVideo)
                        <button class="vp-play-btn"
                                onclick="VP.openVideo(event,'{{ addslashes($videoUrl) }}','{{ addslashes($carName) }}')"
                                aria-label="Watch video walkthrough">
                            <span class="vp-play-ripple"></span>
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        </button>
                        @endif

                        {{-- Badges --}}
                        <div class="vp-badges">
                            @if($isVerified)
                                <span class="vp-badge vp-badge--v">
                                    <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                    Verified
                                </span>
                            @endif
                            @if($isFeatured)
                                <span class="vp-badge vp-badge--f">Featured</span>
                            @endif
                            @if($hasVideo)
                                <span class="vp-badge vp-badge--vid">
                                    <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                                    Video
                                </span>
                            @endif
                        </div>

                        @if(count($images) > 1)
                        <div class="vp-img-count">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                            {{ count($images) }}
                        </div>
                        @endif
                    </div>

                    {{-- ── Card body ── --}}
                    <div class="vp-card-body">
                        <div class="vp-card-head">
                            <div class="vp-card-name-wrap">
                                <h3 class="vp-car-name">
                                    <a href="{{ route('vehicles.show', $carId) }}">{{ $carName }}</a>
                                </h3>
                                <span class="vp-car-year">{{ $carYear }}</span>
                            </div>
                            <div class="vp-price" data-base="{{ $carPrice }}">
                                KSh {{ number_format($carPrice) }}
                            </div>
                        </div>

                        <div class="vp-specs">
                            <span class="vp-spec">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ number_format($carMileage) }} km
                            </span>
                            <span class="vp-dot-sep"></span>
                            <span class="vp-spec">{{ $carTrans }}</span>
                            <span class="vp-dot-sep"></span>
                            <span class="vp-spec">{{ ucfirst($carFuel) }}</span>
                        </div>

                        <div class="vp-card-foot">
                            <span class="vp-loc">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $carLoc }}
                            </span>
                            <a href="{{ route('vehicles.show', $carId) }}" class="vp-details-link">View details →</a>
                        </div>

                        {{-- Video teaser strip --}}
                        @if($hasVideo)
                        <button class="vp-video-strip"
                                onclick="VP.openVideo(event,'{{ addslashes($videoUrl) }}','{{ addslashes($carName) }}')">
                            <span class="vp-vs-icon">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            </span>
                            <span>Watch video walkthrough</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                        @endif

                        {{-- Report --}}
                        @if($car->report ?? false)
                        <div class="vp-report-wrap">
                            @auth
                                @php
                                    $pmt = \App\Models\ReportPayment::where('car_id', $carId)
                                          ->where('user_id', auth()->id())
                                          ->latest()->first();
                                @endphp
                                @if($pmt && $pmt->status === 'verified')
                                    <a href="{{ route('vehicles.report', $carId) }}" class="vp-report-btn vp-report-btn--ok">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        View Report
                                    </a>
                                @elseif($pmt && $pmt->status === 'pending')
                                    <button class="vp-report-btn vp-report-btn--pend"
                                            onclick="VP.openPay(event,{{ $carId }},{{ $car->report_price ?? 0 }},'{{ addslashes($carName) }}')">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        Pending Verification
                                    </button>
                                @else
                                    <button class="vp-report-btn"
                                            onclick="VP.openPay(event,{{ $carId }},{{ $car->report_price ?? 0 }},'{{ addslashes($carName) }}')">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        @if($car->report_price) Buy Report · KSh {{ number_format($car->report_price) }}
                                        @else Buy Report @endif
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('sell') }}?redirect={{ urlencode(request()->url()) }}" class="vp-report-btn">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    @if($car->report_price) Buy Report · KSh {{ number_format($car->report_price) }}
                                    @else Buy Report @endif
                                </a>
                            @endauth
                        </div>
                        @endif
                    </div>
                </article>

            @empty
                <div class="vp-empty">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <h3>No vehicles found</h3>
                    <p>Try adjusting your search or clearing the filters</p>
                    <button class="vp-btn-primary" onclick="VP.clear()">Clear Filters</button>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <nav class="vp-pager" aria-label="Pagination">
            <button class="vp-page-nav" aria-label="Previous" disabled>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="vp-page-num active">1</button>
            <button class="vp-page-num">2</button>
            <button class="vp-page-num">3</button>
            <span class="vp-page-ell">…</span>
            <button class="vp-page-num">10</button>
            <button class="vp-page-nav" aria-label="Next">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </nav>

    </section>{{-- /results --}}
</div>{{-- /vp --}}


{{-- ╔══════════════════════════════════════╗
     ║         VIDEO MODAL                 ║
     ╚══════════════════════════════════════╝ --}}
<div id="vp-video-modal" class="vpm-overlay" role="dialog" aria-modal="true" aria-label="Video player"
     onclick="if(event.target===this)VP.closeVideo()">
    <div class="vpm-box">
        <div class="vpm-header">
            <div class="vpm-title-row">
                <span class="vpm-ico">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                </span>
                <span id="vpm-name" class="vpm-name">Video Walkthrough</span>
            </div>
            <button class="vpm-close" onclick="VP.closeVideo()" aria-label="Close">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <div class="vpm-stage">
            <video id="vpm-video" controls preload="metadata" playsinline>
                <source id="vpm-src" src="" type="video/mp4">
                Your browser does not support video playback.
            </video>
            <div id="vpm-overlay" class="vpm-play-overlay" onclick="VP.startVideo()">
                <div class="vpm-big-play">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                </div>
                <p class="vpm-hint">Tap to play</p>
            </div>
        </div>

        <div class="vpm-footer">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 8 12 12 14 14"/></svg>
            Full walkthrough · exterior &amp; interior tour
        </div>
    </div>
</div>


{{-- ╔══════════════════════════════════════╗
     ║      M-PESA PAYMENT MODAL           ║
     ╚══════════════════════════════════════╝ --}}
<div id="vp-mpesa-modal" class="mpm-overlay" onclick="if(event.target===this)VP.closePay()">
    <div class="mpm-box">

        {{-- Step 1: Instructions --}}
        <div id="mpm-s1" class="mpm-step active">
            <div class="mpm-header">
                <div class="mpm-logo">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                </div>
                <div>
                    <h2 class="mpm-title">Pay via M-Pesa</h2>
                    <p class="mpm-sub" id="mpm-car-name">Vehicle Report</p>
                </div>
                <button class="mpm-x" onclick="VP.closePay()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <div class="mpm-amount">
                <span>Amount to Pay</span>
                <strong id="mpm-amount-display">KSh 0</strong>
            </div>

            <h3 class="mpm-steps-title">How to Pay</h3>
            <ol class="mpm-steps">
                <li><span class="mpm-n">1</span><span>Open <strong>M-Pesa</strong> on your phone</span></li>
                <li><span class="mpm-n">2</span><span>Select <strong>Lipa na M-Pesa → Paybill</strong></span></li>
                <li>
                    <span class="mpm-n">3</span>
                    <span>Business No: <strong class="mpm-hl" onclick="VP.copy('247247')">247247</strong>
                    <button class="mpm-copy" onclick="VP.copy('247247')">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    </button></span>
                </li>
                <li>
                    <span class="mpm-n">4</span>
                    <span>Account No: <strong class="mpm-hl" id="mpm-acct" onclick="VP.copyAcct()">RPT-0</strong>
                    <button class="mpm-copy" onclick="VP.copyAcct()">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    </button></span>
                </li>
                <li><span class="mpm-n">5</span><span>Amount: <strong class="mpm-hl" id="mpm-amount-inline">0</strong></span></li>
                <li><span class="mpm-n">6</span><span>Enter PIN and confirm</span></li>
            </ol>

            <div class="mpm-note">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                You'll receive an M-Pesa confirmation SMS with a transaction code.
            </div>

            <button class="mpm-next-btn" onclick="VP.payStep(2)">
                I've Paid — Enter Code
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>

        {{-- Step 2: Enter code --}}
        <div id="mpm-s2" class="mpm-step">
            <div class="mpm-header">
                <button class="mpm-back" onclick="VP.payStep(1)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <div>
                    <h2 class="mpm-title">Enter M-Pesa Code</h2>
                    <p class="mpm-sub">Confirm your payment</p>
                </div>
                <button class="mpm-x" onclick="VP.closePay()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>

            <label class="mpm-lbl">M-Pesa Transaction Code</label>
            <p class="mpm-hint">From your confirmation SMS, e.g. <strong>SJK1AB2CD3</strong></p>
            <input id="mpm-code" type="text" class="mpm-code-input" placeholder="e.g. SJK1AB2CD3"
                   maxlength="12" oninput="this.value=this.value.toUpperCase().replace(/[^A-Z0-9]/g,'');VP.hideErr()"
                   autocomplete="off" autocapitalize="characters">
            <div id="mpm-err" class="mpm-err hidden">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span id="mpm-err-txt">Please enter a valid M-Pesa code</span>
            </div>

            <label class="mpm-lbl" style="margin-top:18px">Your Phone Number</label>
            <p class="mpm-hint">We'll send your report access to this number</p>
            <div class="mpm-phone-row">
                <span class="mpm-prefix">+254</span>
                <input id="mpm-phone" type="tel" class="mpm-phone-inp"
                       placeholder="7XX XXX XXX" maxlength="9"
                       oninput="this.value=this.value.replace(/[^0-9]/g,'')">
            </div>

            <div class="mpm-summary">
                <div class="mpm-sum-row"><span>Vehicle</span><strong id="mpm-sum-car">—</strong></div>
                <div class="mpm-sum-row"><span>Amount</span><strong id="mpm-sum-amt">—</strong></div>
                <div class="mpm-sum-row"><span>Paybill</span><strong>247247</strong></div>
            </div>

            <button class="mpm-submit-btn" id="mpm-submit" onclick="VP.submitPay()">
                <span id="mpm-submit-txt">Verify &amp; Get Report</span>
                <svg id="mpm-submit-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <svg id="mpm-spinner" class="mpm-spin hidden" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
            </button>
        </div>

        {{-- Step 3: Success --}}
        <div id="mpm-s3" class="mpm-step">
            <div class="mpm-success">
                <div class="mpm-success-ico">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <h2>Payment Verified!</h2>
                <p>Your vehicle report is ready. View the full inspection details below.</p>
                <div class="mpm-detail-box">
                    <div class="mpm-detail-row"><span>Transaction</span><strong id="mpm-ok-code">—</strong></div>
                    <div class="mpm-detail-row"><span>Vehicle</span><strong id="mpm-ok-car">—</strong></div>
                </div>
                <a href="#" id="mpm-report-link" class="mpm-view-report">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    View Full Report
                </a>
                <button class="mpm-done" onclick="VP.closePay()">Close</button>
            </div>
        </div>

    </div>
</div>

{{-- Toast --}}
<div id="vp-toast" class="vp-toast">Copied!</div>


{{-- ═══════════════════════════════════════
     STYLES
     NOTE: Google Fonts are loaded via @push('head') above using
     rel="preload" for non-blocking font delivery. The @import
     that was here caused render-blocking — it has been removed.
═══════════════════════════════════════ --}}
<style>
/* ── Design tokens ── */
:root{
    --cream:      #faf6f0;
    --cream-dk:   #f2eade;
    --warm-white: #fffdf9;
    --acc:        #b83228;
    --acc-h:      #9e2820;
    --acc-light:  rgba(184,50,40,.08);
    --purple:     #b83228;
    --purple-lt:  rgba(91,33,182,.10);
    --ink:        #1c1712;
    --ink-md:     #5a4b3f;
    --ink-lt:     #9c8b7d;
    --border:     #e6dbd0;
    --border-lt:  #ede5db;
    --success:    #1f6b42;
    --warning-c:  #9a4e06;
    --shadow-s:   0 1px 4px rgba(28,23,18,.06);
    --shadow-m:   0 4px 18px rgba(28,23,18,.09);
    --shadow-l:   0 14px 44px rgba(28,23,18,.13);
    --r:          12px;
    --r-sm:       8px;
    --ease:       cubic-bezier(.4,0,.2,1);
    --tr:         all .22s var(--ease);

    /* Font stack with system fallbacks so text renders immediately
       before the web font arrives */
    --font-body:  'Outfit', ui-sans-serif, system-ui, -apple-system, sans-serif;
    --font-serif: 'Cormorant Garamond', Georgia, 'Times New Roman', serif;
}

*{margin:0;padding:0;box-sizing:border-box}
body{font-family:var(--font-body);color:var(--ink);background:var(--cream);line-height:1.6}
a{text-decoration:none;color:inherit}
button{font-family:var(--font-body);cursor:pointer}

/* ── Layout ── */
.vp{min-height:100vh}
.vp-wrap{max-width:1340px;margin:0 auto;padding:0 32px}

/* ── Hero ── */
.vp-hero{background:var(--cream-dk);padding:80px 32px 44px;border-bottom:1px solid var(--border)}
.vp-hero-text{text-align:center;margin-bottom:36px}
.vp-eyebrow{display:inline-flex;align-items:center;gap:8px;font-size:10.5px;font-weight:600;letter-spacing:2px;color:var(--acc);text-transform:uppercase;margin-bottom:18px}
.vp-dot{width:6px;height:6px;border-radius:50%;background:var(--acc);animation:vp-pulse 2s infinite}
@keyframes vp-pulse{0%,100%{opacity:1}50%{opacity:.35}}
.vp-title{font-family:var(--font-serif);font-size:clamp(36px,5.5vw,66px);font-weight:600;line-height:1.05;color:var(--ink);margin-bottom:14px;letter-spacing:-.5px}
.vp-title em{font-style:italic;color:var(--acc)}
.vp-sub{font-size:16px;color:var(--ink-md);font-weight:300}

/* ── Search bar ── */
.vp-search-bar{max-width:1100px;margin:0 auto 22px;display:flex;align-items:center;background:var(--warm-white);border:1.5px solid var(--border);border-radius:var(--r);box-shadow:var(--shadow-s);overflow:hidden}
.vp-search-left{display:flex;align-items:center;gap:0;flex-shrink:0;padding:0 14px 0 18px}
.vp-search-ico{color:var(--ink-lt);flex-shrink:0}
.vp-search-left input{border:none;outline:none;font-family:var(--font-body);font-size:14px;color:var(--ink);background:transparent;padding:15px 10px;min-width:200px}
.vp-search-left input::placeholder{color:var(--ink-lt)}
.vp-currency{display:flex;align-items:center;gap:6px;border-left:1px solid var(--border-lt);padding:13px 14px;flex-shrink:0}
.vp-currency svg{color:var(--ink-lt)}
.vp-currency select{border:none;outline:none;background:transparent;font-family:var(--font-body);font-size:13px;font-weight:500;color:var(--ink);cursor:pointer}
.vp-divider{width:1px;height:36px;background:var(--border);flex-shrink:0}
.vp-pills-wrap{flex:1;display:flex;align-items:center;gap:10px;padding:10px 16px;overflow-x:auto;scrollbar-width:none}
.vp-pills-wrap::-webkit-scrollbar{display:none}
.vp-pills-lbl{font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--ink-lt);white-space:nowrap;flex-shrink:0}
.vp-pills{display:flex;gap:6px;flex-shrink:0}
.vp-pill{padding:6px 13px;border:1.5px solid var(--border);border-radius:100px;background:var(--cream);font-size:12px;font-weight:500;color:var(--ink-md);transition:var(--tr);white-space:nowrap}
.vp-pill:hover{border-color:var(--acc);color:var(--acc);background:var(--acc-light)}
.vp-pill.active{background:var(--acc);color:#fff;border-color:var(--acc);box-shadow:0 2px 8px rgba(184,50,40,.2)}

/* ── Quick filters ── */
.vp-quick{max-width:1100px;margin:0 auto;display:flex;flex-wrap:wrap;align-items:center;gap:9px}
.vp-qbtn{padding:8px 16px;border:1.5px solid var(--border);border-radius:100px;background:var(--warm-white);font-size:12.5px;font-weight:500;color:var(--ink-md);display:flex;align-items:center;gap:5px;transition:var(--tr)}
.vp-qbtn:hover{border-color:var(--acc);color:var(--acc)}
.vp-qbtn.active{background:var(--acc);color:#fff;border-color:var(--acc)}
.vp-qbtn--video:hover,.vp-qbtn--video.active{background:var(--purple);border-color:var(--purple);color:#fff}
.vp-adv-toggle{padding:8px 16px;border:1.5px solid var(--border);border-radius:100px;background:var(--warm-white);font-size:12.5px;font-weight:500;color:var(--ink-md);display:flex;align-items:center;gap:7px;margin-left:auto;transition:var(--tr)}
.vp-adv-toggle:hover,.vp-adv-toggle.active{border-color:var(--acc);color:var(--acc)}
.vp-chev{transition:transform .3s var(--ease)}
.vp-chev.open{transform:rotate(180deg)}

/* ── Advanced filters ── */
.vp-adv{max-height:0;overflow:hidden;transition:max-height .4s var(--ease)}
.vp-adv.open{padding-top:26px}
.vp-adv-grid{max-width:1100px;margin:0 auto;display:grid;grid-template-columns:repeat(5,1fr);gap:13px;background:var(--warm-white);border:1.5px solid var(--border);border-radius:var(--r);padding:22px}
.vp-fg{display:flex;flex-direction:column;gap:7px}
.vp-fl{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.8px;color:var(--ink-lt)}
.vp-fs{width:100%;padding:10px 12px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-family:var(--font-body);font-size:13px;background:var(--cream);color:var(--ink);outline:none;appearance:auto;transition:var(--tr)}
.vp-fs:focus,.vp-fs:hover{border-color:var(--acc)}
.vp-fg--action{justify-content:flex-end;padding-top:24px}
.vp-clear-btn{padding:10px 16px;border:1.5px solid var(--border);border-radius:var(--r-sm);background:transparent;font-size:13px;font-weight:500;color:var(--ink-md);display:flex;align-items:center;gap:6px;transition:var(--tr)}
.vp-clear-btn:hover{background:var(--ink);color:#fff;border-color:var(--ink)}

/* ── Results section ── */
.vp-results{padding-top:40px;padding-bottom:80px}
.vp-toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;padding-bottom:22px;border-bottom:1px solid var(--border-lt)}
.vp-count-wrap{display:flex;align-items:baseline;gap:8px}
.vp-count{font-family:var(--font-serif);font-size:34px;font-weight:600;color:var(--acc)}
.vp-count-lbl{font-size:14px;color:var(--ink-md);font-weight:300}
.vp-toolbar-right{display:flex;align-items:center;gap:16px}
.vp-sort-wrap{display:flex;align-items:center;gap:9px}
.vp-sort-wrap label{font-size:13px;font-weight:500;color:var(--ink-lt)}
.vp-sort-sel{padding:9px 13px;border:1.5px solid var(--border);border-radius:var(--r-sm);font-family:var(--font-body);font-size:13px;background:var(--warm-white);color:var(--ink);outline:none;min-width:158px;transition:var(--tr)}
.vp-sort-sel:hover{border-color:var(--acc)}
.vp-view-toggle{display:flex;gap:2px;background:var(--cream-dk);border:1.5px solid var(--border);border-radius:var(--r-sm);padding:3px}
.vp-view{background:transparent;border:none;padding:7px 11px;border-radius:6px;color:var(--ink-lt);display:flex;align-items:center;justify-content:center;transition:var(--tr)}
.vp-view.active{background:var(--warm-white);color:var(--acc);box-shadow:var(--shadow-s)}

/* ── Grid ── */
.vp-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:48px}
.vp-grid.list-view{grid-template-columns:1fr}

/* ── Card ── */
.vp-card{background:var(--warm-white);border-radius:var(--r);overflow:hidden;border:1px solid var(--border-lt);box-shadow:var(--shadow-s);display:flex;flex-direction:column;transition:var(--tr);animation:vp-fadeup .35s var(--ease) both}
.vp-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-l);border-color:var(--border)}
.list-view .vp-card{display:grid;grid-template-columns:320px 1fr}
@keyframes vp-fadeup{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}
.vp-card:nth-child(1){animation-delay:0ms}.vp-card:nth-child(2){animation-delay:40ms}
.vp-card:nth-child(3){animation-delay:80ms}.vp-card:nth-child(4){animation-delay:120ms}
.vp-card:nth-child(5){animation-delay:160ms}.vp-card:nth-child(6){animation-delay:200ms}
.vp-card:nth-child(7){animation-delay:240ms}.vp-card:nth-child(8){animation-delay:280ms}
.vp-card:nth-child(9){animation-delay:320ms}.vp-card:nth-child(10){animation-delay:360ms}
.vp-card:nth-child(11){animation-delay:400ms}.vp-card:nth-child(12){animation-delay:440ms}

/* ── Card image
   KEY FIX: object-fit changed from "cover" (which crops) to "contain"
   (which shows the full image with no cropping). Background colour
   fills any letterbox area so it blends with the card. ── */
.vp-card-img{
    position:relative;
    aspect-ratio:4/3;
    background:var(--cream-dk);
    overflow:hidden;
    display:flex;
    align-items:center;
    justify-content:center;
}
.list-view .vp-card-img{aspect-ratio:auto;height:100%;min-height:220px}
.vp-img-link{display:block;width:100%;height:100%}
.vp-card-img img{
    width:100%;
    height:100%;
    object-fit:contain;          /* ← CHANGED: was "cover". Now shows full image, no cropping */
    object-position:center;
    background:var(--cream-dk);  /* letterbox colour matches card bg */
    transition:transform .4s var(--ease);
}
.vp-card:hover .vp-card-img img{transform:scale(1.04)}

/* Video play button */
.vp-play-btn{position:absolute;bottom:11px;right:11px;width:44px;height:44px;background:#b83228;border:2px solid rgba(255,255,255,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;z-index:10;backdrop-filter:blur(6px);transition:var(--tr);overflow:visible}
.vp-play-btn:hover{background:var(--purple);transform:scale(1.1);box-shadow:0 4px 20px #b83228}
.vp-play-btn svg{margin-left:2px;position:relative;z-index:1}
.vp-play-ripple{position:absolute;inset:-4px;border-radius:50%;border:2px solid #b83228;animation:vp-ripple 2s ease-out infinite}
@keyframes vp-ripple{0%{transform:scale(1);opacity:.7}100%{transform:scale(1.75);opacity:0}}

/* Badges */
.vp-badges{position:absolute;top:11px;left:11px;display:flex;flex-direction:column;gap:5px;z-index:10}
.vp-badge{padding:3px 8px;border-radius:4px;font-size:10px;font-weight:700;letter-spacing:.4px;display:inline-flex;align-items:center;gap:4px}
.vp-badge--v{background:var(--success);color:#fff}
.vp-badge--f{background:var(--warning-c);color:#fff}
.vp-badge--vid{background:var(--purple);color:#fff}
.vp-img-count{position:absolute;bottom:9px;left:9px;background:rgba(28,23,18,.6);color:#fff;padding:3px 8px;border-radius:4px;font-size:11px;font-weight:600;display:flex;align-items:center;gap:4px;backdrop-filter:blur(4px)}

/* Card body */
.vp-card-body{padding:17px;display:flex;flex-direction:column;gap:11px;flex:1}
.vp-card-head{display:flex;justify-content:space-between;align-items:flex-start;gap:10px}
.vp-car-name{font-size:13.5px;font-weight:600;line-height:1.4;margin-bottom:2px}
.vp-car-name a{color:var(--ink);transition:color .2s}
.vp-car-name a:hover{color:var(--acc)}
.vp-car-year{display:block;font-size:12px;color:var(--ink-lt);font-weight:400}
.vp-price{font-size:15.5px;font-weight:700;color:var(--acc);white-space:nowrap}
.vp-specs{display:flex;align-items:center;flex-wrap:wrap;gap:6px;padding:10px 0;border-top:1px solid var(--border-lt);border-bottom:1px solid var(--border-lt)}
.vp-spec{font-size:12px;color:var(--ink-md);display:flex;align-items:center;gap:4px}
.vp-spec svg{color:var(--ink-lt)}
.vp-dot-sep{width:3px;height:3px;border-radius:50%;background:var(--border)}
.vp-card-foot{display:flex;justify-content:space-between;align-items:center}
.vp-loc{display:flex;align-items:center;gap:4px;font-size:11.5px;color:var(--ink-lt)}
.vp-details-link{font-size:13px;font-weight:600;color:var(--acc);transition:var(--tr);letter-spacing:-.2px}
.vp-details-link:hover{letter-spacing:.2px}

/* Video teaser strip */
.vp-video-strip{display:flex;align-items:center;gap:9px;padding:9px 12px;background:var(--purple-lt);border:1.5px solid rgba(91,33,182,.2);border-radius:var(--r-sm);font-size:12px;font-weight:600;color:var(--purple);transition:var(--tr)}
.vp-video-strip:hover{background:rgba(91,33,182,.14);border-color:var(--purple);transform:translateY(-1px)}
.vp-vs-icon{width:26px;height:26px;background:var(--purple);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff}
.vp-vs-icon svg{margin-left:2px}
.vp-video-strip>span{flex:1;text-align:left}
.vp-video-strip>svg{flex-shrink:0;opacity:.55}

/* Report */
.vp-report-wrap{border-top:1px solid var(--border-lt);padding-top:11px}
.vp-report-btn{width:100%;background:var(--acc);color:#fff;border:none;padding:10px 14px;border-radius:var(--r-sm);font-size:12px;font-weight:600;display:flex;align-items:center;justify-content:center;gap:6px;text-decoration:none;transition:var(--tr)}
.vp-report-btn:hover{background:var(--acc-h);transform:translateY(-1px);box-shadow:var(--shadow-m)}
.vp-report-btn--ok{background:var(--success)}
.vp-report-btn--ok:hover{background:#165c38}
.vp-report-btn--pend{background:var(--ink-md);opacity:.8;cursor:default}

/* Empty state */
.vp-empty{grid-column:1/-1;text-align:center;padding:100px 20px}
.vp-empty svg{color:var(--ink-lt);margin-bottom:24px}
.vp-empty h3{font-family:var(--font-serif);font-size:28px;margin-bottom:10px}
.vp-empty p{color:var(--ink-md);margin-bottom:28px;font-weight:300}
.vp-btn-primary{background:var(--acc);color:#fff;border:none;padding:13px 26px;border-radius:var(--r-sm);font-size:14px;font-weight:600;transition:var(--tr)}
.vp-btn-primary:hover{background:var(--acc-h);transform:translateY(-2px)}

/* Pagination */
.vp-pager{display:flex;justify-content:center;align-items:center;gap:8px;padding:40px 0 20px}
.vp-page-nav,.vp-page-num{background:var(--warm-white);border:1.5px solid var(--border);width:40px;height:40px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-weight:500;color:var(--ink-md);transition:var(--tr);font-size:14px}
.vp-page-nav:hover:not(:disabled),.vp-page-num:hover{border-color:var(--acc);color:var(--acc)}
.vp-page-num.active{background:var(--acc);color:#fff;border-color:var(--acc)}
.vp-page-nav:disabled{opacity:.35;cursor:not-allowed}
.vp-page-ell{color:var(--ink-lt);padding:0 4px;font-size:16px}

/* List view overrides */
.list-view .vp-card-body{padding:22px}
.list-view .vp-car-name{font-size:16px}
.list-view .vp-price{font-size:20px}
.list-view .vp-specs{flex-wrap:nowrap;gap:14px}
.list-view .vp-report-btn{width:auto;padding:10px 18px}


/* ══ VIDEO MODAL ══ */
.vpm-overlay{display:none;position:fixed;inset:0;background:rgba(8,4,2,.82);backdrop-filter:blur(8px);z-index:9998;align-items:center;justify-content:center;padding:20px}
.vpm-overlay.open{display:flex}
.vpm-box{background:#0c0704;border-radius:16px;width:100%;max-width:860px;box-shadow:0 40px 100px rgba(0,0,0,.7),0 0 0 1px rgba(255,255,255,.06);overflow:hidden;animation:vpm-in .3s cubic-bezier(.34,1.56,.64,1);display:flex;flex-direction:column}
@keyframes vpm-in{from{opacity:0;transform:translateY(28px) scale(.96)}to{opacity:1;transform:translateY(0) scale(1)}}
.vpm-header{display:flex;align-items:center;gap:12px;padding:15px 18px;border-bottom:1px solid rgba(255,255,255,.07)}
.vpm-ico{width:32px;height:32px;background:var(--purple);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0}
.vpm-name{font-size:13.5px;font-weight:600;color:rgba(255,255,255,.86);flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.vpm-close{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);border-radius:8px;width:34px;height:34px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.55);flex-shrink:0;transition:var(--tr)}
.vpm-close:hover{background:rgba(184,50,40,.3);color:#fff;border-color:var(--acc)}
.vpm-stage{position:relative;background:#000;line-height:0}
.vpm-stage video{width:100%;max-height:520px;display:block;background:#000}
.vpm-play-overlay{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;background:rgba(0,0,0,.42);cursor:pointer;gap:13px;transition:opacity .25s}
.vpm-big-play{width:78px;height:78px;background:#b83228;border:3px solid rgba(255,255,255,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;transition:var(--tr);box-shadow:0 8px 30px rgba(91,33,182,.45)}
.vpm-big-play svg{margin-left:4px}
.vpm-play-overlay:hover .vpm-big-play{transform:scale(1.09);background:var(--purple)}
.vpm-hint{font-size:13px;color:rgba(255,255,255,.6);font-weight:500;letter-spacing:.4px}
.vpm-footer{display:flex;align-items:center;gap:8px;padding:12px 18px;border-top:1px solid rgba(255,255,255,.05);font-size:12px;color:rgba(255,255,255,.3)}
.vpm-footer svg{flex-shrink:0;color:var(--purple);opacity:.65}


/* ══ MPESA MODAL ══ */
.mpm-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.52);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;padding:16px}
.mpm-overlay.open{display:flex}
.mpm-box{background:#fff;border-radius:16px;width:100%;max-width:480px;box-shadow:0 24px 60px rgba(0,0,0,.22);overflow:hidden;animation:mpm-in .3s cubic-bezier(.34,1.56,.64,1);max-height:92vh;overflow-y:auto}
@keyframes mpm-in{from{opacity:0;transform:translateY(26px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
.mpm-step{display:none;padding:26px}.mpm-step.active{display:block}
.mpm-header{display:flex;align-items:center;gap:13px;margin-bottom:22px;padding-bottom:18px;border-bottom:1px solid #f0f0f0}
.mpm-logo{width:46px;height:46px;background:#e8f5e9;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#2e7d32;flex-shrink:0}
.mpm-title{font-size:17px;font-weight:700;color:#1a1a1a;margin:0}
.mpm-sub{font-size:13px;color:#718096;margin:3px 0 0}
.mpm-x{margin-left:auto;background:#f7fafc;border:1px solid #e2e8f0;border-radius:8px;width:34px;height:34px;display:flex;align-items:center;justify-content:center;color:#4a5568;flex-shrink:0;transition:all .2s}
.mpm-back{margin-right:auto;background:#f7fafc;border:1px solid #e2e8f0;border-radius:8px;width:34px;height:34px;display:flex;align-items:center;justify-content:center;color:#4a5568;flex-shrink:0;transition:all .2s}
.mpm-x:hover{background:#fed7d7;color:#c53030;border-color:#fc8181}
.mpm-back:hover{background:#ebf8ff;color:#2b6cb0;border-color:#90cdf4}
.mpm-amount{background:linear-gradient(135deg,var(--acc) 0%,var(--acc-h) 100%);border-radius:12px;padding:18px 22px;display:flex;justify-content:space-between;align-items:center;margin-bottom:22px;color:#fff}
.mpm-amount span{font-size:13px;opacity:.85;font-weight:500}
.mpm-amount strong{font-size:25px;font-weight:800;letter-spacing:-.5px}
.mpm-steps-title{font-size:13.5px;font-weight:700;color:#2d3748;margin-bottom:14px}
.mpm-steps{list-style:none;display:flex;flex-direction:column;gap:11px;margin-bottom:14px}
.mpm-steps li{display:flex;align-items:flex-start;gap:11px;font-size:13.5px;color:#4a5568;line-height:1.5}
.mpm-n{width:23px;height:23px;background:var(--acc);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;margin-top:1px}
.mpm-hl{color:var(--acc);font-weight:700;cursor:pointer}
.mpm-copy{background:#f7fafc;border:1px solid #e2e8f0;border-radius:4px;padding:2px 6px;color:#718096;margin-left:5px;display:inline-flex;align-items:center;transition:all .2s}
.mpm-copy:hover{background:#ebf8ff;color:#2b6cb0;border-color:#90cdf4}
.mpm-note{background:#fffbeb;border:1px solid #fcd34d;border-radius:8px;padding:11px 13px;font-size:13px;color:#92400e;display:flex;align-items:flex-start;gap:7px;line-height:1.5}
.mpm-next-btn{width:100%;background:var(--acc);color:#fff;border:none;padding:15px 22px;border-radius:10px;font-size:14.5px;font-weight:700;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:18px;transition:all .2s}
.mpm-next-btn:hover{background:var(--acc-h);transform:translateY(-1px);box-shadow:0 5px 18px rgba(184,50,40,.22)}
.mpm-lbl{display:block;font-size:12.5px;font-weight:700;color:#2d3748;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px}
.mpm-hint{font-size:13px;color:#718096;margin-bottom:9px;line-height:1.5}
.mpm-code-input{width:100%;padding:13px 15px;border:2px solid #e2e8f0;border-radius:10px;font-size:18px;font-weight:700;letter-spacing:2px;color:#1a1a1a;text-transform:uppercase;outline:none;transition:all .2s}
.mpm-code-input:focus{border-color:var(--acc);box-shadow:0 0 0 3px var(--acc-light)}
.mpm-phone-row{display:flex;align-items:center;border:2px solid #e2e8f0;border-radius:10px;overflow:hidden;transition:all .2s}
.mpm-phone-row:focus-within{border-color:var(--acc);box-shadow:0 0 0 3px var(--acc-light)}
.mpm-prefix{background:#f7fafc;padding:13px;font-size:14.5px;font-weight:700;color:#4a5568;border-right:2px solid #e2e8f0;white-space:nowrap}
.mpm-phone-inp{flex:1;border:none;outline:none;padding:13px;font-size:14.5px;color:#1a1a1a}
.mpm-err{display:flex;align-items:center;gap:6px;font-size:13px;color:#c53030;margin-top:8px;padding:8px 11px;background:#fff5f5;border-radius:6px;border:1px solid #fc8181}
.mpm-err.hidden{display:none!important}
.mpm-summary{background:#f7fafc;border:1px solid #e2e8f0;border-radius:10px;padding:13px 15px;margin:18px 0;display:flex;flex-direction:column;gap:8px}
.mpm-sum-row{display:flex;justify-content:space-between;font-size:13px;color:#4a5568}
.mpm-sum-row span{color:#718096}
.mpm-sum-row strong{font-weight:600;color:#1a1a1a}
.mpm-submit-btn{width:100%;background:#2e7d32;color:#fff;border:none;padding:15px 22px;border-radius:10px;font-size:14.5px;font-weight:700;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .2s}
.mpm-submit-btn:hover:not(:disabled){background:#1b5e20;transform:translateY(-1px);box-shadow:0 5px 18px rgba(46,125,50,.3)}
.mpm-submit-btn:disabled{opacity:.6;cursor:not-allowed}
.mpm-success{text-align:center;padding:8px 0}
.mpm-success-ico{width:78px;height:78px;background:linear-gradient(135deg,#e8f5e9,#c8e6c9);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;color:#2e7d32;animation:mpm-pop .5s cubic-bezier(.34,1.56,.64,1)}
@keyframes mpm-pop{from{transform:scale(0);opacity:0}to{transform:scale(1);opacity:1}}
.mpm-success h2{font-size:22px;font-weight:800;color:#1a1a1a;margin-bottom:9px}
.mpm-success p{font-size:13.5px;color:#718096;line-height:1.6;margin-bottom:22px}
.mpm-detail-box{background:#f7fafc;border-radius:10px;padding:15px;margin-bottom:22px;display:flex;flex-direction:column;gap:9px;text-align:left}
.mpm-detail-row{display:flex;justify-content:space-between;font-size:13.5px;color:#4a5568}
.mpm-detail-row span{color:#718096}
.mpm-detail-row strong{color:#1a1a1a}
.mpm-view-report{display:inline-flex;align-items:center;gap:8px;background:var(--acc);color:#fff;padding:13px 26px;border-radius:10px;font-size:14.5px;font-weight:700;transition:all .2s;margin-bottom:11px;width:100%;justify-content:center}
.mpm-view-report:hover{background:var(--acc-h);transform:translateY(-1px)}
.mpm-done{width:100%;background:transparent;border:1px solid #e2e8f0;border-radius:10px;padding:11px;font-size:14px;color:#718096;transition:all .2s;font-weight:500}
.mpm-done:hover{background:#f7fafc;color:#4a5568}
.mpm-spin{animation:mpm-spin .8s linear infinite}
@keyframes mpm-spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
.hidden{display:none!important}

/* Toast */
.vp-toast{position:fixed;bottom:30px;left:50%;transform:translateX(-50%) translateY(16px);background:#1c1712;color:#fff;padding:9px 20px;border-radius:8px;font-size:13.5px;font-weight:600;opacity:0;transition:all .28s ease;pointer-events:none;z-index:99999}
.vp-toast.show{opacity:1;transform:translateX(-50%) translateY(0)}

/* ── Responsive ── */
@media(max-width:1200px){.vp-grid{grid-template-columns:repeat(3,1fr)}.vp-adv-grid{grid-template-columns:repeat(4,1fr)}}
@media(max-width:992px){
    .vp-grid{grid-template-columns:repeat(2,1fr)}
    .vp-adv-grid{grid-template-columns:repeat(3,1fr)}
    .list-view .vp-card{grid-template-columns:1fr}
    .list-view .vp-card-img{aspect-ratio:4/3;min-height:auto;height:auto}
    .vp-search-bar{flex-direction:column;align-items:stretch}
    .vp-search-left{border-bottom:1px solid var(--border-lt);padding:4px 14px}
    .vp-divider{display:none}
    .vp-pills-wrap{padding:10px 14px}
    .vpm-box{max-width:100%}
}
@media(max-width:768px){
    .vp-hero{padding:56px 20px 30px}
    .vp-wrap{padding:0 20px}
    .vp-title{font-size:36px}
    .vp-adv-toggle{margin-left:0}
    .vp-adv-grid{grid-template-columns:repeat(2,1fr)}
    .vp-grid{grid-template-columns:1fr;gap:14px}
    .vp-toolbar{flex-direction:column;align-items:flex-start;gap:14px}
    .vp-toolbar-right{width:100%;justify-content:space-between}
    .vpm-stage video{max-height:260px}
}
@media(max-width:480px){
    .vp-title{font-size:30px}
    .vp-adv-grid{grid-template-columns:1fr}
    .vp-pills-lbl{display:none}
    .vp-qbtn{flex:1;justify-content:center}
}
@media(min-width:1600px){
    .vp-grid{grid-template-columns:repeat(5,1fr)}
    .vp-wrap{max-width:1580px}
}
</style>


{{-- ═══════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════ --}}
<script>
const VP = (() => {
    /* ── State ── */
    let priceMin       = 0;
    let priceMax       = 99000000;
    let quickFilter    = 'all';
    let advOpen        = false;
    let curRate        = 1;
    let curSym         = 'KSh';
    let curCode        = 'KES';
    let payCarId       = null;
    let payCarName     = null;
    let payCarPrice    = null;

    /* ── DOM helpers ── */
    const $  = id => document.getElementById(id);
    const $$ = sel => document.querySelectorAll(sel);

    /* ════════════════════════════════
       FILTERING
    ════════════════════════════════ */
    function filter() {
        const q   = ($('js-search').value || '').toLowerCase().trim();
        const mk  = ($('js-make').value || '').toLowerCase();
        const bt  = ($('js-body').value || '').toLowerCase();
        const tr  = ($('js-trans').value || '').toLowerCase();
        const fu  = ($('js-fuel').value || '').toLowerCase();
        const yf  = $('js-year-from').value;
        const yt  = $('js-year-to').value;
        const mf  = $('js-mil-from').value;
        const mt  = $('js-mil-to').value;

        let visible = 0;
        $$('.vp-card').forEach(card => {
            const d = card.dataset;
            let ok = true;

            if (quickFilter === 'local'     && d.category !== 'local')    ok = false;
            if (quickFilter === 'imports'   && d.category !== 'imports')  ok = false;
            if (quickFilter === 'verified'  && d.verified !== 'true')     ok = false;
            if (quickFilter === 'has-video' && d.hasVideo !== 'true')     ok = false;

            if (q  && !(d.name || '').includes(q))       ok = false;
            if (mk && d.make  !== mk)                    ok = false;
            if (bt && d.body  !== bt)                    ok = false;
            if (tr && d.trans !== tr)                    ok = false;
            if (fu && d.fuel  !== fu)                    ok = false;

            const yr = parseInt(d.year);
            if (yf && yr < parseInt(yf))                 ok = false;
            if (yt && yr > parseInt(yt))                 ok = false;

            const pr = parseInt(d.price);
            if (pr < priceMin || pr > priceMax)          ok = false;

            const ml = parseInt(d.mileage);
            if (mf && ml < parseInt(mf))                 ok = false;
            if (mt && ml > parseInt(mt))                 ok = false;

            card.style.display = ok ? '' : 'none';
            if (ok) visible++;
        });
        $('js-count').textContent = visible;
    }

    function pill(btn, min, max) {
        priceMin = min; priceMax = max;
        $$('.vp-pill').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        filter();
    }

    function quick(type) {
        quickFilter = type;
        $$('.vp-qbtn').forEach(b => b.classList.toggle('active', b.dataset.filter === type));
        filter();
    }

    function sort() {
        const v   = $('js-sort').value;
        const con = $('js-grid');
        const cards = [...$$('.vp-card')];
        cards.sort((a, b) => {
            const ad = a.dataset, bd = b.dataset;
            if (v === 'price-low')   return +ad.price   - +bd.price;
            if (v === 'price-high')  return +bd.price   - +ad.price;
            if (v === 'year-new')    return +bd.year    - +ad.year;
            if (v === 'year-old')    return +ad.year    - +bd.year;
            if (v === 'mileage-low') return +ad.mileage - +bd.mileage;
            return 0;
        });
        cards.forEach(c => con.appendChild(c));
    }

    function clear() {
        ['js-search','js-make','js-body','js-trans','js-fuel',
         'js-year-from','js-year-to','js-mil-from','js-mil-to']
            .forEach(id => { const el = $(id); if (el) el.value = ''; });
        priceMin = 0; priceMax = 99000000;
        quickFilter = 'all';
        $$('.vp-qbtn').forEach(b => b.classList.toggle('active', b.dataset.filter === 'all'));
        $$('.vp-pill').forEach(p => p.classList.remove('active'));
        const allPill = document.querySelector('.vp-pill[data-max="99000000"]');
        if (allPill) allPill.classList.add('active');
        history.replaceState(null, '', window.location.pathname);
        filter();
    }

    /* ════════════════════════════════
       CURRENCY
    ════════════════════════════════ */
    function currency() {
        const sel = $('js-currency');
        const opt = sel.options[sel.selectedIndex];
        curRate = parseFloat(opt.dataset.rate);
        curSym  = opt.dataset.sym;
        curCode = opt.value;
        $$('.vp-price').forEach(el => {
            const base = parseFloat(el.dataset.base);
            el.textContent = fmtPrice(base * curRate);
        });
    }

    function fmtPrice(n) {
        return (['KES','UGX','TZS'].includes(curCode))
            ? `${curSym} ${Math.round(n).toLocaleString()}`
            : `${curSym}${Math.round(n).toLocaleString()}`;
    }

    /* ════════════════════════════════
       ADVANCED FILTER TOGGLE
    ════════════════════════════════ */
    function toggleAdv() {
        advOpen = !advOpen;
        _setAdv(advOpen);
    }

    function _setAdv(open) {
        advOpen = open;
        const panel = $('js-adv-panel');
        const chev  = $('js-adv-chev');
        const lbl   = $('js-adv-label');
        const btn   = $('js-adv-toggle');
        if (open) {
            panel.style.maxHeight = (panel.scrollHeight + 400) + 'px';
            panel.classList.add('open');
            chev.classList.add('open');
            lbl.textContent = 'Hide Filters';
            btn.classList.add('active');
        } else {
            panel.style.maxHeight = '0';
            panel.classList.remove('open');
            chev.classList.remove('open');
            lbl.textContent = 'More Filters';
            btn.classList.remove('active');
        }
    }

    /* ════════════════════════════════
       VIEW (GRID / LIST)
    ════════════════════════════════ */
    function view(type) {
        $$('.vp-view').forEach(b => b.classList.toggle('active', b.dataset.view === type));
        $('js-grid').classList.toggle('list-view', type === 'list');
    }

    function wish(e, btn) {
        e.preventDefault(); e.stopPropagation();
        btn.classList.toggle('active');
    }

    /* ════════════════════════════════
       VIDEO MODAL
    ════════════════════════════════ */
    function openVideo(e, url, name) {
        e.preventDefault(); e.stopPropagation();

        if (!url || url.trim() === '') {
            console.warn('[VP] openVideo called with empty URL for:', name);
            return;
        }

        const src     = $('vpm-src');
        const video   = $('vpm-video');
        const overlay = $('vpm-overlay');
        const modal   = $('vp-video-modal');
        const nameEl  = $('vpm-name');

        src.src               = url;
        nameEl.textContent    = name + ' — Video Walkthrough';
        video.load();
        overlay.style.display = 'flex';
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeVideo() {
        const modal = $('vp-video-modal');
        const video = $('vpm-video');
        video.pause();
        video.currentTime = 0;
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }

    function startVideo() {
        const video   = $('vpm-video');
        const overlay = $('vpm-overlay');
        video.play()
            .then(() => { overlay.style.display = 'none'; })
            .catch(err => console.warn('[VP] Video play error:', err));
    }

    /* ════════════════════════════════
       MPESA MODAL
    ════════════════════════════════ */
    function openPay(e, carId, price, name) {
        e.stopPropagation();
        payCarId    = carId;
        payCarName  = name;
        payCarPrice = price;

        $('mpm-car-name').textContent       = name;
        $('mpm-amount-display').textContent = 'KSh ' + Number(price).toLocaleString();
        $('mpm-amount-inline').textContent  = Number(price).toLocaleString();
        $('mpm-acct').textContent           = 'RPT-' + carId;
        $('mpm-sum-car').textContent        = name;
        $('mpm-sum-amt').textContent        = 'KSh ' + Number(price).toLocaleString();

        payStep(1);
        $('mpm-code').value = '';
        hideErr();
        $('vp-mpesa-modal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closePay() {
        $('vp-mpesa-modal').classList.remove('open');
        document.body.style.overflow = '';
    }

    function payStep(n) {
        $$('.mpm-step').forEach(s => s.classList.remove('active'));
        $('mpm-s' + n).classList.add('active');
    }

    function hideErr() {
        $('mpm-err').classList.add('hidden');
    }

    function _showErr(msg) {
        $('mpm-err-txt').textContent = msg;
        $('mpm-err').classList.remove('hidden');
    }

    function submitPay() {
        const code = ($('mpm-code').value || '').trim();
        if (code.length < 8) {
            _showErr('Please enter a valid M-Pesa code (min 8 characters)');
            return;
        }
        const csrf = document.querySelector('meta[name="csrf-token"]');
        if (!csrf) { _showErr('Page error — please refresh and try again.'); return; }

        const btn  = $('mpm-submit');
        const txt  = $('mpm-submit-txt');
        const ico  = $('mpm-submit-ico');
        const spin = $('mpm-spinner');

        btn.disabled      = true;
        txt.textContent   = 'Submitting…';
        ico.classList.add('hidden');
        spin.classList.remove('hidden');

        const reset = () => {
            btn.disabled     = false;
            txt.textContent  = 'Verify & Get Report';
            ico.classList.remove('hidden');
            spin.classList.add('hidden');
        };

        fetch(`/vehicles/${payCarId}/submit-report-payment`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf.getAttribute('content') },
            body: JSON.stringify({ mpesa_code: code, amount: payCarPrice })
        })
        .then(res => {
            if (res.status === 419) throw new Error('csrf');
            if (res.status === 401) { window.location.href = '/sell?redirect=' + encodeURIComponent(location.href); throw new Error('unauth'); }
            if (res.status === 422) return res.json().then(d => { throw { type: 'validation', errors: d.errors }; });
            if (!res.ok)            throw new Error('http_' + res.status);
            return res.json();
        })
        .then(data => {
            reset();
            if (data.success) {
                $('mpm-ok-code').textContent = code;
                $('mpm-ok-car').textContent  = payCarName;
                payStep(3);
            } else {
                _showErr(data.message || 'Something went wrong. Please try again.');
            }
        })
        .catch(err => {
            if (err.message === 'unauth') return;
            reset();
            if (err?.type === 'validation') _showErr(Object.values(err.errors).flat().join(' '));
            else if (err.message === 'csrf') _showErr('Session expired — please refresh the page.');
            else { _showErr('Request failed. Please check your connection.'); console.error(err); }
        });
    }

    /* ════════════════════════════════
       COPY UTILITY
    ════════════════════════════════ */
    function copy(text) {
        navigator.clipboard.writeText(text).catch(() => {
            const el = document.createElement('textarea');
            el.value = text;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        });
        _toast('Copied: ' + text);
    }

    function copyAcct() { copy('RPT-' + payCarId); }

    function _toast(msg) {
        const t = $('vp-toast');
        if (!t) return;
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 2000);
    }

    /* ════════════════════════════════
       URL PARAMS INIT
    ════════════════════════════════ */
    function _initFromURL() {
        const p = new URLSearchParams(location.search);

        const q = p.get('query') || p.get('search') || '';
        if (q) $('js-search').value = q;

        const make = p.get('make') || '';
        if (make) { $('js-make').value = make.toLowerCase(); _setAdv(true); }

        const body = p.get('body_type') || '';
        if (body) { $('js-body').value = body.toLowerCase(); _setAdv(true); }

        const pMin = parseInt(p.get('price_min') || '0');
        const pMax = parseInt(p.get('price_max') || '99000000');
        if (p.has('price_min') || p.has('price_max')) {
            priceMin = pMin; priceMax = pMax;
            $$('.vp-pill').forEach(pill => {
                pill.classList.toggle('active',
                    parseInt(pill.dataset.min) === priceMin && parseInt(pill.dataset.max) === priceMax);
            });
        }

        ['transmission:js-trans','fuel_type:js-fuel','year_from:js-year-from',
         'year_to:js-year-to','mileage_from:js-mil-from','mileage_to:js-mil-to']
        .forEach(pair => {
            const [key, id] = pair.split(':');
            const val = p.get(key) || '';
            if (val) { $(id).value = val.toLowerCase(); _setAdv(true); }
        });

        if ([...p.keys()].length > 0) filter();
    }

    /* ════════════════════════════════
       GLOBAL KEYBOARD / INIT
    ════════════════════════════════ */
    document.addEventListener('DOMContentLoaded', () => {
        const video   = $('vpm-video');
        const overlay = $('vpm-overlay');
        if (video) {
            video.addEventListener('play',  () => { overlay.style.display = 'none'; });
            video.addEventListener('pause', () => {
                if (video.currentTime < 0.5) overlay.style.display = 'flex';
            });
        }

        document.addEventListener('keydown', e => {
            if (e.key !== 'Escape') return;
            if ($('vp-video-modal')?.classList.contains('open'))  closeVideo();
            if ($('vp-mpesa-modal')?.classList.contains('open'))  closePay();
        });

        _initFromURL();
    });

    /* ── Public API ── */
    return { filter, pill, quick, sort, clear, currency, toggleAdv,
             view, wish, openVideo, closeVideo, startVideo,
             openPay, closePay, payStep, hideErr, submitPay,
             copy, copyAcct };
})();
</script>

@endsection
