@extends('layouts.app')

@section('content')

@php
function resolveVideo($car): array {
    $raw = trim((string) ($car->video ?? ''));
    if ($raw === '' || $raw === 'null') {
        return ['has_video' => false, 'url' => null];
    }
    $path = str_starts_with($raw, 'storage/') ? $raw : 'storage/' . $raw;
    return ['has_video' => true, 'url' => asset($path)];
}
@endphp

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style"
      href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&family=DM+Serif+Display:ital@0;1&display=swap"
      onload="this.rel='stylesheet'">
<noscript>
<link rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&family=DM+Serif+Display:ital@0;1&display=swap">
</noscript>
@endpush

<div class="vp">

    {{-- ── HERO ── --}}
    <div class="vp-hero">
        <div class="vp-inner">
            <h1 class="vp-headline">Find your <em>perfect</em> car.</h1>
            <p class="vp-tagline">{{ $cars->count() }} vehicles available across Kenya</p>

            {{-- Search row --}}
            <div class="vp-search-row">
                <div class="vp-search-box">
                    <svg class="vp-s-ico" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input id="js-search" type="text" placeholder="Make, model or keyword…"
                           oninput="VP.filter()" autocomplete="off" spellcheck="false">
                    <div class="vp-currency-sel">
                        <select id="js-currency" onchange="VP.currency()">
                            <option value="KES" data-rate="1"      data-sym="KSh">KES</option>
                            <option value="USD" data-rate="0.0077" data-sym="$">USD</option>
                            <option value="GBP" data-rate="0.0061" data-sym="£">GBP</option>
                            <option value="EUR" data-rate="0.0071" data-sym="€">EUR</option>
                            <option value="ZAR" data-rate="0.14"   data-sym="R">ZAR</option>
                            <option value="AED" data-rate="0.028"  data-sym="AED">AED</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Budget card --}}
            <div class="vp-budget-card">
                <div class="vp-budget-left">
                    <div class="vp-budget-select-wrap">
                        <select id="js-budget-select" class="vp-budget-select" onchange="VP.budgetSelect()">
                            <option value="0|99000000">All prices</option>
                            <option value="0|500000">Under KSh 500K</option>
                            <option value="500000|1000000">KSh 500K – 1M</option>
                            <option value="1000000|2000000">KSh 1M – 2M</option>
                            <option value="2000000|3000000">KSh 2M – 3M</option>
                            <option value="3000000|5000000">KSh 3M – 5M</option>
                            <option value="5000000|10000000">KSh 5M – 10M</option>
                            <option value="10000000|99000000">Above KSh 10M</option>
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                </div>
                <div class="vp-budget-divider"></div>
                <div class="vp-budget-pills">
                    <button class="vp-bp active" data-min="0" data-max="99000000" onclick="VP.pill(this,0,99000000)">All</button>
                    <button class="vp-bp" data-min="0" data-max="500000" onclick="VP.pill(this,0,500000)">Under 500K</button>
                    <button class="vp-bp" data-min="500000" data-max="1000000" onclick="VP.pill(this,500000,1000000)">500K–1M</button>
                    <button class="vp-bp" data-min="1000000" data-max="2000000" onclick="VP.pill(this,1000000,2000000)">1M–2M</button>
                    <button class="vp-bp" data-min="2000000" data-max="3000000" onclick="VP.pill(this,2000000,3000000)">2M–3M</button>
                    <button class="vp-bp" data-min="3000000" data-max="5000000" onclick="VP.pill(this,3000000,5000000)">3M–5M</button>
                    <button class="vp-bp" data-min="5000000" data-max="10000000" onclick="VP.pill(this,5000000,10000000)">5M–10M</button>
                    <button class="vp-bp" data-min="10000000" data-max="99000000" onclick="VP.pill(this,10000000,99000000)">Above 10M</button>
                </div>
            </div>

            {{-- Quick filter chips --}}
            <div class="vp-chips">
                <button class="vp-chip active" data-filter="all"      onclick="VP.quick('all')">All Vehicles</button>
                <button class="vp-chip"        data-filter="local"    onclick="VP.quick('local')">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    In Kenya
                </button>
                <button class="vp-chip"        data-filter="imports"  onclick="VP.quick('imports')">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                    Imports
                </button>
                <button class="vp-chip"        data-filter="verified" onclick="VP.quick('verified')">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Verified
                </button>
                <button class="vp-chip vp-chip--vid" data-filter="has-video" onclick="VP.quick('has-video')">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                    Has Video
                </button>
                <button class="vp-chip vp-chip--more" id="js-adv-toggle" onclick="VP.toggleAdv()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
                    <span id="js-adv-label">Filters</span>
                    <svg class="vp-chev" id="js-adv-chev" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
            </div>

            {{-- Advanced filters --}}
            <div class="vp-adv" id="js-adv-panel">
                <div class="vp-adv-grid">
                    <div class="vp-fg">
                        <label>Make</label>
                        <select id="js-make" onchange="VP.filter()">
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
                        <label>Body Type</label>
                        <select id="js-body" onchange="VP.filter()">
                            <option value="">All Types</option>
                            <option value="suv">SUV</option>
                            <option value="sedan">Sedan</option>
                            <option value="hatchback">Hatchback</option>
                            <option value="pickup">Pickup</option>
                        </select>
                    </div>
                    <div class="vp-fg">
                        <label>Year From</label>
                        <select id="js-year-from" onchange="VP.filter()">
                            <option value="">Any</option>
                            @for($y = 2024; $y >= 2000; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="vp-fg">
                        <label>Year To</label>
                        <select id="js-year-to" onchange="VP.filter()">
                            <option value="">Any</option>
                            @for($y = 2024; $y >= 2000; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="vp-fg">
                        <label>Transmission</label>
                        <select id="js-trans" onchange="VP.filter()">
                            <option value="">All</option>
                            <option value="automatic">Automatic</option>
                            <option value="manual">Manual</option>
                        </select>
                    </div>
                    <div class="vp-fg">
                        <label>Fuel Type</label>
                        <select id="js-fuel" onchange="VP.filter()">
                            <option value="">All</option>
                            <option value="petrol">Petrol</option>
                            <option value="diesel">Diesel</option>
                            <option value="hybrid">Hybrid</option>
                            <option value="electric">Electric</option>
                        </select>
                    </div>
                    <div class="vp-fg">
                        <label>Min Mileage (km)</label>
                        <input id="js-mil-from" type="number" placeholder="0" oninput="VP.filter()">
                    </div>
                    <div class="vp-fg">
                        <label>Max Mileage (km)</label>
                        <input id="js-mil-to" type="number" placeholder="150,000" oninput="VP.filter()">
                    </div>
                    <div class="vp-fg vp-fg--clear">
                        <button onclick="VP.clear()">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            Clear all
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── RESULTS ── --}}
    <div class="vp-results vp-inner">

        <div class="vp-toolbar">
            <div class="vp-toolbar-left">
                <span class="vp-count-num" id="js-count">{{ $cars->count() }}</span>
                <span class="vp-count-txt"> vehicles found</span>
            </div>
            <div class="vp-toolbar-right">
                <label class="vp-sort-lbl">Sort</label>
                <select id="js-sort" class="vp-sort-sel" onchange="VP.sort()">
                    <option value="featured">Featured</option>
                    <option value="price-low">Price: Low → High</option>
                    <option value="price-high">Price: High → Low</option>
                    <option value="year-new">Newest first</option>
                    <option value="year-old">Oldest first</option>
                    <option value="mileage-low">Lowest mileage</option>
                </select>
                <div class="vp-view-btns">
                    <button class="vp-vbtn active" data-view="grid" onclick="VP.view('grid')" title="Grid">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    </button>
                    <button class="vp-vbtn" data-view="list" onclick="VP.view('list')" title="List">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><rect x="3" y="4" width="2" height="4"/><rect x="3" y="10" width="2" height="4"/><rect x="3" y="16" width="2" height="4"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="vp-grid" id="js-grid">
            @forelse($cars as $car)
                @php
                    $rawImages = $car->images ?? null;
                    $images    = $rawImages
                        ? (is_string($rawImages) ? json_decode($rawImages, true) : (array) $rawImages)
                        : [];
                    $images    = array_filter((array) $images);
                    $mainImage = count($images)
                        ? asset('storage/' . ltrim($images[0], '/'))
                        : 'https://via.placeholder.com/600x400/f0ede8/b0a89e?text=No+Photo';

                    $videoRaw  = trim((string) ($car->video ?? ''));
                    $hasVideo  = ($videoRaw !== '' && $videoRaw !== 'null' && $videoRaw !== '0');
                    $videoPath = $hasVideo ? (str_starts_with($videoRaw, 'storage/') ? $videoRaw : 'storage/' . $videoRaw) : null;
                    $videoUrl  = $hasVideo ? asset($videoPath) : '';

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

                    <a href="{{ route('vehicles.show', $carId) }}" class="vp-card-img-link">
                        <div class="vp-card-img">
                            <img src="{{ $mainImage }}" alt="{{ $carName }}" loading="lazy"
                                 onerror="this.src='https://via.placeholder.com/600x400/f0ede8/b0a89e?text=No+Photo'">

                            {{-- Badges --}}
                            <div class="vp-badges">
                                @if($isVerified)
                                    <span class="vp-badge vp-badge--ok">
                                        <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                        Verified
                                    </span>
                                @endif
                                @if($isFeatured)
                                    <span class="vp-badge vp-badge--feat">Featured</span>
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

                            @if($hasVideo)
                            <button class="vp-play-btn"
                                    onclick="event.preventDefault();VP.openVideo(event,'{{ addslashes($videoUrl) }}','{{ addslashes($carName) }}')"
                                    aria-label="Play video">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            </button>
                            @endif
                        </div>
                    </a>

                    <div class="vp-card-body">
                        <div class="vp-card-top">
                            <h3 class="vp-car-name">
                                <a href="{{ route('vehicles.show', $carId) }}">{{ $carName }}</a>
                            </h3>
                            <div class="vp-price" data-base="{{ $carPrice }}">KSh {{ number_format($carPrice) }}</div>
                        </div>

                        <div class="vp-meta">
                            <span>{{ $carYear }}</span>
                            <span class="vp-sep">·</span>
                            <span>{{ number_format($carMileage) }} km</span>
                            <span class="vp-sep">·</span>
                            <span>{{ ucfirst($carTrans) }}</span>
                            <span class="vp-sep">·</span>
                            <span>{{ ucfirst($carFuel) }}</span>
                        </div>

                        <div class="vp-card-foot">
                            <span class="vp-loc">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $carLoc }}
                            </span>
                            <a href="{{ route('vehicles.show', $carId) }}" class="vp-view-link">Details →</a>
                        </div>

                        @if($hasVideo)
                        <button class="vp-video-bar"
                                onclick="VP.openVideo(event,'{{ addslashes($videoUrl) }}','{{ addslashes($carName) }}')">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            Watch video walkthrough
                        </button>
                        @endif

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
                                    <button class="vp-report-btn vp-report-btn--pend">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        Pending verification
                                    </button>
                                @else
                                    <button class="vp-report-btn"
                                            onclick="VP.openPay(event,{{ $carId }},{{ $car->report_price ?? 0 }},'{{ addslashes($carName) }}')">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        @if($car->report_price) Buy report · KSh {{ number_format($car->report_price) }}
                                        @else Buy report @endif
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('sell') }}?redirect={{ urlencode(request()->url()) }}" class="vp-report-btn">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    @if($car->report_price) Buy report · KSh {{ number_format($car->report_price) }}
                                    @else Buy report @endif
                                </a>
                            @endauth
                        </div>
                        @endif
                    </div>

                </article>

            @empty
                <div class="vp-empty">
                    <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <h3>No vehicles found</h3>
                    <p>Try adjusting your filters</p>
                    <button onclick="VP.clear()">Clear filters</button>
                </div>
            @endforelse
        </div>

        <nav class="vp-pager">
            <button class="vp-pnav" disabled>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="vp-pnum active">1</button>
            <button class="vp-pnum">2</button>
            <button class="vp-pnum">3</button>
            <span class="vp-pell">…</span>
            <button class="vp-pnum">10</button>
            <button class="vp-pnav">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </nav>

    </div>
</div>

{{-- ── VIDEO MODAL ── --}}
<div id="vp-video-modal" class="vpm-overlay" onclick="if(event.target===this)VP.closeVideo()">
    <div class="vpm-box">
        <div class="vpm-head">
            <span id="vpm-name" class="vpm-name">Video Walkthrough</span>
            <button onclick="VP.closeVideo()" class="vpm-close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vpm-stage">
            <video id="vpm-video" controls preload="metadata" playsinline>
                <source id="vpm-src" src="" type="video/mp4">
            </video>
            <div id="vpm-overlay" class="vpm-play-ov" onclick="VP.startVideo()">
                <div class="vpm-big-play">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── MPESA MODAL ── --}}
<div id="vp-mpesa-modal" class="mpm-overlay" onclick="if(event.target===this)VP.closePay()">
    <div class="mpm-box">
        <div id="mpm-s1" class="mpm-step active">
            <div class="mpm-head">
                <div>
                    <h2>Pay via M-Pesa</h2>
                    <p id="mpm-car-name">Vehicle Report</p>
                </div>
                <button onclick="VP.closePay()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="mpm-amount-bar">
                <span>Amount</span>
                <strong id="mpm-amount-display">KSh 0</strong>
            </div>
            <h3>How to pay</h3>
            <ol class="mpm-steps">
                <li><span>1</span><span>Open <b>M-Pesa</b> → Lipa na M-Pesa → Paybill</span></li>
                <li><span>2</span><span>Business No: <b class="mpm-hl" onclick="VP.copy('247247')">247247</b> <button class="mpm-copy-btn" onclick="VP.copy('247247')">copy</button></span></li>
                <li><span>3</span><span>Account No: <b class="mpm-hl" id="mpm-acct">RPT-0</b> <button class="mpm-copy-btn" onclick="VP.copyAcct()">copy</button></span></li>
                <li><span>4</span><span>Amount: <b class="mpm-hl" id="mpm-amount-inline">0</b></span></li>
                <li><span>5</span><span>Enter PIN and confirm</span></li>
            </ol>
            <button class="mpm-next" onclick="VP.payStep(2)">I've paid — enter code →</button>
        </div>
        <div id="mpm-s2" class="mpm-step">
            <div class="mpm-head">
                <button onclick="VP.payStep(1)" class="mpm-back">← Back</button>
                <div><h2>Enter M-Pesa code</h2><p>From your confirmation SMS</p></div>
                <button onclick="VP.closePay()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <label>Transaction code</label>
            <input id="mpm-code" type="text" placeholder="e.g. SJK1AB2CD3" maxlength="12"
                   oninput="this.value=this.value.toUpperCase().replace(/[^A-Z0-9]/g,'');VP.hideErr()"
                   autocomplete="off">
            <div id="mpm-err" class="mpm-err hidden">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>
                <span id="mpm-err-txt">Please enter a valid code</span>
            </div>
            <label style="margin-top:14px">Phone number</label>
            <div class="mpm-phone">
                <span>+254</span>
                <input id="mpm-phone" type="tel" placeholder="7XX XXX XXX" maxlength="9"
                       oninput="this.value=this.value.replace(/[^0-9]/g,'')">
            </div>
            <div class="mpm-summary">
                <div><span>Vehicle</span><strong id="mpm-sum-car">—</strong></div>
                <div><span>Amount</span><strong id="mpm-sum-amt">—</strong></div>
                <div><span>Paybill</span><strong>247247</strong></div>
            </div>
            <button class="mpm-submit" id="mpm-submit" onclick="VP.submitPay()">
                <span id="mpm-submit-txt">Verify &amp; get report</span>
                <svg id="mpm-submit-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <svg id="mpm-spinner" class="mpm-spin hidden" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
            </button>
        </div>
        <div id="mpm-s3" class="mpm-step">
            <div class="mpm-ok">
                <div class="mpm-ok-ico">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <h2>Payment verified</h2>
                <p>Your vehicle report is ready.</p>
                <div class="mpm-ok-detail">
                    <div><span>Transaction</span><strong id="mpm-ok-code">—</strong></div>
                    <div><span>Vehicle</span><strong id="mpm-ok-car">—</strong></div>
                </div>
                <a href="#" id="mpm-report-link" class="mpm-view-report">View full report</a>
                <button class="mpm-done" onclick="VP.closePay()">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="vp-toast" class="vp-toast"></div>


<style>
:root {
    --f: 'DM Sans', ui-sans-serif, system-ui, sans-serif;
    --fs: 'DM Serif Display', Georgia, serif;
    --bg:      #f8f5f0;
    --bg2:     #ffffff;
    --bg3:     #f2ede6;
    --acc:     #c0392b;
    --acc-h:   #a93226;
    --acc-lt:  rgba(192,57,43,.09);
    --grn:     #1a7a45;
    --ink:     #1a1410;
    --ink2:    #5c4f44;
    --ink3:    #9c8c7e;
    --bdr:     #e4ddd4;
    --bdr2:    #d6cfc6;
    --r:       10px;
    --r-sm:    7px;
    --tr:      all .2s ease;
}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:var(--f);color:var(--ink);background:var(--bg)}
a{text-decoration:none;color:inherit}
button{font-family:var(--f);cursor:pointer;background:none;border:none}

.vp{min-height:100vh}
/* Push content below fixed/sticky navbar — adjust the value to match your navbar height */
.vp-hero{margin-top:0}
.vp-inner{max-width:1320px;margin:0 auto;padding:0 20px}

/* ── Hero ── */
.vp-hero{background:var(--bg);border-bottom:1px solid var(--bdr);padding:80px 20px 32px}
.vp-headline{font-family:var(--fs);font-size:clamp(30px,4vw,54px);font-weight:400;line-height:1.08;letter-spacing:-.5px;margin-bottom:8px;text-align:center}
.vp-headline em{font-style:italic;color:var(--acc)}
.vp-tagline{font-size:14px;color:var(--ink3);text-align:center;margin-bottom:28px;font-weight:300}

/* ── Search ── */
.vp-search-row{margin-bottom:16px}
.vp-search-box{display:flex;align-items:center;background:#fff;border:1.5px solid var(--bdr);border-radius:var(--r);height:52px;padding:0 14px;gap:10px;max-width:700px;margin:0 auto;transition:border-color .2s}
.vp-search-box:focus-within{border-color:var(--acc)}
.vp-s-ico{color:var(--ink3);flex-shrink:0}
.vp-search-box input{flex:1;border:none;outline:none;font-family:var(--f);font-size:15px;color:var(--ink);background:transparent}
.vp-search-box input::placeholder{color:var(--ink3)}
.vp-currency-sel{display:flex;align-items:center;border-left:1px solid var(--bdr);padding-left:12px;flex-shrink:0}
.vp-currency-sel select{border:none;outline:none;background:transparent;font-family:var(--f);font-size:13px;font-weight:500;color:var(--ink2);cursor:pointer}

/* ── Budget card ── */
.vp-budget-card{display:flex;align-items:center;background:#fff;border:1.5px solid var(--bdr);border-radius:var(--r);padding:12px 16px;gap:16px;max-width:700px;margin:0 auto 16px;overflow:hidden}
.vp-budget-left{flex-shrink:0;display:flex;flex-direction:column;gap:5px;min-width:100px}
.vp-budget-label{display:none}
.vp-budget-select-wrap{position:relative;display:flex;align-items:center}
.vp-budget-select{border:none;outline:none;background:transparent;font-family:var(--f);font-size:13.5px;font-weight:500;color:var(--ink);cursor:pointer;appearance:none;padding-right:18px}
.vp-budget-select-wrap svg{position:absolute;right:0;color:var(--ink3);pointer-events:none}
.vp-budget-divider{width:1px;height:32px;background:var(--bdr);flex-shrink:0}
.vp-budget-pills{display:flex;gap:6px;overflow-x:auto;scrollbar-width:none;flex:1}
.vp-budget-pills::-webkit-scrollbar{display:none}
.vp-bp{padding:5px 12px;border:1px solid var(--bdr);border-radius:100px;font-size:12px;font-weight:500;color:var(--ink2);white-space:nowrap;transition:var(--tr);flex-shrink:0}
.vp-bp:hover{border-color:var(--acc);color:var(--acc)}
.vp-bp.active{background:var(--acc);color:#fff;border-color:var(--acc)}

/* ── Chips ── */
.vp-chips{display:flex;flex-wrap:wrap;align-items:center;gap:8px;max-width:700px;margin:0 auto}
.vp-chip{display:inline-flex;align-items:center;gap:5px;padding:7px 14px;border:1px solid var(--bdr);border-radius:100px;font-size:12.5px;font-weight:500;color:var(--ink2);background:#fff;transition:var(--tr);white-space:nowrap}
.vp-chip:hover{border-color:var(--acc);color:var(--acc)}
.vp-chip.active{background:var(--acc);color:#fff;border-color:var(--acc)}
.vp-chip--vid.active{background:#1a1410;border-color:#1a1410}
.vp-chip--more{margin-left:auto}
.vp-chev{transition:transform .25s}
.vp-chev.open{transform:rotate(180deg)}
/* On mobile the grid overrides flex — SVG icons shrink to fit */
.vp-chip svg{flex-shrink:0}

/* ── Advanced filters ── */
.vp-adv{max-height:0;overflow:hidden;transition:max-height .35s ease;max-width:700px;margin:0 auto}
.vp-adv.open{padding-top:14px}
.vp-adv-grid{background:#fff;border:1.5px solid var(--bdr);border-radius:var(--r);padding:18px;display:grid;grid-template-columns:repeat(4,1fr);gap:12px}
.vp-fg{display:flex;flex-direction:column;gap:5px}
.vp-fg label{font-size:10.5px;font-weight:600;letter-spacing:.6px;text-transform:uppercase;color:var(--ink3)}
.vp-fg select,.vp-fg input{padding:9px 10px;border:1px solid var(--bdr);border-radius:var(--r-sm);font-family:var(--f);font-size:13px;color:var(--ink);background:var(--bg);outline:none;transition:var(--tr)}
.vp-fg select:focus,.vp-fg input:focus{border-color:var(--acc)}
.vp-fg--clear{justify-content:flex-end;align-items:flex-end}
.vp-fg--clear button{display:flex;align-items:center;gap:5px;padding:9px 13px;border:1px solid var(--bdr);border-radius:var(--r-sm);font-size:12.5px;color:var(--ink2);transition:var(--tr)}
.vp-fg--clear button:hover{background:var(--ink);color:#fff;border-color:var(--ink)}

/* ── Toolbar ── */
.vp-results{padding-top:32px;padding-bottom:80px}
.vp-toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;padding-bottom:18px;border-bottom:1px solid var(--bdr)}
.vp-toolbar-left{display:flex;align-items:baseline;gap:6px}
.vp-count-num{font-family:var(--fs);font-size:30px;font-weight:400;color:var(--acc)}
.vp-count-txt{font-size:14px;color:var(--ink3)}
.vp-toolbar-right{display:flex;align-items:center;gap:12px}
.vp-sort-lbl{font-size:13px;color:var(--ink3)}
.vp-sort-sel{padding:8px 12px;border:1px solid var(--bdr);border-radius:var(--r-sm);font-family:var(--f);font-size:13px;color:var(--ink);background:#fff;outline:none;min-width:150px}
.vp-view-btns{display:flex;background:var(--bg3);border:1px solid var(--bdr);border-radius:var(--r-sm);padding:3px;gap:2px}
.vp-vbtn{padding:6px 10px;border-radius:5px;color:var(--ink3);display:flex;align-items:center;transition:var(--tr)}
.vp-vbtn.active{background:#fff;color:var(--acc)}

/* ── Grid ── */
.vp-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:40px}
.vp-grid.list-view{grid-template-columns:1fr}

/* ── Card ── */
.vp-card{background:#fff;border:1px solid var(--bdr);border-radius:var(--r);overflow:hidden;display:flex;flex-direction:column;transition:var(--tr);animation:fadeup .3s ease both}
.vp-card:hover{border-color:var(--bdr2);box-shadow:0 6px 24px rgba(26,20,16,.1)}
.list-view .vp-card{flex-direction:row}
@keyframes fadeup{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
.vp-card:nth-child(1){animation-delay:0ms}.vp-card:nth-child(2){animation-delay:35ms}
.vp-card:nth-child(3){animation-delay:70ms}.vp-card:nth-child(4){animation-delay:105ms}
.vp-card:nth-child(5){animation-delay:140ms}.vp-card:nth-child(6){animation-delay:175ms}
.vp-card:nth-child(7){animation-delay:210ms}.vp-card:nth-child(8){animation-delay:245ms}

.vp-card-img-link{display:block;flex-shrink:0}
.vp-card-img{position:relative;aspect-ratio:16/11;background:var(--bg3);overflow:hidden}
.list-view .vp-card-img{width:280px;aspect-ratio:auto;height:100%}
.vp-card-img img{width:100%;height:100%;object-fit:contain;background:var(--bg3);transition:transform .35s ease}
.vp-card:hover .vp-card-img img{transform:scale(1.03)}

/* Badges */
.vp-badges{position:absolute;top:8px;left:8px;display:flex;flex-direction:column;gap:4px;z-index:2}
.vp-badge{padding:3px 7px;border-radius:4px;font-size:10px;font-weight:600;display:inline-flex;align-items:center;gap:3px;letter-spacing:.3px}
.vp-badge--ok{background:var(--grn);color:#fff}
.vp-badge--feat{background:#b86a00;color:#fff}
.vp-badge--vid{background:var(--ink);color:#fff}
.vp-img-count{position:absolute;bottom:7px;left:7px;background:rgba(26,20,16,.55);color:#fff;padding:2px 7px;border-radius:4px;font-size:10.5px;font-weight:600;display:flex;align-items:center;gap:3px}
.vp-play-btn{position:absolute;bottom:8px;right:8px;width:36px;height:36px;background:var(--acc);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;transition:var(--tr)}
.vp-play-btn svg{margin-left:2px}
.vp-play-btn:hover{background:var(--acc-h);transform:scale(1.08)}

/* Card body */
.vp-card-body{padding:14px;display:flex;flex-direction:column;gap:9px;flex:1}
.vp-card-top{display:flex;justify-content:space-between;align-items:flex-start;gap:8px}
.vp-car-name{font-size:13.5px;font-weight:500;line-height:1.35;flex:1}
.vp-car-name a{color:var(--ink);transition:color .15s}
.vp-car-name a:hover{color:var(--acc)}
.vp-price{font-size:15px;font-weight:600;color:var(--acc);white-space:nowrap}
.vp-meta{font-size:11.5px;color:var(--ink3);display:flex;flex-wrap:wrap;gap:4px;align-items:center}
.vp-sep{color:var(--bdr2)}
.vp-card-foot{display:flex;justify-content:space-between;align-items:center;padding-top:6px;border-top:1px solid var(--bg3)}
.vp-loc{font-size:11px;color:var(--ink3);display:flex;align-items:center;gap:3px}
.vp-view-link{font-size:12.5px;font-weight:500;color:var(--acc);transition:var(--tr)}
.vp-video-bar{display:flex;align-items:center;gap:7px;padding:7px 10px;background:rgba(26,20,16,.04);border:1px solid var(--bdr);border-radius:var(--r-sm);font-size:11.5px;font-weight:500;color:var(--ink2);transition:var(--tr)}
.vp-video-bar:hover{background:var(--acc-lt);border-color:var(--acc);color:var(--acc)}
.vp-report-wrap{border-top:1px solid var(--bg3);padding-top:8px}
.vp-report-btn{width:100%;background:var(--acc);color:#fff;padding:9px 12px;border-radius:var(--r-sm);font-size:12px;font-weight:500;display:flex;align-items:center;justify-content:center;gap:5px;text-decoration:none;transition:var(--tr)}
.vp-report-btn:hover{background:var(--acc-h)}
.vp-report-btn--ok{background:var(--grn)}
.vp-report-btn--ok:hover{background:#156038}
.vp-report-btn--pend{background:var(--ink3);cursor:default}

/* Empty */
.vp-empty{grid-column:1/-1;text-align:center;padding:80px 20px;color:var(--ink3)}
.vp-empty svg{margin-bottom:16px}
.vp-empty h3{font-size:20px;font-weight:500;color:var(--ink2);margin-bottom:6px}
.vp-empty p{font-size:13.5px;margin-bottom:20px}
.vp-empty button{background:var(--acc);color:#fff;padding:10px 22px;border-radius:var(--r-sm);font-size:13px;font-weight:500}

/* Pagination */
.vp-pager{display:flex;justify-content:center;align-items:center;gap:6px;padding:32px 0 16px}
.vp-pnav,.vp-pnum{width:36px;height:36px;background:#fff;border:1px solid var(--bdr);border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:13.5px;font-weight:500;color:var(--ink2);transition:var(--tr)}
.vp-pnav:hover:not(:disabled),.vp-pnum:hover{border-color:var(--acc);color:var(--acc)}
.vp-pnum.active{background:var(--acc);color:#fff;border-color:var(--acc)}
.vp-pnav:disabled{opacity:.3;cursor:default}
.vp-pell{color:var(--ink3);font-size:15px;padding:0 2px}

/* List view */
.list-view .vp-card-body{padding:18px}
.list-view .vp-car-name{font-size:15px}
.list-view .vp-price{font-size:17px}

/* ── Video modal ── */
.vpm-overlay{display:none;position:fixed;inset:0;background:rgba(10,6,2,.85);z-index:9000;align-items:center;justify-content:center;padding:16px}
.vpm-overlay.open{display:flex}
.vpm-box{background:#0a0602;border-radius:12px;width:100%;max-width:820px;overflow:hidden;animation:vpm-in .25s ease}
@keyframes vpm-in{from{opacity:0;transform:scale(.97)}to{opacity:1;transform:scale(1)}}
.vpm-head{display:flex;align-items:center;justify-content:space-between;padding:13px 16px;border-bottom:1px solid rgba(255,255,255,.06)}
.vpm-name{font-size:13px;font-weight:500;color:rgba(255,255,255,.75);flex:1}
.vpm-close{width:30px;height:30px;background:rgba(255,255,255,.07);border-radius:6px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.5);transition:var(--tr)}
.vpm-close:hover{background:rgba(192,57,43,.3);color:#fff}
.vpm-stage{position:relative;background:#000;line-height:0}
.vpm-stage video{width:100%;max-height:480px;display:block}
.vpm-play-ov{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,.35);cursor:pointer;transition:opacity .2s}
.vpm-big-play{width:68px;height:68px;background:var(--acc);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;transition:var(--tr)}
.vpm-big-play svg{margin-left:3px}
.vpm-play-ov:hover .vpm-big-play{transform:scale(1.08);background:var(--acc-h)}

/* ── Mpesa modal ── */
.mpm-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:9500;align-items:center;justify-content:center;padding:16px}
.mpm-overlay.open{display:flex}
.mpm-box{background:#fff;border-radius:14px;width:100%;max-width:460px;max-height:92vh;overflow-y:auto;animation:vpm-in .25s ease}
.mpm-step{display:none;padding:22px}.mpm-step.active{display:block}
.mpm-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:18px;padding-bottom:16px;border-bottom:1px solid #f0ece6}
.mpm-head h2{font-size:16px;font-weight:600;color:var(--ink);margin-bottom:2px}
.mpm-head p{font-size:12.5px;color:var(--ink3)}
.mpm-head>button{width:30px;height:30px;background:#f5f1ed;border-radius:6px;display:flex;align-items:center;justify-content:center;color:var(--ink2);flex-shrink:0;transition:var(--tr)}
.mpm-head>button:hover{background:#fee2e2;color:#c0392b}
.mpm-back{font-size:12.5px;color:var(--acc);margin-right:auto;padding:4px 0;flex-shrink:0}
.mpm-amount-bar{background:var(--acc);border-radius:8px;padding:14px 16px;display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;color:#fff}
.mpm-amount-bar span{font-size:12.5px;opacity:.8}
.mpm-amount-bar strong{font-size:22px;font-weight:700}
.mpm-box h3{font-size:12.5px;font-weight:600;color:var(--ink2);margin-bottom:12px;text-transform:uppercase;letter-spacing:.4px}
.mpm-steps{list-style:none;display:flex;flex-direction:column;gap:10px;margin-bottom:16px}
.mpm-steps li{display:flex;align-items:flex-start;gap:10px;font-size:13px;color:var(--ink2);line-height:1.5}
.mpm-steps li>span:first-child{width:22px;height:22px;background:var(--acc);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0;margin-top:1px}
.mpm-hl{color:var(--acc);font-weight:600;cursor:pointer}
.mpm-copy-btn{background:#f5f1ed;border:1px solid var(--bdr);border-radius:4px;padding:1px 6px;font-size:11px;color:var(--ink3);margin-left:4px;transition:var(--tr)}
.mpm-copy-btn:hover{background:var(--acc-lt);color:var(--acc);border-color:var(--acc)}
.mpm-next{width:100%;background:var(--acc);color:#fff;padding:13px;border-radius:8px;font-size:14px;font-weight:600;transition:var(--tr);margin-top:14px}
.mpm-next:hover{background:var(--acc-h)}
.mpm-box label{display:block;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;color:var(--ink3);margin-bottom:6px}
.mpm-box input[type=text],.mpm-box input[type=tel]{width:100%;padding:11px 13px;border:1.5px solid var(--bdr);border-radius:8px;font-family:var(--f);font-size:15px;font-weight:600;letter-spacing:1.5px;color:var(--ink);outline:none;transition:var(--tr)}
.mpm-box input:focus{border-color:var(--acc)}
.mpm-err{display:flex;align-items:center;gap:6px;font-size:12.5px;color:#c0392b;margin-top:7px;padding:7px 10px;background:#fdf2f2;border-radius:6px;border:1px solid #f5c6c6}
.mpm-err.hidden{display:none!important}
.mpm-phone{display:flex;align-items:center;border:1.5px solid var(--bdr);border-radius:8px;overflow:hidden;transition:var(--tr)}
.mpm-phone:focus-within{border-color:var(--acc)}
.mpm-phone>span{background:#f5f1ed;padding:11px 12px;font-size:14px;font-weight:600;color:var(--ink2);border-right:1.5px solid var(--bdr)}
.mpm-phone input{flex:1;border:none;outline:none;padding:11px;font-size:14px;color:var(--ink);font-family:var(--f)}
.mpm-summary{background:#f8f5f0;border-radius:8px;padding:12px 14px;margin:16px 0;display:flex;flex-direction:column;gap:8px}
.mpm-summary>div{display:flex;justify-content:space-between;font-size:13px}
.mpm-summary>div>span{color:var(--ink3)}
.mpm-summary>div>strong{font-weight:500;color:var(--ink)}
.mpm-submit{width:100%;background:var(--grn);color:#fff;padding:13px;border-radius:8px;font-size:14px;font-weight:600;display:flex;align-items:center;justify-content:center;gap:7px;transition:var(--tr)}
.mpm-submit:hover:not(:disabled){background:#156038}
.mpm-submit:disabled{opacity:.55;cursor:not-allowed}
.mpm-ok{text-align:center;padding:8px 0}
.mpm-ok-ico{width:68px;height:68px;background:#e8f5ee;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;color:var(--grn);animation:vpm-in .4s ease}
.mpm-ok h2{font-size:20px;font-weight:600;margin-bottom:6px}
.mpm-ok p{font-size:13px;color:var(--ink3);margin-bottom:18px}
.mpm-ok-detail{background:#f8f5f0;border-radius:8px;padding:12px 14px;margin-bottom:18px;text-align:left;display:flex;flex-direction:column;gap:7px}
.mpm-ok-detail>div{display:flex;justify-content:space-between;font-size:13px}
.mpm-ok-detail span{color:var(--ink3)}.mpm-ok-detail strong{color:var(--ink)}
.mpm-view-report{display:flex;align-items:center;justify-content:center;background:var(--acc);color:#fff;padding:12px;border-radius:8px;font-size:14px;font-weight:600;margin-bottom:8px;transition:var(--tr)}
.mpm-view-report:hover{background:var(--acc-h)}
.mpm-done{width:100%;padding:11px;border:1px solid var(--bdr);border-radius:8px;font-size:13.5px;color:var(--ink3);background:transparent;transition:var(--tr)}
.mpm-done:hover{background:#f5f1ed}
.mpm-spin{animation:spin .8s linear infinite}
@keyframes spin{from{transform:rotate(0)}to{transform:rotate(360deg)}}
.hidden{display:none!important}

/* Toast */
.vp-toast{position:fixed;bottom:28px;left:50%;transform:translateX(-50%) translateY(10px);background:var(--ink);color:#fff;padding:8px 18px;border-radius:7px;font-size:13px;font-weight:500;opacity:0;transition:all .25s ease;pointer-events:none;z-index:99999}
.vp-toast.show{opacity:1;transform:translateX(-50%) translateY(0)}

/* ── Responsive ── */
@media(max-width:1200px){.vp-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:900px){
    .vp-grid{grid-template-columns:repeat(2,1fr)}
    .vp-adv-grid{grid-template-columns:repeat(3,1fr)}
    .list-view .vp-card{flex-direction:column}
    .list-view .vp-card-img{width:100%;aspect-ratio:16/11;height:auto}
}
@media(max-width:640px){
    .vp-hero{padding:72px 16px 20px}
    .vp-inner{padding:0 14px}
    .vp-headline{font-size:26px}
    .vp-budget-card{padding:10px 14px}
    .vp-budget-divider{display:none}
    .vp-budget-pills{display:none}
    .vp-budget-left{flex-direction:row;align-items:center;gap:10px;width:100%;min-width:0}
    .vp-budget-select{font-size:14px}
    /* 3-per-row grid: row1 = All/InKenya/Imports, row2 = Verified/HasVideo/Filters */
    .vp-chips{display:grid;grid-template-columns:repeat(3,1fr);gap:7px}
    .vp-chip{justify-content:center;padding:8px 4px;font-size:11.5px;white-space:nowrap}
    .vp-chip--more{margin-left:0;justify-content:center}
    .vp-grid{grid-template-columns:1fr;gap:12px}
    .vp-toolbar{flex-direction:column;align-items:flex-start;gap:12px}
    .vp-toolbar-right{width:100%;justify-content:space-between}
    .vp-adv-grid{grid-template-columns:repeat(2,1fr)}
    .vpm-stage video{max-height:240px}
}
@media(max-width:400px){
    .vp-headline{font-size:24px}
    .vp-adv-grid{grid-template-columns:1fr}
}
@media(min-width:1500px){.vp-grid{grid-template-columns:repeat(5,1fr)}}
</style>

<script>
const VP = (() => {
    let priceMin    = 0;
    let priceMax    = 99000000;
    let quickFilter = 'all';
    let advOpen     = false;
    let curRate     = 1;
    let curSym      = 'KSh';
    let curCode     = 'KES';
    let payCarId    = null;
    let payCarName  = null;
    let payCarPrice = null;

    const $  = id  => document.getElementById(id);
    const $$ = sel => document.querySelectorAll(sel);

    function filter() {
        const q  = ($('js-search').value || '').toLowerCase().trim();
        const mk = ($('js-make').value || '').toLowerCase();
        const bt = ($('js-body').value || '').toLowerCase();
        const tr = ($('js-trans').value || '').toLowerCase();
        const fu = ($('js-fuel').value || '').toLowerCase();
        const yf = $('js-year-from').value;
        const yt = $('js-year-to').value;
        const mf = $('js-mil-from').value;
        const mt = $('js-mil-to').value;
        let vis  = 0;
        $$('.vp-card').forEach(card => {
            const d = card.dataset;
            let ok = true;
            if (quickFilter === 'local'    && d.category !== 'local')   ok = false;
            if (quickFilter === 'imports'  && d.category !== 'imports') ok = false;
            if (quickFilter === 'verified' && d.verified !== 'true')    ok = false;
            if (quickFilter === 'has-video'&& d.hasVideo !== 'true')    ok = false;
            if (q  && !(d.name||'').includes(q))   ok = false;
            if (mk && d.make  !== mk)              ok = false;
            if (bt && d.body  !== bt)              ok = false;
            if (tr && d.trans !== tr)              ok = false;
            if (fu && d.fuel  !== fu)              ok = false;
            const yr = parseInt(d.year);
            if (yf && yr < parseInt(yf))           ok = false;
            if (yt && yr > parseInt(yt))           ok = false;
            const pr = parseInt(d.price);
            if (pr < priceMin || pr > priceMax)    ok = false;
            const ml = parseInt(d.mileage);
            if (mf && ml < parseInt(mf))           ok = false;
            if (mt && ml > parseInt(mt))           ok = false;
            card.style.display = ok ? '' : 'none';
            if (ok) vis++;
        });
        $('js-count').textContent = vis;
    }

    function pill(btn, min, max) {
        priceMin = min; priceMax = max;
        $$('.vp-bp').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        const sel = $('js-budget-select');
        if (sel) sel.value = min + '|' + max;
        filter();
    }

    function budgetSelect() {
        const sel = $('js-budget-select');
        const [min, max] = sel.value.split('|').map(Number);
        priceMin = min; priceMax = max;
        $$('.vp-bp').forEach(p => {
            p.classList.toggle('active', parseInt(p.dataset.min) === min && parseInt(p.dataset.max) === max);
        });
        filter();
    }

    function quick(type) {
        quickFilter = type;
        $$('.vp-chip').forEach(b => b.classList.toggle('active', b.dataset.filter === type));
        filter();
    }

    function sort() {
        const v   = $('js-sort').value;
        const con = $('js-grid');
        [...$$('.vp-card')].sort((a, b) => {
            const ad = a.dataset, bd = b.dataset;
            if (v === 'price-low')   return +ad.price   - +bd.price;
            if (v === 'price-high')  return +bd.price   - +ad.price;
            if (v === 'year-new')    return +bd.year    - +ad.year;
            if (v === 'year-old')    return +ad.year    - +bd.year;
            if (v === 'mileage-low') return +ad.mileage - +bd.mileage;
            return 0;
        }).forEach(c => con.appendChild(c));
    }

    function clear() {
        ['js-search','js-make','js-body','js-trans','js-fuel',
         'js-year-from','js-year-to','js-mil-from','js-mil-to'].forEach(id => {
            const el = $(id); if (el) el.value = '';
        });
        priceMin = 0; priceMax = 99000000; quickFilter = 'all';
        $$('.vp-chip').forEach(b => b.classList.toggle('active', b.dataset.filter === 'all'));
        $$('.vp-bp').forEach(p => p.classList.remove('active'));
        const allPill = document.querySelector('.vp-bp[data-max="99000000"]');
        if (allPill) allPill.classList.add('active');
        const bs = $('js-budget-select');
        if (bs) bs.value = '0|99000000';
        history.replaceState(null,'',window.location.pathname);
        filter();
    }

    function currency() {
        const sel = $('js-currency');
        const opt = sel.options[sel.selectedIndex];
        curRate = parseFloat(opt.dataset.rate);
        curSym  = opt.dataset.sym;
        curCode = opt.value;
        $$('.vp-price').forEach(el => {
            const base = parseFloat(el.dataset.base);
            el.textContent = fmt(base * curRate);
        });
    }

    function fmt(n) {
        return (['KES','UGX','TZS'].includes(curCode))
            ? `${curSym} ${Math.round(n).toLocaleString()}`
            : `${curSym}${Math.round(n).toLocaleString()}`;
    }

    function toggleAdv() {
        advOpen = !advOpen;
        const panel = $('js-adv-panel');
        const chev  = $('js-adv-chev');
        const lbl   = $('js-adv-label');
        const btn   = $('js-adv-toggle');
        if (advOpen) {
            panel.style.maxHeight = (panel.scrollHeight + 300) + 'px';
            panel.classList.add('open');
            chev.classList.add('open');
            lbl.textContent = 'Hide';
            btn.classList.add('active');
        } else {
            panel.style.maxHeight = '0';
            panel.classList.remove('open');
            chev.classList.remove('open');
            lbl.textContent = 'Filters';
            btn.classList.remove('active');
        }
    }

    function view(type) {
        $$('.vp-vbtn').forEach(b => b.classList.toggle('active', b.dataset.view === type));
        $('js-grid').classList.toggle('list-view', type === 'list');
    }

    function openVideo(e, url, name) {
        e.preventDefault(); e.stopPropagation();
        if (!url || !url.trim()) return;
        $('vpm-src').src = url;
        $('vpm-name').textContent = name;
        $('vpm-video').load();
        $('vpm-overlay').style.display = 'flex';
        $('vp-video-modal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeVideo() {
        const v = $('vpm-video');
        v.pause(); v.currentTime = 0;
        $('vp-video-modal').classList.remove('open');
        document.body.style.overflow = '';
    }

    function startVideo() {
        const v = $('vpm-video');
        v.play().then(() => $('vpm-overlay').style.display = 'none')
                .catch(err => console.warn(err));
    }

    function openPay(e, carId, price, name) {
        e.stopPropagation();
        payCarId = carId; payCarName = name; payCarPrice = price;
        $('mpm-car-name').textContent      = name;
        $('mpm-amount-display').textContent= 'KSh ' + Number(price).toLocaleString();
        $('mpm-amount-inline').textContent = Number(price).toLocaleString();
        $('mpm-acct').textContent          = 'RPT-' + carId;
        $('mpm-sum-car').textContent       = name;
        $('mpm-sum-amt').textContent       = 'KSh ' + Number(price).toLocaleString();
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

    function hideErr() { $('mpm-err').classList.add('hidden'); }

    function submitPay() {
        const code = ($('mpm-code').value || '').trim();
        if (code.length < 8) { $('mpm-err-txt').textContent = 'Enter a valid M-Pesa code (min 8 characters)'; $('mpm-err').classList.remove('hidden'); return; }
        const csrf = document.querySelector('meta[name="csrf-token"]');
        if (!csrf) { $('mpm-err-txt').textContent = 'Page error — please refresh.'; $('mpm-err').classList.remove('hidden'); return; }
        const btn = $('mpm-submit');
        btn.disabled = true;
        $('mpm-submit-txt').textContent = 'Submitting…';
        $('mpm-submit-ico').classList.add('hidden');
        $('mpm-spinner').classList.remove('hidden');
        const reset = () => {
            btn.disabled = false;
            $('mpm-submit-txt').textContent = 'Verify & get report';
            $('mpm-submit-ico').classList.remove('hidden');
            $('mpm-spinner').classList.add('hidden');
        };
        fetch(`/vehicles/${payCarId}/submit-report-payment`, {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf.getAttribute('content')},
            body: JSON.stringify({mpesa_code:code,amount:payCarPrice})
        })
        .then(res => {
            if (res.status === 419) throw new Error('csrf');
            if (res.status === 401) { window.location.href='/sell?redirect='+encodeURIComponent(location.href); throw new Error('unauth'); }
            if (!res.ok) throw new Error('http_'+res.status);
            return res.json();
        })
        .then(data => {
            reset();
            if (data.success) {
                $('mpm-ok-code').textContent = code;
                $('mpm-ok-car').textContent  = payCarName;
                payStep(3);
            } else {
                $('mpm-err-txt').textContent = data.message || 'Something went wrong.';
                $('mpm-err').classList.remove('hidden');
            }
        })
        .catch(err => {
            if (err.message === 'unauth') return;
            reset();
            if (err.message === 'csrf') { $('mpm-err-txt').textContent = 'Session expired — refresh the page.'; }
            else { $('mpm-err-txt').textContent = 'Request failed. Check your connection.'; }
            $('mpm-err').classList.remove('hidden');
        });
    }

    function copy(text) {
        navigator.clipboard.writeText(text).catch(() => {
            const el = document.createElement('textarea');
            el.value = text; document.body.appendChild(el);
            el.select(); document.execCommand('copy');
            document.body.removeChild(el);
        });
        toast('Copied: ' + text);
    }

    function copyAcct() { copy('RPT-' + payCarId); }

    function toast(msg) {
        const t = $('vp-toast');
        if (!t) return;
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 2000);
    }

    function initURL() {
        const p = new URLSearchParams(location.search);
        const q = p.get('query') || p.get('search') || '';
        if (q) $('js-search').value = q;
        const make = p.get('make') || '';
        if (make) { $('js-make').value = make.toLowerCase(); if (!advOpen) toggleAdv(); }
        const pMin = parseInt(p.get('price_min') || '0');
        const pMax = parseInt(p.get('price_max') || '99000000');
        if (p.has('price_min') || p.has('price_max')) { priceMin = pMin; priceMax = pMax; }
        if ([...p.keys()].length > 0) filter();
    }

    document.addEventListener('DOMContentLoaded', () => {
        const video = $('vpm-video');
        const ov    = $('vpm-overlay');
        if (video) {
            video.addEventListener('play',  () => ov.style.display = 'none');
            video.addEventListener('pause', () => { if (video.currentTime < 0.5) ov.style.display = 'flex'; });
        }
        document.addEventListener('keydown', e => {
            if (e.key !== 'Escape') return;
            if ($('vp-video-modal')?.classList.contains('open')) closeVideo();
            if ($('vp-mpesa-modal')?.classList.contains('open')) closePay();
        });
        initURL();
    });

    return { filter, pill, budgetSelect, quick, sort, clear, currency, toggleAdv,
             view, openVideo, closeVideo, startVideo,
             openPay, closePay, payStep, hideErr, submitPay, copy, copyAcct };
})();
</script>

@endsection
