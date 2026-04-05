{{-- resources/views/cars/show.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="vd-root">

    {{-- ══════════════ HERO STRIP ══════════════ --}}
    <div class="vd-hero">
        <div class="vd-hero__inner">
            <div class="vd-hero__meta">
                <a href="{{ url('/vehicles') }}" class="vd-back">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    Back to Vehicles
                </a>
                <div class="vd-badges">
                    @if($car->availability === 'Available')
                        <span class="badge badge--green">● Available</span>
                    @else
                        <span class="badge badge--grey">● {{ $car->availability }}</span>
                    @endif
                    @if($car->origin === 'local')
                        <span class="badge badge--outline">In Kenya</span>
                    @else
                        {{-- <span class="badge badge--outline">Import</span> --}}
                    @endif
                </div>
            </div>

            <div class="vd-hero__title-row">
                <div>
                    <h1 class="vd-name">{{ $car->name }}</h1>
                    <span class="vd-year">{{ $car->year }} · {{ $car->car_type }}</span>
                </div>
                <div class="vd-price-block">
                    <span class="vd-price-label">Price</span>
                    <span class="vd-price">KSh {{ number_format($car->price) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════ MAIN LAYOUT ══════════════ --}}
    <div class="vd-body">
        <div class="vd-body__inner">

            {{-- LEFT COLUMN --}}
            <div class="vd-col-left">

                {{-- Gallery --}}
                @if($car->images && count($car->images) > 0)
                <div class="vd-gallery">
                    <div class="vd-gallery__main">
                        <img id="mainImg" src="{{ asset('storage/' . $car->images[0]) }}" alt="{{ $car->name }}">
                        <div class="vd-gallery__overlay-count">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            {{ count($car->images) }} Photos
                        </div>
                    </div>
                    @if(count($car->images) > 1)
                    <div class="vd-gallery__thumbs">
                        @foreach($car->images as $index => $img)
                            <div class="vd-gallery__thumb {{ $index === 0 ? 'active' : '' }}"
                                 onclick="changeImage('{{ asset('storage/' . $img) }}', this)">
                                <img src="{{ asset('storage/' . $img) }}" alt="{{ $car->name }}">
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif

                {{-- Video --}}
                @if($car->video)
                <div class="vd-card vd-video-card">
                    <div class="vd-card__header">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                        Video Walkthrough
                    </div>
                    <div class="vd-video__wrap">
                        <video id="carVideo" controls preload="metadata">
                            <source src="{{ asset('storage/' . $car->video) }}" type="video/mp4">
                            <source src="{{ asset('storage/' . $car->video) }}" type="video/webm">
                        </video>
                        <div class="vd-video__bar">
                            <span>🔊 Turn up sound for best experience</span>
                            <button onclick="openFullscreen()" class="vd-fs-btn">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3"/></svg>
                                Fullscreen
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Description --}}
                @if($car->description)
                <div class="vd-card">
                    <div class="vd-card__header">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                        Description
                    </div>
                    <p class="vd-description">{{ $car->description }}</p>
                </div>
                @endif

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="vd-col-right">

                {{-- Quick Stats --}}
                <div class="vd-stats-grid">
                    @if($car->mileage)
                    <div class="vd-stat">
                        <div class="vd-stat__icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div class="vd-stat__info">
                            <span class="vd-stat__val">{{ number_format($car->mileage) }} km</span>
                            <span class="vd-stat__label">Mileage</span>
                        </div>
                    </div>
                    @endif
                    @if($car->engine_size)
                    <div class="vd-stat">
                        <div class="vd-stat__icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="7" width="20" height="10" rx="2"/><path d="M6 7V5a1 1 0 011-1h4a1 1 0 011 1v2"/><line x1="12" y1="12" x2="12" y2="12"/></svg>
                        </div>
                        <div class="vd-stat__info">
                            <span class="vd-stat__val">{{ $car->engine_size }}cc</span>
                            <span class="vd-stat__label">Engine</span>
                        </div>
                    </div>
                    @endif
                    @if($car->fuel_type)
                    <div class="vd-stat">
                        <div class="vd-stat__icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 22V10l9-8 9 8v12H3z"/><path d="M9 22V12h6v10"/></svg>
                        </div>
                        <div class="vd-stat__info">
                            <span class="vd-stat__val">{{ $car->fuel_type }}</span>
                            <span class="vd-stat__label">Fuel Type</span>
                        </div>
                    </div>
                    @endif
                    @if($car->transmission)
                    <div class="vd-stat">
                        <div class="vd-stat__icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="5" cy="6" r="2"/><circle cx="19" cy="6" r="2"/><circle cx="12" cy="18" r="2"/><line x1="5" y1="8" x2="5" y2="14"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="5" y1="14" x2="12" y2="16"/><line x1="19" y1="14" x2="12" y2="16"/></svg>
                        </div>
                        <div class="vd-stat__info">
                            <span class="vd-stat__val">{{ $car->transmission }}</span>
                            <span class="vd-stat__label">Transmission</span>
                        </div>
                    </div>
                    @endif
                    @if($car->horse_power)
                    <div class="vd-stat">
                        <div class="vd-stat__icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        </div>
                        <div class="vd-stat__info">
                            <span class="vd-stat__val">{{ $car->horse_power }} hp</span>
                            <span class="vd-stat__label">Power</span>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Vehicle Details Card --}}
                <div class="vd-card">
                    <div class="vd-card__header">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Vehicle Details
                    </div>
                    <div class="vd-details-list">
                        <div class="vd-detail-row">
                            <span class="vd-detail-key">Type</span>
                            <span class="vd-detail-val">{{ $car->car_type }}</span>
                        </div>
                        <div class="vd-detail-row">
                            <span class="vd-detail-key">Origin</span>
                            <span class="vd-detail-val">{{ ucfirst($car->origin) }}</span>
                        </div>
                        <div class="vd-detail-row">
                            <span class="vd-detail-key">Status</span>
                            <span class="vd-detail-val">
                                @if($car->availability === 'Available')
                                    <span class="inline-dot green"></span> {{ $car->availability }}
                                @else
                                    <span class="inline-dot grey"></span> {{ $car->availability }}
                                @endif
                            </span>
                        </div>
                        @if($car->year)
                        <div class="vd-detail-row">
                            <span class="vd-detail-key">Year</span>
                            <span class="vd-detail-val">{{ $car->year }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Features --}}
                @if($car->specification && count(array_filter($car->specification)))
                <div class="vd-card">
                    <div class="vd-card__header">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                        Features & Specs
                    </div>
                    <div class="vd-features">
                        @foreach($car->specification as $feature => $value)
                            @if($value)
                                <span class="vd-feature-tag">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    {{ ucwords(str_replace(['_', 'And'], [' ', ' & '], $feature)) }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- CTA --}}
                <div class="vd-cta-card">
                    <div class="vd-cta__price-row">
                        <span>Listed Price</span>
                        <strong>KSh {{ number_format($car->price) }}</strong>
                    </div>
                    <button class="vd-cta-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8 19.79 19.79 0 01.22 2.18 2 2 0 012.2 0h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 14.92z"/></svg>
                        Enquire About This Car
                    </button>
                    <a href="{{ url('/vehicles') }}" class="vd-back-btn">← Back to All Vehicles</a>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* ═══════════════════════════════════════════
   IMPORTS & TOKENS
═══════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=DM+Sans:wght@400;500&display=swap');

:root {
    --red:        #D93025;
    --red-light:  #fdf2f1;
    --dark:       #111827;
    --mid:        #6B7280;
    --light:      #9CA3AF;
    --border:     #E5E7EB;
    --surface:    #F9FAFB;
    --white:      #ffffff;
    --radius:     12px;
    --shadow-sm:  0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.05);
    --shadow-md:  0 4px 16px rgba(0,0,0,.10);
    --transition: 0.2s ease;
}

/* ═══ ROOT ═══ */
.vd-root {
    font-family: 'DM Sans', sans-serif;
    background: var(--surface);
    min-height: 100vh;
    color: var(--dark);
}

/* ═══ HERO ═══ */
.vd-hero {
    background: var(--white);
    border-bottom: 1px solid var(--border);
    padding: 100px 0 28px;
}
.vd-hero__inner {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 24px;
}
.vd-hero__meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}
.vd-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--mid);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: color var(--transition);
}
.vd-back:hover { color: var(--dark); }

.vd-badges { display: flex; gap: 8px; flex-wrap: wrap; }
.badge {
    font-family: 'Sora', sans-serif;
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: .04em;
    padding: 4px 12px;
    border-radius: 100px;
    text-transform: uppercase;
}
.badge--green  { background: #ECFDF5; color: #065F46; }
.badge--grey   { background: #F3F4F6; color: #374151; }
.badge--outline{ background: transparent; border: 1.5px solid var(--border); color: var(--mid); }

.vd-hero__title-row {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}
.vd-name {
    font-family: 'Sora', sans-serif;
    font-size: 2.4rem;
    font-weight: 700;
    margin: 0 0 6px;
    line-height: 1.15;
    color: var(--dark);
}
.vd-year {
    font-size: 0.95rem;
    color: var(--mid);
    font-weight: 500;
}
.vd-price-block {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 2px;
}
.vd-price-label { font-size: 0.78rem; color: var(--light); font-weight: 500; text-transform: uppercase; letter-spacing: .06em; }
.vd-price {
    font-family: 'Sora', sans-serif;
    font-size: 2rem;
    font-weight: 700;
    color: var(--red);
    line-height: 1;
}

/* ═══ BODY LAYOUT ═══ */
.vd-body { padding: 32px 0 80px; }
.vd-body__inner {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 24px;
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 28px;
    align-items: start;
}

/* ═══ GALLERY ═══ */
.vd-gallery { margin-bottom: 24px; }
.vd-gallery__main {
    position: relative;
    width: 100%;
    height: 440px;
    border-radius: var(--radius);
    overflow: hidden;
    background: #000;
    box-shadow: var(--shadow-md);
    margin-bottom: 12px;
}
.vd-gallery__main img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.vd-gallery__main:hover img { transform: scale(1.02); }

.vd-gallery__overlay-count {
    position: absolute;
    bottom: 14px;
    right: 14px;
    background: rgba(0,0,0,.62);
    backdrop-filter: blur(8px);
    color: #fff;
    font-size: 0.8rem;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 100px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.vd-gallery__thumbs {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 4px;
    scrollbar-width: thin;
    scrollbar-color: var(--border) transparent;
}
.vd-gallery__thumb {
    flex-shrink: 0;
    width: 92px;
    height: 64px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 2.5px solid transparent;
    transition: all var(--transition);
    opacity: .65;
}
.vd-gallery__thumb img { width: 100%; height: 100%; object-fit: cover; }
.vd-gallery__thumb:hover { opacity: .9; }
.vd-gallery__thumb.active { border-color: var(--red); opacity: 1; }

/* ═══ CARD ═══ */
.vd-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    margin-bottom: 20px;
    box-shadow: var(--shadow-sm);
}
.vd-card__header {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 16px 20px;
    font-family: 'Sora', sans-serif;
    font-size: 0.88rem;
    font-weight: 600;
    letter-spacing: .03em;
    text-transform: uppercase;
    color: var(--dark);
    border-bottom: 1px solid var(--border);
    background: var(--surface);
}
.vd-card__header svg { color: var(--red); flex-shrink: 0; }

/* ═══ VIDEO ═══ */
.vd-video-card { margin-bottom: 24px; }
.vd-video__wrap { background: #000; }
.vd-video__wrap video {
    width: 100%;
    max-height: 380px;
    display: block;
}
.vd-video__bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 16px;
    background: #18181b;
    color: #9ca3af;
    font-size: 0.78rem;
}
.vd-fs-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: transparent;
    border: 1px solid #3f3f46;
    color: #d1d5db;
    padding: 5px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.76rem;
    font-family: inherit;
    transition: all var(--transition);
}
.vd-fs-btn:hover { background: #27272a; color: white; border-color: #71717a; }

/* ═══ DESCRIPTION ═══ */
.vd-description {
    padding: 18px 20px;
    margin: 0;
    color: #374151;
    line-height: 1.75;
    font-size: 0.95rem;
}

/* ═══ STATS GRID ═══ */
.vd-stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 20px;
}
.vd-stat {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: var(--shadow-sm);
    transition: box-shadow var(--transition);
}
.vd-stat:hover { box-shadow: var(--shadow-md); }
.vd-stat__icon {
    width: 40px;
    height: 40px;
    background: var(--red-light);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--red);
}
.vd-stat__val {
    display: block;
    font-family: 'Sora', sans-serif;
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.2;
}
.vd-stat__label {
    display: block;
    font-size: 0.72rem;
    color: var(--light);
    text-transform: uppercase;
    letter-spacing: .05em;
    font-weight: 500;
    margin-top: 2px;
}

/* ═══ DETAILS LIST ═══ */
.vd-details-list { padding: 4px 0; }
.vd-detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 20px;
    border-bottom: 1px solid var(--border);
}
.vd-detail-row:last-child { border-bottom: none; }
.vd-detail-key {
    font-size: 0.85rem;
    color: var(--mid);
    font-weight: 500;
}
.vd-detail-val {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 6px;
}
.inline-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    display: inline-block;
}
.inline-dot.green { background: #10B981; }
.inline-dot.grey  { background: #9CA3AF; }

/* ═══ FEATURES ═══ */
.vd-features {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    padding: 16px 20px;
}
.vd-feature-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--surface);
    border: 1px solid var(--border);
    color: #374151;
    font-size: 0.8rem;
    font-weight: 500;
    padding: 5px 12px;
    border-radius: 100px;
    transition: all var(--transition);
}
.vd-feature-tag svg { color: #10B981; flex-shrink: 0; }
.vd-feature-tag:hover { background: var(--red-light); border-color: #fca5a5; color: var(--red); }

/* ═══ CTA CARD ═══ */
.vd-cta-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 22px;
    box-shadow: var(--shadow-md);
}
.vd-cta__price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
    font-size: 0.875rem;
    color: var(--mid);
}
.vd-cta__price-row strong {
    font-family: 'Sora', sans-serif;
    font-size: 1.3rem;
    color: var(--dark);
    font-weight: 700;
}
.vd-cta-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: var(--red);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 14px;
    font-family: 'Sora', sans-serif;
    font-size: 0.92rem;
    font-weight: 600;
    cursor: pointer;
    transition: all var(--transition);
    margin-bottom: 10px;
    letter-spacing: .02em;
}
.vd-cta-btn:hover {
    background: #B91C1C;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(217, 48, 37, .35);
}
.vd-back-btn {
    display: block;
    text-align: center;
    color: var(--mid);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    padding: 10px;
    border-radius: 8px;
    transition: all var(--transition);
}
.vd-back-btn:hover { background: var(--surface); color: var(--dark); }

/* ═══ RESPONSIVE ═══ */
@media (max-width: 900px) {
    .vd-body__inner {
        grid-template-columns: 1fr;
    }
    .vd-col-right {
        order: -1;
    }
    .vd-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .vd-gallery__main { height: 280px; }
    .vd-name { font-size: 1.8rem; }
    .vd-price { font-size: 1.6rem; }
    .vd-hero { padding-top: 80px; }
}

@media (max-width: 500px) {
    .vd-hero__title-row { flex-direction: column; align-items: flex-start; }
    .vd-price-block { align-items: flex-start; }
    .vd-stats-grid { grid-template-columns: 1fr 1fr; }
    .vd-name { font-size: 1.5rem; }
}
</style>

<script>
function changeImage(src, el) {
    document.getElementById('mainImg').src = src;
    document.querySelectorAll('.vd-gallery__thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

function openFullscreen() {
    const v = document.getElementById('carVideo');
    if (!v) return;
    (v.requestFullscreen || v.webkitRequestFullscreen || v.mozRequestFullScreen || v.msRequestFullscreen).call(v);
}
</script>

@endsection
