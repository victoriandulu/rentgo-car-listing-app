@extends('layouts.app')

@section('content')

@php
    /* ── Images ── */
    $rawImages = $car->images ?? null;
    $images    = $rawImages
        ? (is_string($rawImages) ? json_decode($rawImages, true) : (array) $rawImages)
        : [];
    $images    = array_values(array_filter((array) $images));
    $mainImage = count($images)
        ? asset('storage/' . ltrim($images[0], '/'))
        : 'https://via.placeholder.com/1200x700/f5ede0/9b8b7e?text=No+Photo';

    /* ── Video ── */
    $videoRaw  = trim((string) ($car->video ?? ''));
    $hasVideo  = ($videoRaw !== '' && $videoRaw !== 'null' && $videoRaw !== '0');
    $videoPath = $hasVideo
        ? (str_starts_with($videoRaw, 'storage/') ? $videoRaw : 'storage/' . $videoRaw)
        : null;
    $videoUrl  = $hasVideo ? asset($videoPath) : '';

    /* ── Meta ── */
    $isVerified = $car->user && $car->user->is_verified;
    $isFeatured = (bool) ($car->featured ?? false);
    $carPrice   = (int)   ($car->price     ?? 0);
    $carMileage = (int)   ($car->mileage   ?? 0);
    $carYear    = (int)   ($car->year      ?? date('Y'));
    $carName    = $car->name               ?? 'Vehicle';
    $carMake    = $car->make               ?? '';
    $carModel   = $car->model              ?? '';
    $carTrans   = ucfirst($car->transmission_type ?? 'Automatic');
    $carFuel    = ucfirst($car->fuel_type         ?? 'Petrol');
    $carBody    = ucfirst($car->body_type         ?? '');
    $carColor   = $car->color              ?? '';
    $carEngine  = $car->engine             ?? '';
    $carDrive   = $car->drive_type         ?? '';
    $carDoors   = $car->doors              ?? '';
    $carLoc     = $car->location           ?? 'Kenya';
    $carDesc    = $car->description        ?? '';
    $carCat     = strtolower($car->category ?? 'local');
    $carId      = $car->id                 ?? 0;
    $sellerName = $car->user->name         ?? 'Dealer';
    $sellerPhone= $car->user->phone        ?? '';
@endphp

<div class="vs">

    {{-- ── Breadcrumb ── --}}
    <div class="vs-breadcrumb">
        <div class="vs-wrap">
            <nav class="vs-bc-nav">
                <a href="{{ url('/') }}">Home</a>
                <span class="vs-bc-sep">›</span>
                <a href="{{ route('vehicles.index') }}">Vehicles</a>
                <span class="vs-bc-sep">›</span>
                <span>{{ $carName }}</span>
            </nav>
        </div>
    </div>

    <div class="vs-wrap vs-layout">

        {{-- ════════════════════════════════════
             LEFT: Gallery + Details
        ════════════════════════════════════ --}}
        <div class="vs-main">

            {{-- ── Gallery ── --}}
            <div class="vs-gallery">

                {{-- Badges on image --}}
                <div class="vs-img-badges">
                    @if($isVerified)
                        <span class="vs-badge vs-badge--v">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                            Verified
                        </span>
                    @endif
                    @if($isFeatured)
                        <span class="vs-badge vs-badge--f">Featured</span>
                    @endif
                    @if($hasVideo)
                        <span class="vs-badge vs-badge--vid">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                            Video
                        </span>
                    @endif
                </div>

                {{-- Main image --}}
                <div class="vs-main-img" id="js-main-img">
                    <img id="js-hero-img" src="{{ $mainImage }}" alt="{{ $carName }}"
                         onerror="this.src='https://via.placeholder.com/1200x700/f5ede0/9b8b7e?text=No+Photo'">

                    @if(count($images) > 1)
                    <button class="vs-arrow vs-arrow--prev" onclick="VS.slide(-1)" aria-label="Previous">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <button class="vs-arrow vs-arrow--next" onclick="VS.slide(1)" aria-label="Next">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                    <div class="vs-img-counter">
                        <span id="js-img-idx">1</span> / {{ count($images) }}
                    </div>
                    @endif

                    @if($hasVideo)
                    <button class="vs-play-overlay" onclick="VS.openVideo('{{ addslashes($videoUrl) }}','{{ addslashes($carName) }}')" aria-label="Watch video">
                        <span class="vs-play-ripple"></span>
                        <div class="vs-play-circle">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                        </div>
                        <span class="vs-play-lbl">Watch Video Walkthrough</span>
                    </button>
                    @endif
                </div>

                {{-- Thumbnails --}}
                @if(count($images) > 1)
                <div class="vs-thumbs" id="js-thumbs">
                    @foreach($images as $i => $img)
                        <button class="vs-thumb {{ $i === 0 ? 'active' : '' }}"
                                onclick="VS.goTo({{ $i }})"
                                data-src="{{ asset('storage/' . ltrim($img, '/')) }}"
                                data-idx="{{ $i }}">
                            <img src="{{ asset('storage/' . ltrim($img, '/')) }}"
                                 alt="{{ $carName }} photo {{ $i + 1 }}"
                                 onerror="this.src='https://via.placeholder.com/120x80/f5ede0/9b8b7e?text=No+Photo'">
                        </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ── Title + price (mobile-first below gallery) ── --}}
            <div class="vs-title-row">
                <div>
                    <div class="vs-eyebrow">
                        {{ $carMake }} {{ $carModel }} &nbsp;·&nbsp; {{ $carYear }}
                        @if($carCat === 'local')
                            <span class="vs-local-tag">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                In Kenya
                            </span>
                        @else
                            <span class="vs-import-tag">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                Import
                            </span>
                        @endif
                    </div>
                    <h1 class="vs-car-title">{{ $carName }}</h1>
                </div>
                <div class="vs-price-block">
                    <div class="vs-price-lbl">Asking Price</div>
                    <div class="vs-price">KSh {{ number_format($carPrice) }}</div>
                </div>
            </div>

            {{-- ── Quick specs strip ── --}}
            <div class="vs-specs-strip">
                <div class="vs-spec-item">
                    <div class="vs-spec-ico">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div>
                        <div class="vs-spec-val">{{ number_format($carMileage) }} km</div>
                        <div class="vs-spec-lbl">Mileage</div>
                    </div>
                </div>
                <div class="vs-spec-div"></div>
                <div class="vs-spec-item">
                    <div class="vs-spec-ico">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg>
                    </div>
                    <div>
                        <div class="vs-spec-val">{{ $carYear }}</div>
                        <div class="vs-spec-lbl">Year</div>
                    </div>
                </div>
                <div class="vs-spec-div"></div>
                <div class="vs-spec-item">
                    <div class="vs-spec-ico">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <div>
                        <div class="vs-spec-val">{{ $carTrans }}</div>
                        <div class="vs-spec-lbl">Transmission</div>
                    </div>
                </div>
                <div class="vs-spec-div"></div>
                <div class="vs-spec-item">
                    <div class="vs-spec-ico">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>
                    </div>
                    <div>
                        <div class="vs-spec-val">{{ $carFuel }}</div>
                        <div class="vs-spec-lbl">Fuel Type</div>
                    </div>
                </div>
                @if($carBody)
                <div class="vs-spec-div"></div>
                <div class="vs-spec-item">
                    <div class="vs-spec-ico">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    </div>
                    <div>
                        <div class="vs-spec-val">{{ $carBody }}</div>
                        <div class="vs-spec-lbl">Body Type</div>
                    </div>
                </div>
                @endif
            </div>

            {{-- ── Description ── --}}
            @if($carDesc)
            <div class="vs-section">
                <h2 class="vs-section-title">About this Vehicle</h2>
                <div class="vs-desc">{{ $carDesc }}</div>
            </div>
            @endif

            {{-- ── Full Specs Table ── --}}
            <div class="vs-section">
                <h2 class="vs-section-title">Full Specifications</h2>
                <div class="vs-specs-grid">
                    @if($carMake)
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Make</span>
                        <span class="vs-sg-val">{{ $carMake }}</span>
                    </div>
                    @endif
                    @if($carModel)
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Model</span>
                        <span class="vs-sg-val">{{ $carModel }}</span>
                    </div>
                    @endif
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Year</span>
                        <span class="vs-sg-val">{{ $carYear }}</span>
                    </div>
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Mileage</span>
                        <span class="vs-sg-val">{{ number_format($carMileage) }} km</span>
                    </div>
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Transmission</span>
                        <span class="vs-sg-val">{{ $carTrans }}</span>
                    </div>
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Fuel Type</span>
                        <span class="vs-sg-val">{{ $carFuel }}</span>
                    </div>
                    @if($carBody)
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Body Type</span>
                        <span class="vs-sg-val">{{ $carBody }}</span>
                    </div>
                    @endif
                    @if($carColor)
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Colour</span>
                        <span class="vs-sg-val">{{ $carColor }}</span>
                    </div>
                    @endif
                    @if($carEngine)
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Engine</span>
                        <span class="vs-sg-val">{{ $carEngine }}</span>
                    </div>
                    @endif
                    @if($carDrive)
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Drive Type</span>
                        <span class="vs-sg-val">{{ $carDrive }}</span>
                    </div>
                    @endif
                    @if($carDoors)
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Doors</span>
                        <span class="vs-sg-val">{{ $carDoors }}</span>
                    </div>
                    @endif
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Location</span>
                        <span class="vs-sg-val">{{ $carLoc }}</span>
                    </div>
                    <div class="vs-sg-row">
                        <span class="vs-sg-key">Category</span>
                        <span class="vs-sg-val">{{ $carCat === 'local' ? 'In Kenya' : 'Import' }}</span>
                    </div>
                </div>
            </div>

            {{-- ── Report section (if available) ── --}}
            @if($car->report ?? false)
            <div class="vs-section">
                <h2 class="vs-section-title">Vehicle Inspection Report</h2>
                <div class="vs-report-card">
                    <div class="vs-report-left">
                        <div class="vs-report-ico">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <div>
                            <div class="vs-report-title">Full Inspection Report Available</div>
                            <div class="vs-report-sub">Get detailed history, condition check &amp; ownership records</div>
                        </div>
                    </div>
                    @auth
                        @php
                            $pmt = \App\Models\ReportPayment::where('car_id', $carId)
                                  ->where('user_id', auth()->id())
                                  ->latest()->first();
                        @endphp
                        @if($pmt && $pmt->status === 'verified')
                            <a href="{{ route('vehicles.report', $carId) }}" class="vs-report-btn vs-report-btn--ok">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                View Report
                            </a>
                        @elseif($pmt && $pmt->status === 'pending')
                            <button class="vs-report-btn vs-report-btn--pend">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Pending Verification
                            </button>
                        @else
                            <button class="vs-report-btn" onclick="VS.openPay({{ $carId }},{{ $car->report_price ?? 0 }},'{{ addslashes($carName) }}')">
                                @if($car->report_price) Buy Report · KSh {{ number_format($car->report_price) }}
                                @else Buy Report @endif
                            </button>
                        @endif
                    @else
                        <a href="{{ route('sell') }}?redirect={{ urlencode(request()->url()) }}" class="vs-report-btn">
                            @if($car->report_price) Buy Report · KSh {{ number_format($car->report_price) }}
                            @else Buy Report @endif
                        </a>
                    @endauth
                </div>
            </div>
            @endif

        </div>{{-- /vs-main --}}


        {{-- ════════════════════════════════════
             RIGHT: Sticky sidebar
        ════════════════════════════════════ --}}
        <aside class="vs-sidebar">
            <div class="vs-sidebar-inner">

                {{-- Price card --}}
                <div class="vs-price-card">
                    <div class="vs-pc-top">
                        <div class="vs-pc-name">{{ $carName }}</div>
                        <div class="vs-pc-year">{{ $carYear }}</div>
                    </div>
                    <div class="vs-pc-price">KSh {{ number_format($carPrice) }}</div>
                    <div class="vs-pc-specs">
                        <span>{{ number_format($carMileage) }} km</span>
                        <span class="vs-pc-dot"></span>
                        <span>{{ $carTrans }}</span>
                        <span class="vs-pc-dot"></span>
                        <span>{{ $carFuel }}</span>
                    </div>
                </div>

                {{-- CTA buttons --}}
                <div class="vs-ctas">
                    @if($sellerPhone)
                    <a href="tel:{{ $sellerPhone }}" class="vs-cta vs-cta--primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Call Seller
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$sellerPhone) }}?text=Hi, I'm interested in the {{ urlencode($carName) }} listed on WE Sell Garis"
                       target="_blank" rel="noopener" class="vs-cta vs-cta--wa">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    @endif

                    @if($hasVideo)
                    <button class="vs-cta vs-cta--video" onclick="VS.openVideo('{{ addslashes($videoUrl) }}','{{ addslashes($carName) }}')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                        Watch Video Walkthrough
                    </button>
                    @endif
                </div>

                {{-- Seller card --}}
                <div class="vs-seller-card">
                    <div class="vs-seller-top">
                        <div class="vs-seller-avatar">
                            {{ strtoupper(substr($sellerName, 0, 1)) }}
                        </div>
                        <div>
                            <div class="vs-seller-name">{{ $sellerName }}</div>
                            <div class="vs-seller-role">
                                @if($isVerified)
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                    Verified Dealer
                                @else
                                    Private Seller
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="vs-seller-loc">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $carLoc }}
                    </div>
                </div>

                {{-- Safety tips --}}
                <div class="vs-safety">
                    <div class="vs-safety-title">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Safety Tips
                    </div>
                    <ul class="vs-safety-list">
                        <li>Meet in a safe, public location</li>
                        <li>Inspect the vehicle before paying</li>
                        <li>Verify ownership documents (logbook)</li>
                        <li>Never pay before seeing the car</li>
                    </ul>
                </div>

            </div>
        </aside>

    </div>{{-- /layout --}}

    {{-- ── Back link ── --}}
    <div class="vs-wrap vs-back-wrap">
        <a href="{{ route('vehicles.index') }}" class="vs-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            Back to Vehicles
        </a>
    </div>

</div>{{-- /vs --}}


{{-- ════════════════════════════════════
     VIDEO MODAL  (reused from listing)
════════════════════════════════════ --}}
<div id="vs-video-modal" class="vpm-overlay" role="dialog" aria-modal="true"
     onclick="if(event.target===this)VS.closeVideo()">
    <div class="vpm-box">
        <div class="vpm-header">
            <div class="vpm-title-row">
                <span class="vpm-ico">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                </span>
                <span id="vsm-name" class="vpm-name">Video Walkthrough</span>
            </div>
            <button class="vpm-close" onclick="VS.closeVideo()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vpm-stage">
            <video id="vsm-video" controls preload="metadata" playsinline>
                <source id="vsm-src" src="" type="video/mp4">
                Your browser does not support video playback.
            </video>
            <div id="vsm-overlay" class="vpm-play-overlay" onclick="VS.startVideo()">
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


{{-- ════════════════════════════════════
     M-PESA MODAL
════════════════════════════════════ --}}
<div id="vs-mpesa-modal" class="mpm-overlay" onclick="if(event.target===this)VS.closePay()">
    <div class="mpm-box">
        <div id="mpm-s1" class="mpm-step active">
            <div class="mpm-header">
                <div class="mpm-logo">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                </div>
                <div>
                    <h2 class="mpm-title">Pay via M-Pesa</h2>
                    <p class="mpm-sub" id="mpm-car-name">Vehicle Report</p>
                </div>
                <button class="mpm-x" onclick="VS.closePay()">
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
                <li><span class="mpm-n">3</span><span>Business No: <strong class="mpm-hl" onclick="VS.copy('247247')">247247</strong>
                    <button class="mpm-copy" onclick="VS.copy('247247')"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg></button></span></li>
                <li><span class="mpm-n">4</span><span>Account No: <strong class="mpm-hl" id="mpm-acct">RPT-0</strong>
                    <button class="mpm-copy" onclick="VS.copyAcct()"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg></button></span></li>
                <li><span class="mpm-n">5</span><span>Amount: <strong class="mpm-hl" id="mpm-amount-inline">0</strong></span></li>
                <li><span class="mpm-n">6</span><span>Enter PIN and confirm</span></li>
            </ol>
            <div class="mpm-note">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                You'll receive an M-Pesa confirmation SMS with a transaction code.
            </div>
            <button class="mpm-next-btn" onclick="VS.payStep(2)">I've Paid — Enter Code <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg></button>
        </div>
        <div id="mpm-s2" class="mpm-step">
            <div class="mpm-header">
                <button class="mpm-back" onclick="VS.payStep(1)"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg></button>
                <div><h2 class="mpm-title">Enter M-Pesa Code</h2><p class="mpm-sub">Confirm your payment</p></div>
                <button class="mpm-x" onclick="VS.closePay()"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
            </div>
            <label class="mpm-lbl">M-Pesa Transaction Code</label>
            <p class="mpm-hint">From your SMS, e.g. <strong>SJK1AB2CD3</strong></p>
            <input id="mpm-code" type="text" class="mpm-code-input" placeholder="e.g. SJK1AB2CD3" maxlength="12"
                   oninput="this.value=this.value.toUpperCase().replace(/[^A-Z0-9]/g,'');VS.hideErr()"
                   autocomplete="off" autocapitalize="characters">
            <div id="mpm-err" class="mpm-err hidden">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span id="mpm-err-txt">Please enter a valid M-Pesa code</span>
            </div>
            <label class="mpm-lbl" style="margin-top:18px">Your Phone Number</label>
            <p class="mpm-hint">We'll send your report access to this number</p>
            <div class="mpm-phone-row">
                <span class="mpm-prefix">+254</span>
                <input id="mpm-phone" type="tel" class="mpm-phone-inp" placeholder="7XX XXX XXX" maxlength="9" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
            </div>
            <div class="mpm-summary">
                <div class="mpm-sum-row"><span>Vehicle</span><strong id="mpm-sum-car">—</strong></div>
                <div class="mpm-sum-row"><span>Amount</span><strong id="mpm-sum-amt">—</strong></div>
                <div class="mpm-sum-row"><span>Paybill</span><strong>247247</strong></div>
            </div>
            <button class="mpm-submit-btn" id="mpm-submit" onclick="VS.submitPay()">
                <span id="mpm-submit-txt">Verify &amp; Get Report</span>
                <svg id="mpm-submit-ico" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <svg id="mpm-spinner" class="mpm-spin hidden" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
            </button>
        </div>
        <div id="mpm-s3" class="mpm-step">
            <div class="mpm-success">
                <div class="mpm-success-ico"><svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                <h2>Payment Verified!</h2>
                <p>Your vehicle report is ready.</p>
                <div class="mpm-detail-box">
                    <div class="mpm-detail-row"><span>Transaction</span><strong id="mpm-ok-code">—</strong></div>
                    <div class="mpm-detail-row"><span>Vehicle</span><strong id="mpm-ok-car">—</strong></div>
                </div>
                <a href="#" id="mpm-report-link" class="mpm-view-report">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    View Full Report
                </a>
                <button class="mpm-done" onclick="VS.closePay()">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Toast --}}
<div id="vs-toast" class="vp-toast">Copied!</div>


{{-- ════════════════════════════════════
     STYLES
════════════════════════════════════ --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;1,600&family=Outfit:wght@300;400;500;600&display=swap');

:root{
    --cream:      #faf6f0;
    --cream-dk:   #f2eade;
    --warm-white: #fffdf9;
    --acc:        #b83228;
    --acc-h:      #9e2820;
    --acc-light:  rgba(184,50,40,.08);
    --purple:     #5b21b6;
    --purple-lt:  rgba(91,33,182,.10);
    --ink:        #1c1712;
    --ink-md:     #5a4b3f;
    --ink-lt:     #9c8b7d;
    --border:     #e6dbd0;
    --border-lt:  #ede5db;
    --success:    #1f6b42;
    --shadow-s:   0 1px 4px rgba(28,23,18,.06);
    --shadow-m:   0 4px 18px rgba(28,23,18,.09);
    --shadow-l:   0 14px 44px rgba(28,23,18,.13);
    --r:          12px;
    --r-sm:       8px;
    --ease:       cubic-bezier(.4,0,.2,1);
    --tr:         all .22s var(--ease);
}

*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Outfit',system-ui,sans-serif;color:var(--ink);background:var(--cream);line-height:1.6}
a{text-decoration:none;color:inherit}
button{font-family:'Outfit',system-ui,sans-serif;cursor:pointer}

/* ── Breadcrumb ── */
.vs-breadcrumb{background:var(--cream-dk);border-bottom:1px solid var(--border);padding:13px 32px}
.vs-wrap{max-width:1340px;margin:0 auto;padding:0 32px}
.vs-bc-nav{display:flex;align-items:center;gap:7px;font-size:12.5px;color:var(--ink-lt)}
.vs-bc-nav a{color:var(--ink-lt);transition:color .2s}.vs-bc-nav a:hover{color:var(--acc)}
.vs-bc-nav span:last-child{color:var(--ink-md);font-weight:500}
.vs-bc-sep{color:var(--border)}

/* ── Layout ── */
.vs-layout{display:grid;grid-template-columns:1fr 340px;gap:32px;padding-top:40px;padding-bottom:60px;align-items:start}

/* ── Gallery ── */
.vs-gallery{margin-bottom:28px}
.vs-main-img{position:relative;aspect-ratio:16/9;border-radius:var(--r);overflow:hidden;background:var(--cream-dk);box-shadow:var(--shadow-m)}
.vs-main-img img{width:100%;height:100%;object-fit:cover;display:block;transition:opacity .3s}
.vs-img-badges{position:absolute;top:14px;left:14px;display:flex;gap:6px;z-index:10;pointer-events:none}
.vs-badge{padding:4px 10px;border-radius:5px;font-size:10.5px;font-weight:700;letter-spacing:.4px;display:inline-flex;align-items:center;gap:4px}
.vs-badge--v{background:var(--success);color:#fff}
.vs-badge--f{background:#9a4e06;color:#fff}
.vs-badge--vid{background:var(--purple);color:#fff}

/* Arrows */
.vs-arrow{position:absolute;top:50%;transform:translateY(-50%);background:rgba(255,253,249,.92);border:1px solid var(--border);border-radius:50%;width:42px;height:42px;display:flex;align-items:center;justify-content:center;color:var(--ink-md);z-index:10;backdrop-filter:blur(4px);transition:var(--tr)}
.vs-arrow:hover{background:#fff;color:var(--acc);border-color:var(--acc)}
.vs-arrow--prev{left:14px}
.vs-arrow--next{right:14px}
.vs-img-counter{position:absolute;bottom:14px;right:14px;background:rgba(28,23,18,.6);color:#fff;padding:4px 10px;border-radius:5px;font-size:12px;font-weight:600;backdrop-filter:blur(4px)}

/* Video play overlay */
.vs-play-overlay{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;background:rgba(28,23,18,.28);z-index:8;backdrop-filter:blur(1px);transition:background .3s;overflow:visible}
.vs-play-overlay:hover{background:rgba(28,23,18,.42)}
.vs-play-ripple{position:absolute;width:88px;height:88px;border-radius:50%;border:2px solid rgba(91,33,182,.45);animation:vs-ripple 2s ease-out infinite;pointer-events:none}
@keyframes vs-ripple{0%{transform:scale(1);opacity:.7}100%{transform:scale(1.9);opacity:0}}
.vs-play-circle{width:68px;height:68px;background:rgba(91,33,182,.9);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;border:3px solid rgba(255,255,255,.25);transition:var(--tr);position:relative;z-index:1}
.vs-play-circle svg{margin-left:4px}
.vs-play-overlay:hover .vs-play-circle{background:var(--purple);transform:scale(1.08)}
.vs-play-lbl{color:#fff;font-size:13.5px;font-weight:600;letter-spacing:.3px;text-shadow:0 1px 6px rgba(0,0,0,.5)}

/* Thumbnails */
.vs-thumbs{display:flex;gap:9px;margin-top:11px;overflow-x:auto;scrollbar-width:none;padding-bottom:2px}
.vs-thumbs::-webkit-scrollbar{display:none}
.vs-thumb{width:90px;height:62px;border-radius:8px;overflow:hidden;flex-shrink:0;border:2.5px solid transparent;transition:var(--tr);opacity:.65;background:var(--cream-dk)}
.vs-thumb:hover{opacity:.9;border-color:var(--border)}
.vs-thumb.active{opacity:1;border-color:var(--acc);box-shadow:0 0 0 1px var(--acc)}
.vs-thumb img{width:100%;height:100%;object-fit:cover;display:block}

/* ── Title row ── */
.vs-title-row{display:flex;justify-content:space-between;align-items:flex-start;gap:20px;margin-bottom:22px}
.vs-eyebrow{font-size:11.5px;font-weight:600;letter-spacing:1.5px;text-transform:uppercase;color:var(--ink-lt);margin-bottom:7px;display:flex;align-items:center;gap:10px}
.vs-local-tag,.vs-import-tag{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:100px;font-size:10px;font-weight:700;letter-spacing:.6px}
.vs-local-tag{background:rgba(31,107,66,.1);color:var(--success)}
.vs-import-tag{background:rgba(184,50,40,.08);color:var(--acc)}
.vs-car-title{font-family:'Cormorant Garamond',Georgia,serif;font-size:clamp(28px,4vw,40px);font-weight:600;color:var(--ink);line-height:1.15;letter-spacing:-.3px}
.vs-price-block{text-align:right;flex-shrink:0}
.vs-price-lbl{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:1.2px;color:var(--ink-lt);margin-bottom:4px}
.vs-price{font-family:'Cormorant Garamond',Georgia,serif;font-size:clamp(26px,3.5vw,36px);font-weight:600;color:var(--acc);letter-spacing:-.5px}

/* ── Specs strip ── */
.vs-specs-strip{display:flex;align-items:center;gap:0;background:var(--warm-white);border:1px solid var(--border-lt);border-radius:var(--r);padding:18px 24px;margin-bottom:28px;flex-wrap:wrap;gap:10px;box-shadow:var(--shadow-s)}
.vs-spec-item{display:flex;align-items:center;gap:11px}
.vs-spec-ico{width:36px;height:36px;background:var(--acc-light);border-radius:9px;display:flex;align-items:center;justify-content:center;color:var(--acc);flex-shrink:0}
.vs-spec-val{font-size:14px;font-weight:600;color:var(--ink);line-height:1.2}
.vs-spec-lbl{font-size:11px;color:var(--ink-lt);font-weight:400}
.vs-spec-div{width:1px;height:36px;background:var(--border-lt)}

/* ── Sections ── */
.vs-section{margin-bottom:32px}
.vs-section-title{font-family:'Cormorant Garamond',Georgia,serif;font-size:22px;font-weight:600;color:var(--ink);margin-bottom:16px;padding-bottom:10px;border-bottom:1px solid var(--border-lt)}
.vs-desc{font-size:14.5px;color:var(--ink-md);line-height:1.75;font-weight:300}

/* ── Specs grid ── */
.vs-specs-grid{background:var(--warm-white);border:1px solid var(--border-lt);border-radius:var(--r);overflow:hidden;box-shadow:var(--shadow-s)}
.vs-sg-row{display:flex;justify-content:space-between;align-items:center;padding:13px 20px;border-bottom:1px solid var(--border-lt);transition:background .18s}
.vs-sg-row:last-child{border-bottom:none}
.vs-sg-row:hover{background:var(--cream)}
.vs-sg-key{font-size:13px;color:var(--ink-lt);font-weight:500}
.vs-sg-val{font-size:13.5px;color:var(--ink);font-weight:600;text-align:right}

/* ── Report card ── */
.vs-report-card{background:var(--warm-white);border:1.5px solid var(--border);border-radius:var(--r);padding:18px 20px;display:flex;align-items:center;gap:16px;justify-content:space-between;flex-wrap:wrap;box-shadow:var(--shadow-s)}
.vs-report-left{display:flex;align-items:center;gap:14px}
.vs-report-ico{width:44px;height:44px;background:var(--acc-light);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--acc);flex-shrink:0}
.vs-report-title{font-size:14px;font-weight:600;color:var(--ink);margin-bottom:3px}
.vs-report-sub{font-size:12.5px;color:var(--ink-lt)}
.vs-report-btn{padding:11px 18px;background:var(--acc);color:#fff;border:none;border-radius:var(--r-sm);font-size:13px;font-weight:600;display:inline-flex;align-items:center;gap:6px;transition:var(--tr);white-space:nowrap;text-decoration:none}
.vs-report-btn:hover{background:var(--acc-h);transform:translateY(-1px);box-shadow:var(--shadow-m)}
.vs-report-btn--ok{background:var(--success)}
.vs-report-btn--ok:hover{background:#165c38}
.vs-report-btn--pend{background:var(--ink-lt);cursor:default;opacity:.75}
.vs-report-btn--pend:hover{transform:none;box-shadow:none}

/* ── Sidebar ── */
.vs-sidebar-inner{position:sticky;top:28px;display:flex;flex-direction:column;gap:16px}

/* Price card */
.vs-price-card{background:var(--warm-white);border:1px solid var(--border-lt);border-radius:var(--r);padding:20px;box-shadow:var(--shadow-m)}
.vs-pc-top{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:12px}
.vs-pc-name{font-size:14px;font-weight:600;color:var(--ink)}
.vs-pc-year{font-size:13px;color:var(--ink-lt)}
.vs-pc-price{font-family:'Cormorant Garamond',Georgia,serif;font-size:30px;font-weight:600;color:var(--acc);letter-spacing:-.3px;margin-bottom:11px}
.vs-pc-specs{display:flex;align-items:center;gap:7px;font-size:12px;color:var(--ink-md);flex-wrap:wrap}
.vs-pc-dot{width:3px;height:3px;border-radius:50%;background:var(--border)}

/* CTAs */
.vs-ctas{display:flex;flex-direction:column;gap:9px}
.vs-cta{display:flex;align-items:center;justify-content:center;gap:9px;padding:14px 20px;border-radius:var(--r-sm);font-size:14px;font-weight:600;border:none;transition:var(--tr)}
.vs-cta--primary{background:var(--acc);color:#fff}
.vs-cta--primary:hover{background:var(--acc-h);transform:translateY(-1px);box-shadow:0 5px 18px rgba(184,50,40,.22)}
.vs-cta--wa{background:#25d366;color:#fff}
.vs-cta--wa:hover{background:#20b858;transform:translateY(-1px);box-shadow:0 5px 18px rgba(37,211,102,.25)}
.vs-cta--video{background:var(--purple-lt);color:var(--purple);border:1.5px solid rgba(91,33,182,.25)}
.vs-cta--video:hover{background:rgba(91,33,182,.16);border-color:var(--purple);transform:translateY(-1px)}

/* Seller card */
.vs-seller-card{background:var(--warm-white);border:1px solid var(--border-lt);border-radius:var(--r);padding:16px;box-shadow:var(--shadow-s)}
.vs-seller-top{display:flex;align-items:center;gap:12px;margin-bottom:11px}
.vs-seller-avatar{width:44px;height:44px;background:var(--acc);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;font-family:'Cormorant Garamond',Georgia,serif;flex-shrink:0}
.vs-seller-name{font-size:14px;font-weight:600;color:var(--ink);margin-bottom:3px}
.vs-seller-role{font-size:12px;color:var(--success);display:flex;align-items:center;gap:4px;font-weight:500}
.vs-seller-loc{display:flex;align-items:center;gap:5px;font-size:12.5px;color:var(--ink-lt);padding-top:10px;border-top:1px solid var(--border-lt)}

/* Safety */
.vs-safety{background:#fffbeb;border:1px solid #fcd34d;border-radius:var(--r);padding:14px 16px}
.vs-safety-title{display:flex;align-items:center;gap:7px;font-size:12.5px;font-weight:700;color:#92400e;margin-bottom:10px}
.vs-safety-list{list-style:none;display:flex;flex-direction:column;gap:6px}
.vs-safety-list li{font-size:12px;color:#78350f;padding-left:14px;position:relative;line-height:1.5}
.vs-safety-list li::before{content:'·';position:absolute;left:0;color:#d97706;font-weight:700}

/* Back link */
.vs-back-wrap{padding-bottom:40px}
.vs-back{display:inline-flex;align-items:center;gap:6px;font-size:13.5px;font-weight:500;color:var(--ink-lt);transition:var(--tr)}
.vs-back:hover{color:var(--acc)}

/* ─── VIDEO MODAL (same as listing page) ─── */
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
.vpm-big-play{width:78px;height:78px;background:rgba(91,33,182,.9);border:3px solid rgba(255,255,255,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;transition:var(--tr);box-shadow:0 8px 30px rgba(91,33,182,.45)}
.vpm-big-play svg{margin-left:4px}
.vpm-play-overlay:hover .vpm-big-play{transform:scale(1.09);background:var(--purple)}
.vpm-hint{font-size:13px;color:rgba(255,255,255,.6);font-weight:500;letter-spacing:.4px}
.vpm-footer{display:flex;align-items:center;gap:8px;padding:12px 18px;border-top:1px solid rgba(255,255,255,.05);font-size:12px;color:rgba(255,255,255,.3)}
.vpm-footer svg{flex-shrink:0;color:var(--purple);opacity:.65}

/* ─── MPESA MODAL ─── */
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
@media(max-width:1100px){
    .vs-layout{grid-template-columns:1fr 300px;gap:24px}
    .vs-specs-strip{gap:8px}
    .vs-spec-div{display:none}
}
@media(max-width:860px){
    .vs-layout{grid-template-columns:1fr;gap:0}
    .vs-sidebar{order:-1;margin-bottom:28px}
    .vs-sidebar-inner{position:static}
    .vs-price-block{display:none}/* shown in sidebar */
    .vs-wrap{padding:0 20px}
    .vs-breadcrumb{padding:12px 20px}
    .vs-title-row{flex-direction:column;gap:10px}
}
@media(max-width:600px){
    .vs-specs-strip{flex-direction:column;align-items:flex-start;gap:14px;padding:16px}
    .vpm-box{max-width:100%}
    .vs-arrow{display:none}
}
</style>


{{-- ════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════ --}}
<script>
const VS = (() => {
    /* ── Gallery ── */
    @php echo 'const IMAGES = ' . json_encode(array_values(array_map(fn($img) => asset('storage/' . ltrim($img, '/')), $images))) . ';'; @endphp
    let currentIdx = 0;

    function goTo(idx) {
        if (!IMAGES.length) return;
        idx = ((idx % IMAGES.length) + IMAGES.length) % IMAGES.length;
        currentIdx = idx;
        const hero = document.getElementById('js-hero-img');
        if (hero) {
            hero.style.opacity = '0.5';
            hero.src = IMAGES[idx];
            hero.onload = () => { hero.style.opacity = '1'; };
        }
        const ctr = document.getElementById('js-img-idx');
        if (ctr) ctr.textContent = idx + 1;
        document.querySelectorAll('.vs-thumb').forEach(t => {
            t.classList.toggle('active', parseInt(t.dataset.idx) === idx);
        });
    }

    function slide(dir) { goTo(currentIdx + dir); }

    /* Keyboard nav */
    document.addEventListener('keydown', e => {
        if (e.key === 'ArrowLeft')  slide(-1);
        if (e.key === 'ArrowRight') slide(1);
        if (e.key === 'Escape') {
            closeVideo();
            closePay();
        }
    });

    /* ── Video modal ── */
    function openVideo(url, name) {
        if (!url || !url.trim()) return;
        document.getElementById('vsm-src').src = url;
        document.getElementById('vsm-name').textContent = name + ' — Video Walkthrough';
        const v = document.getElementById('vsm-video');
        v.load();
        document.getElementById('vsm-overlay').style.display = 'flex';
        document.getElementById('vs-video-modal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeVideo() {
        const modal = document.getElementById('vs-video-modal');
        const video = document.getElementById('vsm-video');
        if (video) { video.pause(); video.currentTime = 0; }
        modal && modal.classList.remove('open');
        document.body.style.overflow = '';
    }

    function startVideo() {
        const video   = document.getElementById('vsm-video');
        const overlay = document.getElementById('vsm-overlay');
        video.play().then(() => { overlay.style.display = 'none'; }).catch(() => {});
    }

    document.addEventListener('DOMContentLoaded', () => {
        const video   = document.getElementById('vsm-video');
        const overlay = document.getElementById('vsm-overlay');
        if (video && overlay) {
            video.addEventListener('play',  () => { overlay.style.display = 'none'; });
            video.addEventListener('pause', () => { if (video.currentTime < 0.5) overlay.style.display = 'flex'; });
        }
    });

    /* ── M-Pesa modal ── */
    let payCarId = null, payCarName = null, payCarPrice = null;

    function openPay(carId, price, name) {
        payCarId    = carId;
        payCarName  = name;
        payCarPrice = price;
        document.getElementById('mpm-car-name').textContent       = name;
        document.getElementById('mpm-amount-display').textContent = 'KSh ' + Number(price).toLocaleString();
        document.getElementById('mpm-amount-inline').textContent  = Number(price).toLocaleString();
        document.getElementById('mpm-acct').textContent           = 'RPT-' + carId;
        document.getElementById('mpm-sum-car').textContent        = name;
        document.getElementById('mpm-sum-amt').textContent        = 'KSh ' + Number(price).toLocaleString();
        payStep(1);
        document.getElementById('mpm-code').value = '';
        hideErr();
        document.getElementById('vs-mpesa-modal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closePay() {
        document.getElementById('vs-mpesa-modal').classList.remove('open');
        document.body.style.overflow = '';
    }

    function payStep(n) {
        document.querySelectorAll('.mpm-step').forEach(s => s.classList.remove('active'));
        document.getElementById('mpm-s' + n).classList.add('active');
    }

    function hideErr() { document.getElementById('mpm-err').classList.add('hidden'); }

    function _showErr(msg) {
        document.getElementById('mpm-err-txt').textContent = msg;
        document.getElementById('mpm-err').classList.remove('hidden');
    }

    function submitPay() {
        const code = (document.getElementById('mpm-code').value || '').trim();
        if (code.length < 8) { _showErr('Please enter a valid M-Pesa code (min 8 characters)'); return; }
        const csrf = document.querySelector('meta[name="csrf-token"]');
        if (!csrf) { _showErr('Page error — please refresh.'); return; }

        const btn  = document.getElementById('mpm-submit');
        const txt  = document.getElementById('mpm-submit-txt');
        const ico  = document.getElementById('mpm-submit-ico');
        const spin = document.getElementById('mpm-spinner');
        btn.disabled = true; txt.textContent = 'Submitting…';
        ico.classList.add('hidden'); spin.classList.remove('hidden');

        const reset = () => {
            btn.disabled = false; txt.textContent = 'Verify & Get Report';
            ico.classList.remove('hidden'); spin.classList.add('hidden');
        };

        fetch(`/vehicles/${payCarId}/submit-report-payment`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf.getAttribute('content') },
            body: JSON.stringify({ mpesa_code: code, amount: payCarPrice })
        })
        .then(res => {
            if (res.status === 419) throw new Error('csrf');
            if (res.status === 401) { window.location.href = '/sell?redirect=' + encodeURIComponent(location.href); throw new Error('unauth'); }
            if (!res.ok) throw new Error('http_' + res.status);
            return res.json();
        })
        .then(data => {
            reset();
            if (data.success) {
                document.getElementById('mpm-ok-code').textContent = code;
                document.getElementById('mpm-ok-car').textContent  = payCarName;
                payStep(3);
            } else {
                _showErr(data.message || 'Something went wrong.');
            }
        })
        .catch(err => {
            if (err.message === 'unauth') return;
            reset();
            if (err.message === 'csrf') _showErr('Session expired — please refresh.');
            else _showErr('Request failed. Check your connection.');
        });
    }

    /* ── Copy ── */
    function copy(text) {
        navigator.clipboard.writeText(text).catch(() => {
            const el = document.createElement('textarea');
            el.value = text; document.body.appendChild(el);
            el.select(); document.execCommand('copy');
            document.body.removeChild(el);
        });
        _toast('Copied: ' + text);
    }

    function copyAcct() { copy('RPT-' + payCarId); }

    function _toast(msg) {
        const t = document.getElementById('vs-toast');
        if (!t) return;
        t.textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 2200);
    }

    return { goTo, slide, openVideo, closeVideo, startVideo,
             openPay, closePay, payStep, hideErr, submitPay,
             copy, copyAcct };
})();
</script>

@endsection
