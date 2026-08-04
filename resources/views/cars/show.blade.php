{{-- resources/views/cars/show.blade.php --}}
@extends('layouts.app')

@section('content')

@php
    $images = [];
    if ($car->images) {
        $raw = is_string($car->images) ? json_decode($car->images, true) : (array) $car->images;
        $images = array_values(array_filter((array) $raw));
    }
    $mainImage = count($images)
        ? asset('storage/' . ltrim($images[0], '/'))
        : 'https://via.placeholder.com/1200x800/1a1a2e/ffffff?text=No+Photo';

    $hasVideo = !empty($car->video) && $car->video !== 'null';
    $videoUrl = $hasVideo ? asset('storage/' . ltrim($car->video, '/')) : '';

    $whatsappNumber = '2547174753336';
    $whatsappMessage = urlencode('Hello! I am interested in the ' . ($car->name ?? 'vehicle') . ' listed at KSh ' . number_format($car->price ?? 0) . '. Please provide more details.');
    $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . $whatsappMessage;

    // Runtime costs (if provided) as key => value pairs, same pattern as specification
    $runningCosts = (array) ($car->running_cost ?? []);
    $hasRunningCosts = count(array_filter($runningCosts, fn($v) => $v !== null && $v !== ''));
@endphp

<div class="cs-root">

    {{-- HERO --}}
    <div class="cs-hero">
        <div class="cs-hero__inner">
            <a href="{{ url('/vehicles') }}" class="cs-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                All Vehicles
            </a>

            <div class="cs-hero__content">
                <div class="cs-hero__left">
                    <div class="cs-hero__tags">
                        @if(isset($car->availability) && $car->availability === 'Available')
                            <span class="cs-tag cs-tag--green">Available</span>
                        @else
                            <span class="cs-tag cs-tag--grey">{{ $car->availability ?? 'Listed' }}</span>
                        @endif
                        @if(isset($car->origin) && $car->origin === 'local')
                            <span class="cs-tag cs-tag--outline">In Kenya</span>
                        @else
                            <span class="cs-tag cs-tag--outline">Import</span>
                        @endif
                        @if($hasVideo)
                            <span class="cs-tag cs-tag--video">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                                Has Video
                            </span>
                        @endif
                    </div>
                    <h1 class="cs-title">{{ $car->name ?? 'Vehicle' }}</h1>
                    <p class="cs-subtitle">{{ $car->year ?? '' }}{{ isset($car->car_type) ? ' · ' . $car->car_type : '' }}{{ isset($car->location) ? ' · ' . $car->location : '' }}</p>
                </div>
                <div class="cs-hero__right">
                    <span class="cs-price-label">Listed Price</span>
                    <span class="cs-price">KSh {{ number_format($car->price ?? 0) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN BODY --}}
    <div class="cs-body">
        <div class="cs-body__inner">

            {{-- LEFT COLUMN --}}
            <div class="cs-left">

                {{-- GALLERY --}}
                <div class="cs-gallery">
                    <div class="cs-gallery__main" id="galleryMain">
                        <img id="mainImg" src="{{ $mainImage }}" alt="{{ $car->name ?? 'Vehicle' }}"
                             onerror="this.src='https://via.placeholder.com/1200x800/1a1a2e/ffffff?text=No+Photo'">

                        <button class="cs-gallery__expand" onclick="LB.open(0)" aria-label="View fullscreen">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3"/></svg>
                            Expand
                        </button>

                        @if(count($images) > 1)
                        <button class="cs-gallery__arrow cs-gallery__arrow--prev" onclick="LB.galleryNav(-1)" aria-label="Previous">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <button class="cs-gallery__arrow cs-gallery__arrow--next" onclick="LB.galleryNav(1)" aria-label="Next">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                        @endif

                        <div class="cs-gallery__count">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <span id="photoCounter">1</span> / {{ count($images) }}
                        </div>
                    </div>

                    @if(count($images) > 1)
                    <div class="cs-gallery__thumbs" id="thumbsRow">
                        @foreach($images as $index => $img)
                            <button class="cs-thumb {{ $index === 0 ? 'active' : '' }}"
                                    onclick="LB.setMain({{ $index }})"
                                    data-index="{{ $index }}">
                                <img src="{{ asset('storage/' . ltrim($img, '/')) }}"
                                     alt="Photo {{ $index + 1 }}"
                                     onerror="this.src='https://via.placeholder.com/200x140/1a1a2e/ffffff?text=Photo'">
                            </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- MOBILE CTA (shown only on small screens) --}}
                <div class="cs-mobile-cta">
                    <div class="cs-cta__price-row">
                        <span>Listed Price</span>
                        <strong>KSh {{ number_format($car->price ?? 0) }}</strong>
                    </div>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="cs-cta__btn cs-cta__btn--whatsapp">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Enquire on WhatsApp
                    </a>
                    @if($hasVideo)
                    <button class="cs-cta__btn cs-cta__btn--video" onclick="VM.open()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                        Watch Video Walkthrough
                    </button>
                    @endif
                </div>

                {{-- VIDEO PREVIEW --}}
                @if($hasVideo)
                <div class="cs-video-section">
                    <div class="cs-video-header">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                        Video Walkthrough
                        <button class="cs-video-modal-btn" onclick="VM.open()">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3"/></svg>
                            Open fullscreen
                        </button>
                    </div>
                    <div class="cs-video-preview" onclick="VM.open()">
                        <video id="inlineVideo" preload="metadata" muted playsinline>
                            <source src="{{ $videoUrl }}" type="video/mp4">
                        </video>
                        <div class="cs-video-overlay">
                            <div class="cs-play-btn">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            </div>
                            <p>Tap to watch full walkthrough</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- DESCRIPTION --}}
                @if(!empty($car->description))
                <div class="cs-card">
                    <div class="cs-card__head">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="17" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="17" y1="18" x2="3" y2="18"/></svg>
                        Description
                    </div>
                    <p class="cs-desc">{{ $car->description }}</p>
                </div>
                @endif

                {{-- PERFORMANCE & MECHANICAL --}}
                @if(!empty($car->drive) || !empty($car->gears) || !empty($car->torque) || !empty($car->cylinder_layout) || !empty($car->kilowatts) || !empty($car->aspiration) || !empty($car->acceleration) || !empty($car->fuel_consumption) || !empty($car->fuel_tank_capacity))
                <div class="cs-card">
                    <div class="cs-card__head">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        Performance & Mechanical
                    </div>
                    <div class="cs-details">
                        @if(!empty($car->drive))
                        <div class="cs-detail-row"><span>Drive</span><strong>{{ $car->drive }}</strong></div>
                        @endif
                        @if(!empty($car->gears))
                        <div class="cs-detail-row"><span>Gears</span><strong>{{ $car->gears }}</strong></div>
                        @endif
                        @if(!empty($car->torque))
                        <div class="cs-detail-row"><span>Torque</span><strong>{{ $car->torque }}</strong></div>
                        @endif
                        @if(!empty($car->kilowatts))
                        <div class="cs-detail-row"><span>Power Output</span><strong>{{ $car->kilowatts }} kW</strong></div>
                        @endif
                        @if(!empty($car->cylinder_layout))
                        <div class="cs-detail-row"><span>Cylinder Layout</span><strong>{{ $car->cylinder_layout }}</strong></div>
                        @endif
                        @if(!empty($car->aspiration))
                        <div class="cs-detail-row"><span>Aspiration</span><strong>{{ $car->aspiration }}</strong></div>
                        @endif
                        @if(!empty($car->acceleration))
                        <div class="cs-detail-row"><span>0–100 km/h</span><strong>{{ $car->acceleration }}</strong></div>
                        @endif
                        @if(!empty($car->fuel_consumption))
                        <div class="cs-detail-row"><span>Fuel Consumption</span><strong>{{ $car->fuel_consumption }}</strong></div>
                        @endif
                        @if(!empty($car->fuel_tank_capacity))
                        <div class="cs-detail-row"><span>Fuel Tank Capacity</span><strong>{{ $car->fuel_tank_capacity }}</strong></div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- RUNNING COSTS --}}
                @if($hasRunningCosts)
                <div class="cs-card">
                    <div class="cs-card__head">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                        Running Costs
                    </div>
                    <div class="cs-details">
                        @foreach($runningCosts as $costLabel => $costValue)
                            @if($costValue !== null && $costValue !== '')
                            <div class="cs-detail-row">
                                <span>{{ ucwords(str_replace(['_', 'And'], [' ', ' & '], $costLabel)) }}</span>
                                <strong>{{ $costValue }}</strong>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- FEATURES --}}
                @if(!empty($car->specification) && count(array_filter((array)$car->specification)))
                <div class="cs-card">
                    <div class="cs-card__head">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                        Features & Specifications
                    </div>
                    <div class="cs-features">
                        @foreach((array)$car->specification as $feature => $value)
                            @if($value)
                                <span class="cs-feature-tag">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    {{ ucwords(str_replace(['_', 'And'], [' ', ' & '], $feature)) }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="cs-right">

                {{-- Quick Stats --}}
                <div class="cs-stats">
                    @if(!empty($car->mileage))
                    <div class="cs-stat">
                        <div class="cs-stat__ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <div>
                            <span class="cs-stat__val">{{ number_format($car->mileage) }} km</span>
                            <span class="cs-stat__lbl">Mileage</span>
                        </div>
                    </div>
                    @endif
                    @if(!empty($car->engine_size))
                    <div class="cs-stat">
                        <div class="cs-stat__ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="10" rx="2"/><path d="M6 7V5a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                        </div>
                        <div>
                            <span class="cs-stat__val">{{ $car->engine_size }}cc</span>
                            <span class="cs-stat__lbl">Engine</span>
                        </div>
                    </div>
                    @endif
                    @if(!empty($car->fuel_type))
                    <div class="cs-stat">
                        <div class="cs-stat__ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 22V10l9-8 9 8v12H3z"/></svg>
                        </div>
                        <div>
                            <span class="cs-stat__val">{{ $car->fuel_type }}</span>
                            <span class="cs-stat__lbl">Fuel</span>
                        </div>
                    </div>
                    @endif
                    @if(!empty($car->fuel_consumption))
                    <div class="cs-stat">
                        <div class="cs-stat__ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 9V5a3 3 0 00-6 0v4"/><rect x="5" y="9" width="9" height="12" rx="1"/><path d="M14 12h3a2 2 0 012 2v5a2 2 0 002 2"/></svg>
                        </div>
                        <div>
                            <span class="cs-stat__val">{{ $car->fuel_consumption }}</span>
                            <span class="cs-stat__lbl">Fuel Consumption</span>
                        </div>
                    </div>
                    @endif
                    @if(!empty($car->transmission))
                    <div class="cs-stat">
                        <div class="cs-stat__ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="5" cy="6" r="2"/><circle cx="19" cy="6" r="2"/><circle cx="12" cy="18" r="2"/><line x1="5" y1="8" x2="5" y2="14"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="5" y1="14" x2="12" y2="16"/><line x1="19" y1="14" x2="12" y2="16"/></svg>
                        </div>
                        <div>
                            <span class="cs-stat__val">{{ $car->transmission }}</span>
                            <span class="cs-stat__lbl">Transmission</span>
                        </div>
                    </div>
                    @endif
                    @if(!empty($car->drive))
                    <div class="cs-stat">
                        <div class="cs-stat__ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12h16M4 12a4 4 0 014-4M4 12a4 4 0 004 4M20 12a4 4 0 00-4-4M20 12a4 4 0 01-4 4"/></svg>
                        </div>
                        <div>
                            <span class="cs-stat__val">{{ $car->drive }}</span>
                            <span class="cs-stat__lbl">Drive</span>
                        </div>
                    </div>
                    @endif
                    @if(!empty($car->horse_power))
                    <div class="cs-stat">
                        <div class="cs-stat__ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        </div>
                        <div>
                            <span class="cs-stat__val">{{ $car->horse_power }} hp</span>
                            <span class="cs-stat__lbl">Power</span>
                        </div>
                    </div>
                    @endif
                    @if(!empty($car->seats))
                    <div class="cs-stat">
                        <div class="cs-stat__ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 20v-6a2 2 0 012-2h12a2 2 0 012 2v6"/><path d="M6 12V6a2 2 0 012-2h8a2 2 0 012 2v6"/><line x1="4" y1="20" x2="4" y2="22"/><line x1="20" y1="20" x2="20" y2="22"/></svg>
                        </div>
                        <div>
                            <span class="cs-stat__val">{{ $car->seats }}</span>
                            <span class="cs-stat__lbl">Seats</span>
                        </div>
                    </div>
                    @endif
                    @if(!empty($car->doors))
                    <div class="cs-stat">
                        <div class="cs-stat__ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="1"/><line x1="12" y1="11" x2="12" y2="13"/></svg>
                        </div>
                        <div>
                            <span class="cs-stat__val">{{ $car->doors }}</span>
                            <span class="cs-stat__lbl">Doors</span>
                        </div>
                    </div>
                    @endif
                    @if(!empty($car->year))
                    <div class="cs-stat">
                        <div class="cs-stat__ico">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <span class="cs-stat__val">{{ $car->year }}</span>
                            <span class="cs-stat__lbl">Year</span>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Vehicle Details --}}
                <div class="cs-card">
                    <div class="cs-card__head">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Vehicle Details
                    </div>
                    <div class="cs-details">
                        @if(!empty($car->make))
                        <div class="cs-detail-row"><span>Make</span><strong>{{ $car->make }}</strong></div>
                        @endif
                        @if(!empty($car->model))
                        <div class="cs-detail-row"><span>Model</span><strong>{{ $car->model }}</strong></div>
                        @endif
                        @if(!empty($car->variant))
                        <div class="cs-detail-row"><span>Variant</span><strong>{{ $car->variant }}</strong></div>
                        @endif
                        <div class="cs-detail-row"><span>Type</span><strong>{{ $car->car_type ?? '—' }}</strong></div>
                        <div class="cs-detail-row"><span>Origin</span><strong>{{ ucfirst($car->origin ?? '—') }}</strong></div>
                        <div class="cs-detail-row">
                            <span>Status</span>
                            <strong class="cs-status {{ ($car->availability ?? '') === 'Available' ? 'cs-status--green' : 'cs-status--grey' }}">
                                <span class="cs-dot"></span>{{ $car->availability ?? '—' }}
                            </strong>
                        </div>
                        @if(!empty($car->year))
                        <div class="cs-detail-row"><span>Year</span><strong>{{ $car->year }}</strong></div>
                        @endif
                        @if(!empty($car->drive))
                        <div class="cs-detail-row"><span>Drive</span><strong>{{ $car->drive }}</strong></div>
                        @endif
                        @if(!empty($car->fuel_consumption))
                        <div class="cs-detail-row"><span>Fuel Consumption</span><strong>{{ $car->fuel_consumption }}</strong></div>
                        @endif
                        @if(!empty($car->location))
                        <div class="cs-detail-row"><span>Location</span><strong>{{ $car->location }}</strong></div>
                        @endif
                        @if(!empty($car->color))
                        <div class="cs-detail-row"><span>Colour</span><strong>{{ $car->color }}</strong></div>
                        @endif
                        @if(!empty($car->source))
                        <div class="cs-detail-row"><span>Source</span><strong>{{ $car->source }}</strong></div>
                        @endif
                    </div>
                </div>

                {{-- CTA Card (desktop) --}}
                <div class="cs-cta cs-desktop-cta">
                    <div class="cs-cta__price-row">
                        <span>Listed Price</span>
                        <strong>KSh {{ number_format($car->price ?? 0) }}</strong>
                    </div>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="cs-cta__btn cs-cta__btn--whatsapp">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Enquire on WhatsApp
                    </a>
                    @if($hasVideo)
                    <button class="cs-cta__btn cs-cta__btn--video" onclick="VM.open()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                        Watch Video Walkthrough
                    </button>
                    @endif
                    <a href="{{ url('/vehicles') }}" class="cs-cta__back">← Back to All Vehicles</a>
                </div>

            </div>
        </div>
    </div>

    {{-- FLOATING WHATSAPP BUTTON (mobile) --}}
    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="cs-wa-fab" aria-label="Enquire on WhatsApp">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        <span>Chat with us</span>
    </a>
</div>


{{-- LIGHTBOX MODAL --}}
<div id="lb-modal" class="lb-overlay" role="dialog" aria-modal="true" onclick="if(event.target===this)LB.close()">
    <button class="lb-close" onclick="LB.close()" aria-label="Close">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <button class="lb-arrow lb-arrow--prev" id="lbPrev" onclick="LB.nav(-1)" aria-label="Previous">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <div class="lb-stage">
        <img id="lb-img" src="" alt="Vehicle photo">
        <div class="lb-counter" id="lbCounter">1 / 1</div>
    </div>
    <button class="lb-arrow lb-arrow--next" id="lbNext" onclick="LB.nav(1)" aria-label="Next">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
    <div class="lb-thumbs" id="lbThumbs"></div>
</div>


{{-- VIDEO MODAL --}}
@if($hasVideo)
<div id="vm-modal" class="vm-overlay" role="dialog" aria-modal="true" onclick="if(event.target===this)VM.close()">
    <div class="vm-box">
        <div class="vm-header">
            <div class="vm-header__left">
                <span class="vm-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
                </span>
                <span>{{ $car->name ?? 'Vehicle' }} — Video Walkthrough</span>
            </div>
            <button class="vm-close" onclick="VM.close()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="vm-stage">
            <video id="vm-video" controls preload="metadata" playsinline>
                <source src="{{ $videoUrl }}" type="video/mp4">
                <source src="{{ $videoUrl }}" type="video/webm">
            </video>
        </div>
    </div>
</div>
@endif


<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Figtree:wght@300;400;500;600;700&display=swap');

:root {
    --red:       #C8281E;
    --red-h:     #a5201a;
    --red-lt:    rgba(200,40,30,.08);
    --wa:        #25D366;
    --wa-h:      #1da851;
    --ink:       #111418;
    --ink-md:    #52575e;
    --ink-lt:    #8a9099;
    --bone:      #f8f5f1;
    --white:     #ffffff;
    --border:    #e8e3dc;
    --border-lt: #f0ece6;
    --success:   #1a6b3a;
    --r:         14px;
    --r-sm:      8px;
    --sh-s:      0 1px 4px rgba(0,0,0,.06);
    --sh-m:      0 6px 24px rgba(0,0,0,.10);
    --sh-l:      0 20px 60px rgba(0,0,0,.18);
    --ease:      cubic-bezier(.4,0,.2,1);
    --tr:        all .2s var(--ease);
}

*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
html { -webkit-text-size-adjust:100%; max-width:100%; overflow-x:hidden; }
body { font-family:'Figtree',system-ui,sans-serif; background:var(--bone); color:var(--ink); max-width:100%; overflow-x:hidden; }
button { font-family:'Figtree',system-ui,sans-serif; cursor:pointer; }
a { text-decoration:none; color:inherit; }
img { max-width:100%; height:auto; display:block; }

/* ROOT */
.cs-root { min-height:100vh; padding-bottom:80px; width:100%; max-width:100%; overflow-x:hidden; }

/* HERO */
.cs-hero {
    background:var(--white);
    border-bottom:1px solid var(--border);
    padding:96px 0 28px;
    width:100%;
}
.cs-hero__inner { max-width:1200px; margin:0 auto; padding:0 20px; width:100%; }
.cs-back {
    display:inline-flex; align-items:center; gap:5px;
    font-size:13px; font-weight:500; color:var(--ink-lt);
    margin-bottom:22px; transition:var(--tr);
}
.cs-back:hover { color:var(--ink); }
.cs-hero__content {
    display:flex; justify-content:space-between;
    align-items:flex-end; gap:24px; flex-wrap:wrap;
}
.cs-hero__left { min-width:0; flex:1 1 260px; }
.cs-hero__tags { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:14px; }
.cs-tag {
    font-size:11px; font-weight:600; letter-spacing:.06em;
    text-transform:uppercase; padding:4px 11px; border-radius:100px;
    display:inline-flex; align-items:center; gap:5px; white-space:nowrap;
}
.cs-tag--green   { background:#ecfdf5; color:#065f46; }
.cs-tag--grey    { background:#f3f4f6; color:#374151; }
.cs-tag--outline { background:transparent; border:1.5px solid var(--border); color:var(--ink-md); }
.cs-tag--video   { background:#fdf4ff; color:#7e22ce; border:1.5px solid #e9d5ff; }
.cs-title {
    font-family:'Playfair Display',Georgia,serif;
    font-size:clamp(22px,3.5vw,44px); font-weight:700;
    line-height:1.12; margin-bottom:8px; color:var(--ink);
    word-wrap:break-word; overflow-wrap:break-word;
}
.cs-subtitle { font-size:14.5px; color:var(--ink-lt); font-weight:400; word-wrap:break-word; overflow-wrap:break-word; }
.cs-hero__right { text-align:right; flex-shrink:0; min-width:0; }
.cs-price-label { display:block; font-size:11px; font-weight:600; letter-spacing:.1em; text-transform:uppercase; color:var(--ink-lt); margin-bottom:4px; }
.cs-price { font-family:'Playfair Display',Georgia,serif; font-size:clamp(22px,3vw,38px); font-weight:700; color:var(--red); white-space:nowrap; }

/* BODY */
.cs-body { padding:32px 0 40px; width:100%; }
.cs-body__inner {
    max-width:1200px; margin:0 auto; padding:0 20px; width:100%;
    display:grid; grid-template-columns:1fr 360px; gap:28px; align-items:start;
}
.cs-left, .cs-right { min-width:0; }

/* GALLERY */
.cs-gallery { margin-bottom:24px; width:100%; }
.cs-gallery__main {
    position:relative; width:100%; aspect-ratio:16/10;
    border-radius:var(--r); overflow:hidden; background:#111;
    box-shadow:var(--sh-m); margin-bottom:12px; cursor:zoom-in;
}
.cs-gallery__main img { width:100%; height:100%; object-fit:cover; transition:transform .45s var(--ease); }
.cs-gallery__main:hover img { transform:scale(1.03); }
.cs-gallery__expand {
    position:absolute; top:14px; right:14px;
    background:rgba(0,0,0,.55); backdrop-filter:blur(8px);
    border:1px solid rgba(255,255,255,.15); border-radius:8px;
    color:#fff; font-size:12px; font-weight:600;
    padding:7px 13px; display:flex; align-items:center; gap:6px;
    transition:var(--tr); z-index:5;
}
.cs-gallery__expand:hover { background:rgba(0,0,0,.75); }
.cs-gallery__arrow {
    position:absolute; top:50%; transform:translateY(-50%);
    width:42px; height:42px; background:rgba(255,255,255,.92);
    border:none; border-radius:50%; display:flex;
    align-items:center; justify-content:center;
    color:var(--ink); box-shadow:var(--sh-m); transition:var(--tr);
    z-index:5; opacity:0;
}
.cs-gallery__main:hover .cs-gallery__arrow { opacity:1; }
.cs-gallery__arrow--prev { left:14px; }
.cs-gallery__arrow--next { right:14px; }
.cs-gallery__arrow:hover { background:var(--white); transform:translateY(-50%) scale(1.08); }
.cs-gallery__count {
    position:absolute; bottom:14px; left:14px;
    background:rgba(0,0,0,.55); backdrop-filter:blur(8px);
    color:#fff; font-size:12px; font-weight:500;
    padding:6px 12px; border-radius:100px;
    display:flex; align-items:center; gap:6px;
}
.cs-gallery__thumbs {
    display:flex; gap:9px; overflow-x:auto; max-width:100%;
    padding-bottom:4px; scrollbar-width:thin;
    scrollbar-color:var(--border) transparent;
}
.cs-thumb {
    flex-shrink:0; width:88px; height:60px;
    border-radius:8px; overflow:hidden;
    border:2.5px solid transparent; background:none;
    padding:0; opacity:.6; transition:var(--tr); cursor:pointer;
}
.cs-thumb img { width:100%; height:100%; object-fit:cover; }
.cs-thumb:hover { opacity:.85; }
.cs-thumb.active { border-color:var(--red); opacity:1; }

/* MOBILE CTA */
.cs-mobile-cta {
    display:none;
    background:var(--white); border:1px solid var(--border);
    border-radius:var(--r); padding:18px;
    box-shadow:var(--sh-s); margin-bottom:24px;
    width:100%;
}

/* VIDEO SECTION */
.cs-video-section {
    background:var(--white); border:1px solid var(--border);
    border-radius:var(--r); overflow:hidden;
    margin-bottom:24px; box-shadow:var(--sh-s);
    width:100%;
}
.cs-video-header {
    display:flex; align-items:center; gap:8px; flex-wrap:wrap;
    padding:14px 18px; font-size:13px; font-weight:600;
    color:var(--ink); border-bottom:1px solid var(--border);
    background:var(--bone); text-transform:uppercase; letter-spacing:.05em;
}
.cs-video-header svg { color:var(--red); flex-shrink:0; }
.cs-video-modal-btn {
    margin-left:auto; display:inline-flex; align-items:center; gap:5px;
    font-size:12px; font-weight:600; color:var(--red);
    background:var(--red-lt); border:1.5px solid rgba(200,40,30,.18);
    border-radius:6px; padding:5px 11px; transition:var(--tr);
    text-transform:none; letter-spacing:0; white-space:nowrap;
}
.cs-video-modal-btn:hover { background:rgba(200,40,30,.15); }
.cs-video-preview { position:relative; cursor:pointer; background:#000; aspect-ratio:16/9; width:100%; }
.cs-video-preview video { width:100%; height:100%; object-fit:cover; display:block; opacity:.55; }
.cs-video-overlay {
    position:absolute; inset:0; display:flex;
    flex-direction:column; align-items:center;
    justify-content:center; gap:14px; transition:var(--tr);
    padding:0 16px; text-align:center;
}
.cs-video-preview:hover .cs-video-overlay { background:rgba(0,0,0,.2); }
.cs-play-btn {
    width:72px; height:72px; background:var(--red);
    border-radius:50%; display:flex; align-items:center;
    justify-content:center; color:#fff;
    box-shadow:0 8px 28px rgba(200,40,30,.45); transition:var(--tr);
    flex-shrink:0;
}
.cs-play-btn svg { margin-left:4px; }
.cs-video-preview:hover .cs-play-btn { transform:scale(1.08); }
.cs-video-overlay p { color:rgba(255,255,255,.8); font-size:13px; font-weight:500; }

/* CARD */
.cs-card {
    background:var(--white); border:1px solid var(--border);
    border-radius:var(--r); overflow:hidden;
    margin-bottom:20px; box-shadow:var(--sh-s);
    width:100%;
}
.cs-card__head {
    display:flex; align-items:center; gap:8px;
    padding:14px 18px; font-size:11.5px; font-weight:700;
    letter-spacing:.07em; text-transform:uppercase;
    color:var(--ink); border-bottom:1px solid var(--border);
    background:var(--bone); flex-wrap:wrap;
}
.cs-card__head svg { color:var(--red); flex-shrink:0; }
.cs-desc { padding:18px; font-size:14.5px; line-height:1.8; color:#374151; word-wrap:break-word; overflow-wrap:break-word; }
.cs-features { display:flex; flex-wrap:wrap; gap:8px; padding:16px 18px; }
.cs-feature-tag {
    display:inline-flex; align-items:center; gap:5px;
    background:var(--bone); border:1px solid var(--border);
    color:#374151; font-size:12.5px; font-weight:500;
    padding:5px 12px; border-radius:100px; transition:var(--tr);
    max-width:100%; word-break:break-word;
}
.cs-feature-tag svg { color:#10b981; flex-shrink:0; }
.cs-feature-tag:hover { background:var(--red-lt); border-color:rgba(200,40,30,.25); color:var(--red); }

/* STATS */
.cs-stats { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:18px; width:100%; }
.cs-stat {
    background:var(--white); border:1px solid var(--border);
    border-radius:var(--r-sm); padding:14px;
    display:flex; align-items:center; gap:12px;
    box-shadow:var(--sh-s); transition:var(--tr);
    min-width:0;
}
.cs-stat:hover { box-shadow:var(--sh-m); transform:translateY(-1px); }
.cs-stat__ico {
    width:38px; height:38px; background:var(--red-lt);
    border-radius:10px; display:flex; align-items:center;
    justify-content:center; flex-shrink:0; color:var(--red);
}
.cs-stat > div { min-width:0; flex:1; }
.cs-stat__val { display:block; font-size:14px; font-weight:700; color:var(--ink); line-height:1.2; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.cs-stat__lbl { display:block; font-size:11px; color:var(--ink-lt); text-transform:uppercase; letter-spacing:.05em; font-weight:500; margin-top:2px; }

/* DETAILS */
.cs-details { padding:4px 0; }
.cs-detail-row {
    display:flex; justify-content:space-between; align-items:center;
    gap:12px; padding:12px 18px; border-bottom:1px solid var(--border-lt); font-size:13.5px;
    flex-wrap:wrap;
}
.cs-detail-row:last-child { border-bottom:none; }
.cs-detail-row span { color:var(--ink-md); font-weight:400; min-width:0; }
.cs-detail-row strong { font-weight:600; color:var(--ink); text-align:right; min-width:0; word-break:break-word; overflow-wrap:break-word; }
.cs-status { display:flex; align-items:center; gap:6px; }
.cs-dot { width:8px; height:8px; border-radius:50%; background:currentColor; flex-shrink:0; }
.cs-status--green { color:var(--success); }
.cs-status--grey  { color:var(--ink-lt); }

/* CTA */
.cs-cta {
    background:var(--white); border:1px solid var(--border);
    border-radius:var(--r); padding:22px;
    box-shadow:var(--sh-m); position:sticky; top:24px;
    width:100%;
}
.cs-cta__price-row {
    display:flex; justify-content:space-between; align-items:center;
    padding-bottom:16px; margin-bottom:16px;
    border-bottom:1px solid var(--border);
    font-size:13px; color:var(--ink-md); gap:10px; flex-wrap:wrap;
}
.cs-cta__price-row strong {
    font-family:'Playfair Display',Georgia,serif;
    font-size:22px; font-weight:700; color:var(--ink);
}
.cs-cta__btn {
    width:100%; display:flex; align-items:center; justify-content:center;
    gap:8px; border:none; border-radius:10px; padding:14px;
    font-size:14px; font-weight:700; letter-spacing:.02em;
    margin-bottom:10px; transition:var(--tr); cursor:pointer;
    text-decoration:none; text-align:center;
}
.cs-cta__btn--whatsapp { background:var(--wa); color:#fff; }
.cs-cta__btn--whatsapp:hover { background:var(--wa-h); transform:translateY(-1px); box-shadow:0 6px 20px rgba(37,211,102,.35); }
.cs-cta__btn--video { background:var(--bone); color:var(--ink); border:1.5px solid var(--border); }
.cs-cta__btn--video:hover { background:var(--border); transform:translateY(-1px); }
.cs-cta__back {
    display:block; text-align:center; color:var(--ink-lt);
    font-size:13px; font-weight:500; padding:10px;
    border-radius:8px; transition:var(--tr);
}
.cs-cta__back:hover { background:var(--bone); color:var(--ink); }

/* FLOATING WHATSAPP FAB */
.cs-wa-fab {
    display:none;
    position:fixed; bottom:20px; left:50%; transform:translateX(-50%);
    background:var(--wa); color:#fff;
    border-radius:100px; padding:14px 24px;
    font-size:15px; font-weight:700;
    align-items:center; gap:10px;
    box-shadow:0 6px 28px rgba(37,211,102,.45);
    z-index:999; transition:var(--tr);
    text-decoration:none; white-space:nowrap;
    max-width:calc(100vw - 32px);
}
.cs-wa-fab:hover { background:var(--wa-h); transform:translateX(-50%) translateY(-2px); box-shadow:0 10px 36px rgba(37,211,102,.5); }

/* LIGHTBOX */
.lb-overlay {
    display:none; position:fixed; inset:0;
    background:rgba(5,4,3,.94); backdrop-filter:blur(12px);
    z-index:9998; flex-direction:column;
    align-items:center; justify-content:center; padding:20px;
}
.lb-overlay.open { display:flex; }
.lb-close {
    position:absolute; top:18px; right:18px;
    width:42px; height:42px; background:rgba(255,255,255,.1);
    border:1px solid rgba(255,255,255,.15); border-radius:10px;
    color:#fff; display:flex; align-items:center;
    justify-content:center; z-index:10; transition:var(--tr);
}
.lb-close:hover { background:rgba(255,255,255,.2); }
.lb-arrow {
    position:absolute; top:50%; transform:translateY(-50%);
    width:50px; height:50px; background:rgba(255,255,255,.1);
    border:1px solid rgba(255,255,255,.2); border-radius:50%;
    color:#fff; display:flex; align-items:center;
    justify-content:center; z-index:10; transition:var(--tr); margin-top:-40px;
}
.lb-arrow:hover { background:rgba(255,255,255,.2); transform:translateY(-50%) scale(1.08); }
.lb-arrow--prev { left:20px; }
.lb-arrow--next { right:20px; }
.lb-stage {
    position:relative; max-width:90vw; max-height:75vh;
    display:flex; align-items:center; justify-content:center;
}
#lb-img {
    max-width:90vw; max-height:75vh; object-fit:contain;
    border-radius:10px; box-shadow:var(--sh-l);
    animation:lb-in .25s var(--ease);
}
@keyframes lb-in { from{opacity:0;transform:scale(.96)} to{opacity:1;transform:scale(1)} }
.lb-counter {
    position:absolute; bottom:-38px; left:50%; transform:translateX(-50%);
    color:rgba(255,255,255,.55); font-size:13px; font-weight:500; white-space:nowrap;
}
.lb-thumbs {
    position:absolute; bottom:20px; left:50%; transform:translateX(-50%);
    display:flex; gap:8px; max-width:80vw; overflow-x:auto;
    padding:4px; scrollbar-width:none;
}
.lb-thumbs::-webkit-scrollbar { display:none; }
.lb-thumb-item {
    flex-shrink:0; width:64px; height:44px; border-radius:6px;
    overflow:hidden; border:2px solid transparent; cursor:pointer;
    opacity:.5; transition:var(--tr);
}
.lb-thumb-item img { width:100%; height:100%; object-fit:cover; }
.lb-thumb-item:hover { opacity:.8; }
.lb-thumb-item.active { border-color:#fff; opacity:1; }

/* VIDEO MODAL */
.vm-overlay {
    display:none; position:fixed; inset:0;
    background:rgba(0,0,0,.88); backdrop-filter:blur(10px);
    z-index:9999; align-items:center; justify-content:center; padding:20px;
}
.vm-overlay.open { display:flex; }
.vm-box {
    background:#0a0a0a; border-radius:16px; width:100%; max-width:960px;
    box-shadow:var(--sh-l), 0 0 0 1px rgba(255,255,255,.06);
    overflow:hidden; animation:vm-in .3s cubic-bezier(.34,1.56,.64,1);
}
@keyframes vm-in { from{opacity:0;transform:scale(.94) translateY(20px)} to{opacity:1;transform:scale(1) translateY(0)} }
.vm-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:14px 18px; border-bottom:1px solid rgba(255,255,255,.07);
    gap:10px; flex-wrap:wrap;
}
.vm-header__left {
    display:flex; align-items:center; gap:10px;
    font-size:13.5px; font-weight:600; color:rgba(255,255,255,.8);
    min-width:0;
}
.vm-header__left span:last-child { overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.vm-icon {
    width:30px; height:30px; background:var(--red); border-radius:7px;
    display:flex; align-items:center; justify-content:center;
    color:#fff; flex-shrink:0;
}
.vm-close {
    width:36px; height:36px; background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.12); border-radius:8px;
    color:rgba(255,255,255,.6); display:flex; align-items:center;
    justify-content:center; transition:var(--tr); flex-shrink:0;
}
.vm-close:hover { background:rgba(200,40,30,.3); color:#fff; border-color:var(--red); }
.vm-stage { background:#000; line-height:0; }
.vm-stage video { width:100%; max-height:65vh; display:block; }

/* RESPONSIVE */
@media(max-width:1100px) {
    .cs-body__inner { grid-template-columns:1fr 320px; gap:20px; }
}
@media(max-width:900px) {
    .cs-body__inner { grid-template-columns:1fr; }
    .cs-right { order:2; }
    .cs-desktop-cta { display:none; }
    .cs-mobile-cta { display:block; }
    .cs-wa-fab { display:flex; }
    .cs-root { padding-bottom:100px; }
    .cs-stats { grid-template-columns:repeat(3,1fr); }
    .cs-gallery__main { aspect-ratio:4/3; }
    .cs-cta { position:static; }
}
@media(max-width:600px) {
    .cs-hero { padding:80px 0 22px; }
    .cs-hero__inner { padding:0 16px; }
    .cs-hero__content { flex-direction:column; align-items:flex-start; }
    .cs-hero__right { text-align:left; }
    .cs-body__inner { padding:0 16px; }
    .cs-stats { grid-template-columns:1fr 1fr; }
    .lb-arrow { width:38px; height:38px; }
    .lb-arrow--prev { left:8px; }
    .lb-arrow--next { right:8px; }
    .cs-gallery__arrow { opacity:1; width:36px; height:36px; }
    .cs-thumb { width:72px; height:50px; }
    .cs-wa-fab { bottom:16px; font-size:14px; padding:12px 20px; }
    .cs-detail-row { flex-wrap:wrap; }
    .cs-detail-row strong { text-align:left; }
}
@media(max-width:400px) {
    .cs-stats { grid-template-columns:1fr; }
    .cs-body__inner { padding:0 14px; }
    .cs-hero__inner { padding:0 14px; }
    .cs-card__head { padding:12px 14px; }
    .cs-desc { padding:14px; }
    .cs-features { padding:12px 14px; }
    .cs-details { padding:2px 0; }
    .cs-detail-row { padding:10px 14px; }
    .cs-mobile-cta { padding:14px; }
    .cs-wa-fab span { display:none; }
    .cs-wa-fab { border-radius:50%; width:52px; height:52px; padding:0; justify-content:center; }
}
</style>


<script>
const IMAGES = @json(array_map(fn($img) => asset('storage/' . ltrim($img, '/')), $images));
let currentIndex = 0;

const LB = (() => {
    const overlay = document.getElementById('lb-modal');
    const img     = document.getElementById('lb-img');
    const counter = document.getElementById('lbCounter');
    const thumbs  = document.getElementById('lbThumbs');
    const prevBtn = document.getElementById('lbPrev');
    const nextBtn = document.getElementById('lbNext');

    function buildThumbs() {
        thumbs.innerHTML = '';
        IMAGES.forEach((src, i) => {
            const btn = document.createElement('button');
            btn.className = 'lb-thumb-item' + (i === 0 ? ' active' : '');
            btn.style.cssText = 'background:none;border:none;padding:0;';
            btn.innerHTML = `<img src="${src}" alt="Photo ${i+1}">`;
            btn.onclick = () => go(i);
            thumbs.appendChild(btn);
        });
    }

    function go(index) {
        currentIndex = ((index % IMAGES.length) + IMAGES.length) % IMAGES.length;
        img.style.opacity = '0';
        img.style.transition = 'opacity .12s ease';
        setTimeout(() => { img.src = IMAGES[currentIndex]; img.style.opacity = '1'; }, 120);
        counter.textContent = `${currentIndex + 1} / ${IMAGES.length}`;
        thumbs.querySelectorAll('.lb-thumb-item').forEach((t,i) => t.classList.toggle('active', i === currentIndex));
        prevBtn.style.display = IMAGES.length > 1 ? '' : 'none';
        nextBtn.style.display = IMAGES.length > 1 ? '' : 'none';
    }

    function open(index) {
        buildThumbs(); go(index ?? currentIndex);
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function close() { overlay.classList.remove('open'); document.body.style.overflow = ''; }
    function nav(dir) { go(currentIndex + dir); }

    function galleryNav(dir) {
        const next = ((currentIndex + dir) % IMAGES.length + IMAGES.length) % IMAGES.length;
        setMain(next);
    }

    function setMain(index) {
        currentIndex = index;
        document.getElementById('mainImg').src = IMAGES[index];
        document.getElementById('photoCounter').textContent = index + 1;
        document.querySelectorAll('.cs-thumb').forEach((t,i) => t.classList.toggle('active', i === index));
    }

    document.addEventListener('keydown', e => {
        if (!overlay.classList.contains('open')) return;
        if (e.key === 'ArrowLeft')  nav(-1);
        if (e.key === 'ArrowRight') nav(1);
        if (e.key === 'Escape')     close();
    });

    document.getElementById('galleryMain')?.addEventListener('click', e => {
        if (!e.target.closest('.cs-gallery__expand') && !e.target.closest('.cs-gallery__arrow')) {
            open(currentIndex);
        }
    });

    return { open, close, nav, galleryNav, setMain };
})();

const VM = (() => {
    const overlay = document.getElementById('vm-modal');
    const video   = document.getElementById('vm-video');

    function open() {
        if (!overlay) return;
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
        video?.play().catch(() => {});
    }

    function close() {
        if (!overlay) return;
        video?.pause();
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && overlay?.classList.contains('open')) close();
    });

    return { open, close };
})();
</script>

@endsection
