@extends('layouts.app')

@section('content')
<div class="vehicles-page">

    <!-- Hero Search Section -->
    <div class="hero-search">
        <div class="container-wrapper">
            <div class="hero-content">
                <p class="hero-eyebrow">
                    <span class="eyebrow-dot"></span>
                    {{ $cars->count() }} VEHICLES AVAILABLE
                </p>
                <h1 class="hero-title">Find your <em>perfect</em> car.</h1>
                <p class="hero-subtitle">Browse quality vehicles from trusted dealers across Kenya.</p>
            </div>

            <!-- Search Bar -->
            <div class="search-box-container">
                <div class="search-box">
                    <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" id="main-search" placeholder="Search by make, model, or keyword..." oninput="filterVehicles()">
                </div>

                <!-- Currency Selector inline -->
                <div class="currency-selector">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="2" y1="12" x2="22" y2="12"/>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                    <select id="currency-select" class="currency-dropdown" onchange="updateCurrency()">
                        <option value="KES" data-rate="1" data-symbol="KSh">KES</option>
                        <option value="USD" data-rate="0.0077" data-symbol="$">USD</option>
                        <option value="GBP" data-rate="0.0061" data-symbol="£">GBP</option>
                        <option value="EUR" data-rate="0.0071" data-symbol="€">EUR</option>
                        <option value="ZAR" data-rate="0.14" data-symbol="R">ZAR</option>
                        <option value="AED" data-rate="0.028" data-symbol="AED">AED</option>
                    </select>
                </div>
            </div>

            <!-- Quick Filters -->
            <div class="quick-filters-section">
                <button class="quick-filter-btn active" data-filter="all" onclick="quickFilter('all')">All Vehicles</button>
                <button class="quick-filter-btn" data-filter="local" onclick="quickFilter('local')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    In Kenya
                </button>
                <button class="quick-filter-btn" data-filter="imports" onclick="quickFilter('imports')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                    Imports
                </button>
                <button class="quick-filter-btn" data-filter="verified" onclick="quickFilter('verified')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Verified
                </button>

                <!-- Advanced Filters Toggle -->
                <button class="advanced-toggle-btn" onclick="toggleAdvancedFilters()" id="advanced-toggle">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/>
                        <line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/>
                        <line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/>
                        <line x1="17" y1="16" x2="23" y2="16"/>
                    </svg>
                    <span class="toggle-text">Filters</span>
                    <svg class="chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
            </div>

            <!-- Advanced Filters Panel -->
            <div class="advanced-filters" id="advanced-filters">
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">Make</label>
                        <select id="make-filter" class="filter-select" onchange="filterVehicles()">
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
                    <div class="filter-group">
                        <label class="filter-label">Body Type</label>
                        <select id="body-type-filter" class="filter-select" onchange="filterVehicles()">
                            <option value="">All Types</option>
                            <option value="suv">SUV</option>
                            <option value="sedan">Sedan</option>
                            <option value="hatchback">Hatchback</option>
                            <option value="pickup">Pickup</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Min Price</label>
                        <select id="price-min" class="filter-select" onchange="filterVehicles()">
                            <option value="0">No Min</option>
                            <option value="500000">KSh 500K</option>
                            <option value="1000000">KSh 1M</option>
                            <option value="2000000">KSh 2M</option>
                            <option value="3000000">KSh 3M</option>
                            <option value="5000000">KSh 5M</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Max Price</label>
                        <select id="price-max" class="filter-select" onchange="filterVehicles()">
                            <option value="20000000">No Max</option>
                            <option value="1000000">KSh 1M</option>
                            <option value="2000000">KSh 2M</option>
                            <option value="3000000">KSh 3M</option>
                            <option value="5000000">KSh 5M</option>
                            <option value="10000000">KSh 10M</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Year From</label>
                        <select id="year-from" class="filter-select" onchange="filterVehicles()">
                            <option value="">Any Year</option>
                            @for($y = 2024; $y >= 2000; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Year To</label>
                        <select id="year-to" class="filter-select" onchange="filterVehicles()">
                            <option value="">Any Year</option>
                            @for($y = 2024; $y >= 2000; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Transmission</label>
                        <select id="transmission-filter" class="filter-select" onchange="filterVehicles()">
                            <option value="">All</option>
                            <option value="automatic">Automatic</option>
                            <option value="manual">Manual</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Fuel Type</label>
                        <select id="fuel-filter" class="filter-select" onchange="filterVehicles()">
                            <option value="">All</option>
                            <option value="petrol">Petrol</option>
                            <option value="diesel">Diesel</option>
                            <option value="hybrid">Hybrid</option>
                            <option value="electric">Electric</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Min Mileage (km)</label>
                        <input type="number" id="mileage-from" class="filter-select" placeholder="e.g. 0" onchange="filterVehicles()">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Max Mileage (km)</label>
                        <input type="number" id="mileage-to" class="filter-select" placeholder="e.g. 150,000" onchange="filterVehicles()">
                    </div>
                    <div class="filter-group filter-actions-group">
                        <button class="clear-btn" onclick="clearAllFilters()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            Clear All
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="container-wrapper results-section">
        <!-- Toolbar -->
        <div class="results-toolbar">
            <div class="results-info">
                <span class="count" id="results-count">{{ $cars->count() }}</span>
                <span class="label">vehicles found</span>
            </div>
            <div class="toolbar-right">
                <div class="sort-wrapper">
                    <label>Sort by</label>
                    <select id="sort-select" class="toolbar-select" onchange="sortVehicles()">
                        <option value="featured">Featured</option>
                        <option value="price-low">Price: Low → High</option>
                        <option value="price-high">Price: High → Low</option>
                        <option value="year-new">Newest First</option>
                        <option value="year-old">Oldest First</option>
                        <option value="mileage-low">Lowest Mileage</option>
                    </select>
                </div>
                <div class="view-toggle">
                    <button class="view-btn active" data-view="grid" onclick="switchView('grid')" title="Grid View">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    </button>
                    <button class="view-btn" data-view="list" onclick="switchView('list')" title="List View">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><rect x="3" y="4" width="2" height="4"/><rect x="3" y="10" width="2" height="4"/><rect x="3" y="16" width="2" height="4"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Grid -->
        <div class="vehicles-grid" id="vehicles-container">
            @forelse($cars as $car)
                @php
                    $images = $car->images ? (is_string($car->images) ? json_decode($car->images, true) : (array)$car->images) : [];
                    $mainImage = count($images) ? asset('storage/' . $images[0]) : 'https://via.placeholder.com/400x300?text=No+Image';
                @endphp

                <article class="vehicle-card"
                     data-make="{{ strtolower($car->make ?? 'toyota') }}"
                     data-year="{{ $car->year ?? 2014 }}"
                     data-price="{{ $car->price ?? 2500000 }}"
                     data-mileage="{{ $car->mileage ?? 85000 }}"
                     data-category="{{ $car->category ?? 'local' }}"
                     data-body-type="{{ strtolower($car->body_type ?? 'suv') }}"
                     data-transmission="{{ strtolower($car->transmission_type ?? 'automatic') }}"
                     data-fuel="{{ strtolower($car->fuel_type ?? 'petrol') }}"
                     data-verified="{{ $car->user && $car->user->is_verified ? 'true' : 'false' }}"
                     data-name="{{ strtolower($car->name ?? 'toyota fortuner') }}">

                    <div class="card-image-wrapper">
                        <a href="{{ route('vehicles.show', $car->id ?? 1) }}" class="image-link">
                            <img src="{{ $mainImage }}" alt="{{ $car->name ?? 'Vehicle' }}" loading="lazy">
                        </a>

                        <button class="wishlist-icon" onclick="toggleWishlist(event, this)" aria-label="Add to wishlist">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>

                        <div class="card-badges">
                            @if($car->user && $car->user->is_verified)
                                <span class="badge verified">
                                    <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                    Verified
                                </span>
                            @endif
                            @if($car->featured ?? false)
                                <span class="badge featured">Featured</span>
                            @endif
                        </div>

                        @if(count($images) > 1)
                            <div class="image-counter">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                {{ count($images) }}
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="card-header">
                            <div>
                                <h3 class="vehicle-title">
                                    <a href="{{ route('vehicles.show', $car->id ?? 1) }}">{{ $car->name ?? 'Toyota Fortuner' }}</a>
                                </h3>
                                <span class="vehicle-year">{{ $car->year ?? 2014 }}</span>
                            </div>
                            <div class="vehicle-price" data-original-price="{{ $car->price ?? 2500000 }}">
                                KSh {{ number_format($car->price ?? 2500000) }}
                            </div>
                        </div>

                        <div class="vehicle-specs">
                            <span class="spec">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ number_format($car->mileage ?? 85000) }} km
                            </span>
                            <span class="spec-dot"></span>
                            <span class="spec">{{ $car->transmission_type ?? 'Auto' }}</span>
                            <span class="spec-dot"></span>
                            <span class="spec">{{ $car->fuel_type ?? 'Petrol' }}</span>
                        </div>

                        <div class="card-footer">
                            <div class="location-info">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $car->location ?? 'Nairobi' }}
                            </div>
                            <a href="{{ route('vehicles.show', $car->id ?? 1) }}" class="view-details">
                                View details →
                            </a>
                        </div>

                        @if($car->report)
                        <div class="report-section">
                            @auth
                                @php
                                    $userPayment = \App\Models\ReportPayment::where('car_id', $car->id)
                                        ->where('user_id', auth()->id())
                                        ->latest()->first();
                                @endphp

                                @if($userPayment && $userPayment->status === 'verified')
                                    <a href="{{ route('vehicles.report', $car->id) }}" class="report-btn report-verified">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        View Report
                                    </a>
                                @elseif($userPayment && $userPayment->status === 'pending')
                                    <button class="report-btn report-pending"
                                        onclick="openPaymentModal(event, {{ $car->id }}, {{ $car->report_price ?? 0 }}, '{{ addslashes($car->name) }}')">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        Pending Verification
                                    </button>
                                @else
                                    <button class="report-btn"
                                        onclick="openPaymentModal(event, {{ $car->id }}, {{ $car->report_price ?? 0 }}, '{{ addslashes($car->name) }}')">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                        @if($car->report_price)Buy Report · KSh {{ number_format($car->report_price) }}@else Buy Report @endif
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('sell') }}?redirect={{ urlencode(request()->url()) }}" class="report-btn">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    @if($car->report_price)Buy Report · KSh {{ number_format($car->report_price) }}@else Buy Report @endif
                                </a>
                            @endauth
                        </div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="no-results-state">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    <h3>No vehicles found</h3>
                    <p>Try adjusting your search or filters</p>
                    <button class="btn-primary" onclick="clearAllFilters()">Clear Filters</button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <nav class="pagination-wrapper" aria-label="Pagination">
            <button class="page-nav" aria-label="Previous page" disabled>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="page-num active">1</button>
            <button class="page-num">2</button>
            <button class="page-num">3</button>
            <span class="page-ellipsis">…</span>
            <button class="page-num">10</button>
            <button class="page-nav" aria-label="Next page">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </nav>
    </div>
</div>

<script>
let currentCurrency = 'KES';
let currentRate = 1;
let currentSymbol = 'KSh';
let currentQuickFilter = 'all';
let filtersExpanded = false;

function toggleAdvancedFilters() {
    filtersExpanded = !filtersExpanded;
    const panel = document.getElementById('advanced-filters');
    const btn = document.getElementById('advanced-toggle');
    const chevron = btn.querySelector('.chevron');
    const text = btn.querySelector('.toggle-text');

    if (filtersExpanded) {
        panel.style.maxHeight = panel.scrollHeight + 'px';
        panel.classList.add('expanded');
        chevron.style.transform = 'rotate(180deg)';
        text.textContent = 'Hide Filters';
        btn.classList.add('active');
    } else {
        panel.style.maxHeight = '0';
        panel.classList.remove('expanded');
        chevron.style.transform = 'rotate(0deg)';
        text.textContent = 'Filters';
        btn.classList.remove('active');
    }
}

function updateCurrency() {
    const select = document.getElementById('currency-select');
    const option = select.options[select.selectedIndex];
    currentCurrency = option.value;
    currentRate = parseFloat(option.dataset.rate);
    currentSymbol = option.dataset.symbol;
    document.querySelectorAll('.vehicle-price').forEach(el => {
        const orig = parseFloat(el.dataset.originalPrice);
        el.textContent = formatPrice(orig * currentRate);
    });
}

function formatPrice(amount) {
    if (['KES', 'UGX', 'TZS'].includes(currentCurrency)) {
        return `${currentSymbol} ${Math.round(amount).toLocaleString()}`;
    }
    return `${currentSymbol}${Math.round(amount).toLocaleString()}`;
}

function quickFilter(type) {
    currentQuickFilter = type;
    document.querySelectorAll('.quick-filter-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.filter === type);
    });
    filterVehicles();
}

function filterVehicles() {
    const searchTerm = document.getElementById('main-search').value.toLowerCase();
    const selectedMake = document.getElementById('make-filter').value.toLowerCase();
    const selectedBodyType = document.getElementById('body-type-filter').value.toLowerCase();
    const selectedTransmission = document.getElementById('transmission-filter').value.toLowerCase();
    const selectedFuel = document.getElementById('fuel-filter').value.toLowerCase();
    const yearFrom = document.getElementById('year-from').value;
    const yearTo = document.getElementById('year-to').value;
    const minPrice = parseInt(document.getElementById('price-min').value);
    const maxPrice = parseInt(document.getElementById('price-max').value);
    const mileageFrom = document.getElementById('mileage-from').value;
    const mileageTo = document.getElementById('mileage-to').value;

    let visibleCount = 0;
    document.querySelectorAll('.vehicle-card').forEach(card => {
        let matches = true;

        if (currentQuickFilter !== 'all') {
            if (currentQuickFilter === 'local' && card.dataset.category !== 'local') matches = false;
            if (currentQuickFilter === 'imports' && card.dataset.category !== 'imports') matches = false;
            if (currentQuickFilter === 'verified' && card.dataset.verified !== 'true') matches = false;
        }
        if (searchTerm && !card.dataset.name.includes(searchTerm)) matches = false;
        if (selectedMake && card.dataset.make !== selectedMake) matches = false;
        if (selectedBodyType && card.dataset.bodyType !== selectedBodyType) matches = false;
        if (selectedTransmission && card.dataset.transmission !== selectedTransmission) matches = false;
        if (selectedFuel && card.dataset.fuel !== selectedFuel) matches = false;
        if (yearFrom && parseInt(card.dataset.year) < parseInt(yearFrom)) matches = false;
        if (yearTo && parseInt(card.dataset.year) > parseInt(yearTo)) matches = false;
        if (parseInt(card.dataset.price) < minPrice || parseInt(card.dataset.price) > maxPrice) matches = false;
        if (mileageFrom && parseInt(card.dataset.mileage) < parseInt(mileageFrom)) matches = false;
        if (mileageTo && parseInt(card.dataset.mileage) > parseInt(mileageTo)) matches = false;

        card.style.display = matches ? '' : 'none';
        if (matches) visibleCount++;
    });
    document.getElementById('results-count').textContent = visibleCount;
}

function sortVehicles() {
    const sortValue = document.getElementById('sort-select').value;
    const container = document.getElementById('vehicles-container');
    const cards = Array.from(document.querySelectorAll('.vehicle-card'));
    cards.sort((a, b) => {
        switch(sortValue) {
            case 'price-low': return parseInt(a.dataset.price) - parseInt(b.dataset.price);
            case 'price-high': return parseInt(b.dataset.price) - parseInt(a.dataset.price);
            case 'year-new': return parseInt(b.dataset.year) - parseInt(a.dataset.year);
            case 'year-old': return parseInt(a.dataset.year) - parseInt(b.dataset.year);
            case 'mileage-low': return parseInt(a.dataset.mileage) - parseInt(b.dataset.mileage);
            default: return 0;
        }
    });
    cards.forEach(card => container.appendChild(card));
}

function clearAllFilters() {
    document.getElementById('main-search').value = '';
    document.getElementById('make-filter').value = '';
    document.getElementById('body-type-filter').value = '';
    document.getElementById('transmission-filter').value = '';
    document.getElementById('fuel-filter').value = '';
    document.getElementById('year-from').value = '';
    document.getElementById('year-to').value = '';
    document.getElementById('price-min').value = '0';
    document.getElementById('price-max').value = '20000000';
    document.getElementById('mileage-from').value = '';
    document.getElementById('mileage-to').value = '';
    currentQuickFilter = 'all';
    document.querySelectorAll('.quick-filter-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.filter === 'all');
    });
    filterVehicles();
}

function switchView(view) {
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.view === view);
    });
    document.getElementById('vehicles-container').classList.toggle('list-view', view === 'list');
}

function toggleWishlist(event, btn) {
    event.preventDefault();
    event.stopPropagation();
    btn.classList.toggle('active');
    btn.querySelector('svg').setAttribute('fill', btn.classList.contains('active') ? 'currentColor' : 'none');
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=DM+Sans:wght@300;400;500;600&display=swap');

:root {
    --cream: #fdf8f3;
    --cream-dark: #f5ede0;
    --warm-white: #fffcf8;
    --accent: #c0392b;
    --accent-hover: #a93226;
    --accent-light: rgba(192, 57, 43, 0.08);
    --text-dark: #1a1612;
    --text-medium: #5c4e42;
    --text-light: #9b8b7e;
    --border: #e8ddd4;
    --border-light: #f0e8df;
    --success: #2d7a4f;
    --warning: #b45309;
    --shadow-sm: 0 1px 3px rgba(26,22,18,0.06);
    --shadow-md: 0 4px 16px rgba(26,22,18,0.08);
    --shadow-lg: 0 12px 40px rgba(26,22,18,0.12);
    --radius: 12px;
    --radius-sm: 8px;
    --tr: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'DM Sans', -apple-system, sans-serif;
    color: var(--text-dark);
    background: var(--cream);
    line-height: 1.6;
}

.vehicles-page { min-height: 100vh; }

.container-wrapper {
    max-width: 1320px;
    margin: 0 auto;
    padding: 0 32px;
}

/* ── HERO ── */
.hero-search {
    background: var(--cream-dark);
    padding: 80px 32px 44px;
    border-bottom: 1px solid var(--border);
}

.hero-content {
    text-align: center;
    margin-bottom: 36px;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2px;
    color: var(--accent);
    text-transform: uppercase;
    margin-bottom: 20px;
}

.eyebrow-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--accent);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}

.hero-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: clamp(36px, 5vw, 60px);
    font-weight: 700;
    line-height: 1.1;
    color: var(--text-dark);
    margin-bottom: 14px;
    letter-spacing: -0.5px;
}

.hero-title em {
    font-style: italic;
    color: var(--accent);
}

.hero-subtitle {
    font-size: 17px;
    color: var(--text-medium);
    font-weight: 300;
}

/* ── SEARCH BOX ── */
.search-box-container {
    max-width: 860px;
    margin: 0 auto 24px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.search-box {
    flex: 1;
    background: var(--warm-white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    padding: 5px 5px 5px 22px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: var(--tr);
    box-shadow: var(--shadow-sm);
}

.search-box:focus-within {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-light);
}

.search-icon { color: var(--text-light); flex-shrink: 0; }

.search-box input {
    flex: 1; border: none; outline: none;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px; color: var(--text-dark);
    background: transparent;
    padding: 14px 0;
}

.search-box input::placeholder { color: var(--text-light); }

.currency-selector {
    display: flex; align-items: center; gap: 8px;
    background: var(--warm-white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 10px 14px;
    white-space: nowrap;
    flex-shrink: 0;
}

.currency-selector svg { color: var(--text-light); }

.currency-dropdown {
    border: none; outline: none; background: transparent;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px; font-weight: 500;
    color: var(--text-dark); cursor: pointer;
}

/* ── QUICK FILTERS ── */
.quick-filters-section {
    max-width: 860px;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
}

.quick-filter-btn {
    padding: 9px 18px;
    border: 1.5px solid var(--border);
    border-radius: 100px;
    background: var(--warm-white);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 500;
    cursor: pointer; color: var(--text-medium);
    display: flex; align-items: center; gap: 6px;
    transition: var(--tr);
}

.quick-filter-btn:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.quick-filter-btn.active {
    background: var(--accent);
    color: white;
    border-color: var(--accent);
}

.advanced-toggle-btn {
    padding: 9px 18px;
    border: 1.5px solid var(--border);
    border-radius: 100px;
    background: var(--warm-white);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 500;
    cursor: pointer; color: var(--text-medium);
    display: flex; align-items: center; gap: 7px;
    transition: var(--tr);
    margin-left: auto;
}

.advanced-toggle-btn:hover,
.advanced-toggle-btn.active {
    border-color: var(--accent);
    color: var(--accent);
}

.advanced-toggle-btn .chevron {
    transition: transform 0.3s ease;
}

/* ── ADVANCED FILTERS ── */
.advanced-filters {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.advanced-filters.expanded { padding-top: 28px; }

.filters-grid {
    max-width: 860px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
    background: var(--warm-white);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    padding: 24px;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.filter-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--text-light);
}

.filter-select {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    background: var(--cream);
    color: var(--text-dark);
    cursor: pointer;
    outline: none;
    transition: var(--tr);
    appearance: auto;
}

.filter-select:focus, .filter-select:hover {
    border-color: var(--accent);
}

.filter-actions-group {
    justify-content: flex-end;
    padding-top: 24px;
}

.clear-btn {
    padding: 10px 18px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    background: transparent;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px; font-weight: 500;
    cursor: pointer; color: var(--text-medium);
    display: flex; align-items: center; gap: 7px;
    transition: var(--tr);
    white-space: nowrap;
}

.clear-btn:hover {
    background: var(--text-dark);
    color: white;
    border-color: var(--text-dark);
}

/* ── RESULTS SECTION ── */
.results-section { padding-top: 40px; padding-bottom: 80px; }

.results-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    padding-bottom: 24px;
    border-bottom: 1px solid var(--border-light);
}

.results-info { display: flex; align-items: baseline; gap: 8px; }

.results-info .count {
    font-family: 'Playfair Display', serif;
    font-size: 32px; font-weight: 700;
    color: var(--accent);
}

.results-info .label { font-size: 15px; color: var(--text-medium); font-weight: 300; }

.toolbar-right { display: flex; align-items: center; gap: 16px; }

.sort-wrapper { display: flex; align-items: center; gap: 10px; }

.sort-wrapper label {
    font-size: 13px; font-weight: 500;
    color: var(--text-light);
}

.toolbar-select {
    padding: 9px 14px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    background: var(--warm-white);
    color: var(--text-dark);
    cursor: pointer;
    outline: none;
    transition: var(--tr);
    min-width: 160px;
}

.toolbar-select:hover { border-color: var(--accent); }

.view-toggle {
    display: flex; gap: 2px;
    background: var(--cream-dark);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 3px;
}

.view-btn {
    background: transparent; border: none;
    padding: 8px 12px; border-radius: 6px;
    cursor: pointer; color: var(--text-light);
    transition: var(--tr);
    display: flex; align-items: center; justify-content: center;
}

.view-btn.active {
    background: var(--warm-white);
    color: var(--accent);
    box-shadow: var(--shadow-sm);
}

/* ── VEHICLES GRID ── */
.vehicles-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 48px;
}

.vehicles-grid.list-view {
    grid-template-columns: 1fr;
}

/* ── VEHICLE CARD ── */
.vehicle-card {
    background: var(--warm-white);
    border-radius: var(--radius);
    overflow: hidden;
    border: 1px solid var(--border-light);
    box-shadow: var(--shadow-sm);
    transition: var(--tr);
    display: flex;
    flex-direction: column;
}

.vehicle-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border);
}

.list-view .vehicle-card {
    display: grid;
    grid-template-columns: 320px 1fr;
    flex-direction: row;
}

/* ── CARD IMAGE ── */
.card-image-wrapper {
    position: relative;
    aspect-ratio: 4/3;
    background: var(--cream-dark);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.list-view .card-image-wrapper {
    aspect-ratio: auto;
    height: 100%;
    min-height: 220px;
}

.image-link { display: block; width: 100%; height: 100%; }

.card-image-wrapper img {
    width: 100%; height: 100%;
    object-fit: contain;
    transition: transform 0.4s ease;
}

.vehicle-card:hover .card-image-wrapper img {
    transform: scale(1.03);
}

.wishlist-icon {
    position: absolute; top: 12px; right: 12px;
    width: 34px; height: 34px;
    background: rgba(255,252,248,0.92);
    border: 1px solid var(--border);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--text-light);
    transition: var(--tr); z-index: 10;
    backdrop-filter: blur(4px);
}

.wishlist-icon:hover, .wishlist-icon.active { color: var(--accent); }

.card-badges {
    position: absolute; top: 12px; left: 12px;
    display: flex; flex-direction: column; gap: 5px; z-index: 10;
}

.badge {
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 10px; font-weight: 700;
    letter-spacing: 0.5px;
    display: inline-flex; align-items: center; gap: 4px;
}

.badge.verified { background: var(--success); color: white; }
.badge.featured { background: var(--warning); color: white; }

.image-counter {
    position: absolute; bottom: 10px; right: 10px;
    background: rgba(26,22,18,0.65);
    color: white;
    padding: 3px 8px; border-radius: 4px;
    font-size: 11px; font-weight: 600;
    display: flex; align-items: center; gap: 4px;
    backdrop-filter: blur(4px);
}

/* ── CARD BODY ── */
.card-body {
    padding: 18px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 10px;
}

.vehicle-title {
    font-size: 14px;
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: 2px;
}

.vehicle-title a {
    color: var(--text-dark);
    text-decoration: none;
    transition: color 0.2s;
}

.vehicle-title a:hover { color: var(--accent); }

.vehicle-year {
    display: block;
    font-size: 12px;
    color: var(--text-light);
    font-weight: 400;
}

.vehicle-price {
    font-size: 16px;
    font-weight: 700;
    color: var(--accent);
    white-space: nowrap;
}

.vehicle-specs {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
    padding: 10px 0;
    border-top: 1px solid var(--border-light);
    border-bottom: 1px solid var(--border-light);
}

.spec {
    font-size: 12px;
    color: var(--text-medium);
    display: flex; align-items: center; gap: 4px;
}

.spec svg { color: var(--text-light); }

.spec-dot {
    width: 3px; height: 3px;
    border-radius: 50%;
    background: var(--border);
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.location-info {
    display: flex; align-items: center; gap: 4px;
    font-size: 12px; color: var(--text-light);
}

.location-info svg { flex-shrink: 0; }

.view-details {
    font-size: 13px; font-weight: 600;
    color: var(--accent);
    text-decoration: none;
    transition: var(--tr);
    letter-spacing: -0.2px;
}

.view-details:hover { letter-spacing: 0.2px; }

/* ── REPORT SECTION ── */
.report-section {
    border-top: 1px solid var(--border-light);
    padding-top: 12px;
}

.report-btn {
    width: 100%;
    background: var(--accent);
    color: white;
    border: none;
    padding: 10px 14px;
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 12px; font-weight: 600;
    cursor: pointer; transition: var(--tr);
    display: flex; align-items: center; justify-content: center;
    gap: 6px; text-decoration: none;
}

.report-btn:hover { background: var(--accent-hover); transform: translateY(-1px); box-shadow: var(--shadow-md); }
.report-btn.report-verified { background: var(--success); }
.report-btn.report-verified:hover { background: #1f6b42; }
.report-btn.report-pending { background: var(--text-medium); opacity: 0.8; cursor: default; }

/* ── NO RESULTS ── */
.no-results-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 100px 20px;
}

.no-results-state svg { color: var(--text-light); margin-bottom: 24px; }
.no-results-state h3 { font-family: 'Playfair Display', serif; font-size: 28px; margin-bottom: 10px; }
.no-results-state p { color: var(--text-medium); margin-bottom: 28px; font-weight: 300; }

.btn-primary {
    background: var(--accent); color: white;
    border: none; padding: 13px 28px;
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-weight: 600; cursor: pointer;
    font-size: 14px; transition: var(--tr);
}

.btn-primary:hover { background: var(--accent-hover); transform: translateY(-2px); }

/* ── PAGINATION ── */
.pagination-wrapper {
    display: flex; justify-content: center;
    align-items: center; gap: 8px;
    padding: 40px 0 20px;
}

.page-nav, .page-num {
    background: var(--warm-white);
    border: 1.5px solid var(--border);
    width: 40px; height: 40px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-family: 'DM Sans', sans-serif;
    font-weight: 500; color: var(--text-medium);
    transition: var(--tr); font-size: 14px;
}

.page-nav:hover:not(:disabled), .page-num:hover {
    border-color: var(--accent); color: var(--accent);
}

.page-num.active {
    background: var(--accent); color: white;
    border-color: var(--accent);
}

.page-nav:disabled { opacity: 0.35; cursor: not-allowed; }

.page-ellipsis {
    color: var(--text-light);
    padding: 0 4px; font-size: 16px;
}

/* ── LIST VIEW ── */
.list-view .card-body { padding: 24px; }
.list-view .vehicle-title { font-size: 16px; }
.list-view .vehicle-price { font-size: 20px; }
.list-view .vehicle-specs { flex-wrap: nowrap; gap: 14px; }
.list-view .report-btn { width: auto; padding: 11px 20px; }

/* ── RESPONSIVE ── */
@media (max-width: 1200px) {
    .vehicles-grid { grid-template-columns: repeat(3, 1fr); }
    .filters-grid { grid-template-columns: repeat(4, 1fr); }
}

@media (max-width: 992px) {
    .vehicles-grid { grid-template-columns: repeat(2, 1fr); }
    .filters-grid { grid-template-columns: repeat(3, 1fr); }
    .list-view .vehicle-card { grid-template-columns: 1fr; }
    .list-view .card-image-wrapper { aspect-ratio: 4/3; min-height: auto; height: auto; }
}

@media (max-width: 768px) {
    .hero-search { padding: 60px 20px 32px; }
    .container-wrapper { padding: 0 20px; }
    .hero-title { font-size: 36px; }
    .search-box-container { flex-direction: column; gap: 10px; }
    .currency-selector { align-self: flex-end; }
    .quick-filters-section { gap: 8px; }
    .advanced-toggle-btn { margin-left: 0; }
    .filters-grid { grid-template-columns: repeat(2, 1fr); }
    .vehicles-grid { grid-template-columns: 1fr; gap: 16px; }
    .results-toolbar { flex-direction: column; align-items: flex-start; gap: 16px; }
    .toolbar-right { width: 100%; justify-content: space-between; }
}

@media (max-width: 480px) {
    .hero-title { font-size: 30px; }
    .filters-grid { grid-template-columns: 1fr; }
    .quick-filter-btn { flex: 1; justify-content: center; }
}

@media (min-width: 1600px) {
    .vehicles-grid { grid-template-columns: repeat(5, 1fr); }
    .container-wrapper { max-width: 1560px; }
}

/* Fade-in animation */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}

.vehicle-card {
    animation: fadeUp 0.35s ease-out both;
}

.vehicle-card:nth-child(1)  { animation-delay: 0ms; }
.vehicle-card:nth-child(2)  { animation-delay: 40ms; }
.vehicle-card:nth-child(3)  { animation-delay: 80ms; }
.vehicle-card:nth-child(4)  { animation-delay: 120ms; }
.vehicle-card:nth-child(5)  { animation-delay: 160ms; }
.vehicle-card:nth-child(6)  { animation-delay: 200ms; }
.vehicle-card:nth-child(7)  { animation-delay: 240ms; }
.vehicle-card:nth-child(8)  { animation-delay: 280ms; }
.vehicle-card:nth-child(9)  { animation-delay: 320ms; }
.vehicle-card:nth-child(10) { animation-delay: 360ms; }
.vehicle-card:nth-child(11) { animation-delay: 400ms; }
.vehicle-card:nth-child(12) { animation-delay: 440ms; }
.vehicle-card:nth-child(13) { animation-delay: 480ms; }
.vehicle-card:nth-child(14) { animation-delay: 520ms; }
.vehicle-card:nth-child(15) { animation-delay: 560ms; }
.vehicle-card:nth-child(16) { animation-delay: 600ms; }
.vehicle-card:nth-child(17) { animation-delay: 640ms; }
.vehicle-card:nth-child(18) { animation-delay: 680ms; }
.vehicle-card:nth-child(19) { animation-delay: 720ms; }
.vehicle-card:nth-child(20) { animation-delay: 760ms; }

/* Focus states */
.filter-select:focus, .toolbar-select:focus,
.currency-dropdown:focus, .search-box input:focus {
    outline: none;
}

button:focus-visible {
    outline: 2px solid var(--accent);
    outline-offset: 2px;
}
</style>

<!-- M-Pesa Payment Modal -->
<div id="mpesa-modal" class="mpesa-modal-overlay" onclick="closeMpesaModal(event)">
    <div class="mpesa-modal-box">
        <div id="mpesa-step-1" class="mpesa-step active">
            <div class="mpesa-modal-header">
                <div class="mpesa-logo-wrap">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
                </div>
                <div>
                    <h2 class="mpesa-modal-title">Pay via M-Pesa</h2>
                    <p class="mpesa-modal-car" id="modal-car-name">Vehicle Report</p>
                </div>
                <button class="mpesa-close-btn" onclick="closeMpesaModalDirect()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="mpesa-amount-display">
                <span class="amount-label">Amount to Pay</span>
                <span class="amount-value" id="modal-amount">KSh 0</span>
            </div>
            <div class="mpesa-instructions">
                <h3 class="instructions-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    How to Pay
                </h3>
                <ol class="steps-list">
                    <li><span class="step-num">1</span><span>Go to <strong>M-Pesa</strong> on your phone</span></li>
                    <li><span class="step-num">2</span><span>Select <strong>Lipa na M-Pesa → Paybill</strong></span></li>
                    <li><span class="step-num">3</span><span>Enter Business No: <strong class="highlight-num" onclick="copyText('247247')">247247</strong><button class="copy-btn" onclick="copyText('247247')"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg></button></span></li>
                    <li><span class="step-num">4</span><span>Account No: <strong class="highlight-num" id="modal-account-no" onclick="copyAccountNo()">CAR-001</strong><button class="copy-btn" onclick="copyAccountNo()"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg></button></span></li>
                    <li><span class="step-num">5</span><span>Enter Amount: <strong class="highlight-num" id="modal-amount-inline">0</strong></span></li>
                    <li><span class="step-num">6</span><span>Enter your M-Pesa PIN and confirm</span></li>
                </ol>
                <div class="mpesa-note">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    You will receive an M-Pesa confirmation SMS with a transaction code
                </div>
            </div>
            <button class="mpesa-next-btn" onclick="goToStep2()">
                I've Paid — Enter M-Pesa Code
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>

        <div id="mpesa-step-2" class="mpesa-step">
            <div class="mpesa-modal-header">
                <button class="mpesa-back-btn" onclick="goToStep1()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <div>
                    <h2 class="mpesa-modal-title">Enter M-Pesa Code</h2>
                    <p class="mpesa-modal-car">Confirm your payment</p>
                </div>
                <button class="mpesa-close-btn" onclick="closeMpesaModalDirect()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="code-input-section">
                <label class="code-label">M-Pesa Transaction Code</label>
                <p class="code-hint">This is the code from your M-Pesa confirmation SMS (e.g. <strong>SJK1AB2CD3</strong>)</p>
                <input type="text" id="mpesa-code-input" class="mpesa-code-input" placeholder="e.g. SJK1AB2CD3" maxlength="12" oninput="formatMpesaCode(this)" autocomplete="off" autocapitalize="characters">
                <div id="code-error" class="code-error hidden">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span id="code-error-text">Please enter a valid M-Pesa code</span>
                </div>
                <label class="code-label" style="margin-top:20px;">Your Phone Number</label>
                <p class="code-hint">We'll send your report access to this number</p>
                <div class="phone-input-wrap">
                    <span class="phone-prefix">+254</span>
                    <input type="tel" id="phone-input" class="phone-input" placeholder="7XX XXX XXX" maxlength="9" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                </div>
            </div>
            <div class="mpesa-summary-box">
                <div class="summary-row"><span>Vehicle</span><span id="summary-car-name">—</span></div>
                <div class="summary-row"><span>Amount</span><span id="summary-amount">—</span></div>
                <div class="summary-row"><span>Paybill</span><span>247247</span></div>
            </div>
            <button class="mpesa-submit-btn" id="submit-btn" onclick="submitMpesaCode()">
                <span id="submit-btn-text">Verify & Get Report</span>
                <svg id="submit-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <svg id="submit-spinner" class="spinner hidden" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
            </button>
        </div>

        <div id="mpesa-step-3" class="mpesa-step">
            <div class="mpesa-success-content">
                <div class="success-icon-wrap">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <h2 class="success-title">Payment Verified!</h2>
                <p class="success-msg">Your vehicle report is ready. You can now view the full inspection details.</p>
                <div class="success-details">
                    <div class="success-detail-row"><span>Transaction</span><strong id="success-code">—</strong></div>
                    <div class="success-detail-row"><span>Vehicle</span><strong id="success-car">—</strong></div>
                </div>
                <a href="#" id="view-report-link" class="view-report-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    View Full Report
                </a>
                <button class="mpesa-done-btn" onclick="closeMpesaModalDirect()">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="copy-toast" class="copy-toast">Copied!</div>

<style>
.mpesa-modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); backdrop-filter:blur(4px); z-index:9999; align-items:center; justify-content:center; padding:16px; }
.mpesa-modal-overlay.open { display:flex; }
.mpesa-modal-box { background:#fff; border-radius:16px; width:100%; max-width:480px; box-shadow:0 25px 60px rgba(0,0,0,0.25); overflow:hidden; animation:modalSlideIn 0.3s cubic-bezier(0.34,1.56,0.64,1); max-height:92vh; overflow-y:auto; }
@keyframes modalSlideIn { from{opacity:0;transform:translateY(30px) scale(0.97)} to{opacity:1;transform:translateY(0) scale(1)} }
.mpesa-step { display:none; padding:28px; }
.mpesa-step.active { display:block; }
.mpesa-modal-header { display:flex; align-items:center; gap:14px; margin-bottom:24px; padding-bottom:20px; border-bottom:1px solid #f0f0f0; }
.mpesa-logo-wrap { width:48px; height:48px; background:#e8f5e9; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#2e7d32; flex-shrink:0; }
.mpesa-modal-title { font-size:18px; font-weight:700; color:#1a1a1a; margin:0; line-height:1.2; }
.mpesa-modal-car { font-size:13px; color:#718096; margin:3px 0 0; }
.mpesa-close-btn,.mpesa-back-btn { margin-left:auto; background:#f7fafc; border:1px solid #e2e8f0; border-radius:8px; width:36px; height:36px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#4a5568; flex-shrink:0; transition:all 0.2s; }
.mpesa-back-btn { margin-left:0; margin-right:auto; }
.mpesa-close-btn:hover { background:#fed7d7; color:#c53030; border-color:#fc8181; }
.mpesa-back-btn:hover { background:#ebf8ff; color:#2b6cb0; border-color:#90cdf4; }
.mpesa-amount-display { background:linear-gradient(135deg, var(--accent) 0%, var(--accent-hover) 100%); border-radius:12px; padding:20px 24px; display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; color:white; }
.amount-label { font-size:13px; opacity:0.85; font-weight:500; }
.amount-value { font-size:26px; font-weight:800; letter-spacing:-0.5px; }
.instructions-title { font-size:14px; font-weight:700; color:#2d3748; display:flex; align-items:center; gap:8px; margin-bottom:16px; }
.steps-list { list-style:none; padding:0; margin:0 0 16px; display:flex; flex-direction:column; gap:12px; }
.steps-list li { display:flex; align-items:flex-start; gap:12px; font-size:14px; color:#4a5568; line-height:1.5; }
.step-num { width:24px; height:24px; background:var(--accent); color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex-shrink:0; margin-top:1px; }
.highlight-num { color:var(--accent); font-weight:700; cursor:pointer; }
.copy-btn { background:#f7fafc; border:1px solid #e2e8f0; border-radius:4px; padding:2px 6px; cursor:pointer; color:#718096; margin-left:6px; transition:all 0.2s; display:inline-flex; align-items:center; }
.copy-btn:hover { background:#ebf8ff; color:#2b6cb0; border-color:#90cdf4; }
.mpesa-note { background:#fffbeb; border:1px solid #fcd34d; border-radius:8px; padding:12px 14px; font-size:13px; color:#92400e; display:flex; align-items:flex-start; gap:8px; line-height:1.5; }
.mpesa-next-btn { width:100%; background:var(--accent); color:white; border:none; padding:16px 24px; border-radius:10px; font-size:15px; font-weight:700; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:8px; margin-top:20px; font-family:'DM Sans',sans-serif; }
.mpesa-next-btn:hover { background:var(--accent-hover); transform:translateY(-1px); box-shadow:0 6px 20px rgba(192,57,43,0.25); }
.code-input-section { margin-bottom:20px; }
.code-label { display:block; font-size:13px; font-weight:700; color:#2d3748; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; }
.code-hint { font-size:13px; color:#718096; margin-bottom:10px; line-height:1.5; }
.mpesa-code-input { width:100%; padding:14px 16px; border:2px solid #e2e8f0; border-radius:10px; font-size:18px; font-weight:700; letter-spacing:2px; color:#1a1a1a; text-transform:uppercase; transition:all 0.2s; outline:none; }
.mpesa-code-input:focus { border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-light); }
.phone-input-wrap { display:flex; align-items:center; border:2px solid #e2e8f0; border-radius:10px; overflow:hidden; transition:all 0.2s; }
.phone-input-wrap:focus-within { border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-light); }
.phone-prefix { background:#f7fafc; padding:14px; font-size:15px; font-weight:700; color:#4a5568; border-right:2px solid #e2e8f0; white-space:nowrap; }
.phone-input { flex:1; border:none; outline:none; padding:14px; font-size:15px; color:#1a1a1a; }
.code-error { display:flex; align-items:center; gap:6px; font-size:13px; color:#c53030; margin-top:8px; padding:8px 12px; background:#fff5f5; border-radius:6px; border:1px solid #fc8181; }
.code-error.hidden { display:none; }
.mpesa-summary-box { background:#f7fafc; border:1px solid #e2e8f0; border-radius:10px; padding:14px 16px; margin-bottom:20px; display:flex; flex-direction:column; gap:8px; }
.summary-row { display:flex; justify-content:space-between; font-size:13px; color:#4a5568; }
.summary-row span:first-child { color:#718096; }
.summary-row span:last-child,.summary-row strong { font-weight:600; color:#1a1a1a; }
.mpesa-submit-btn { width:100%; background:#2e7d32; color:white; border:none; padding:16px 24px; border-radius:10px; font-size:15px; font-weight:700; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:8px; font-family:'DM Sans',sans-serif; }
.mpesa-submit-btn:hover:not(:disabled) { background:#1b5e20; transform:translateY(-1px); box-shadow:0 6px 20px rgba(46,125,50,0.35); }
.mpesa-submit-btn:disabled { opacity:0.6; cursor:not-allowed; }
.mpesa-success-content { text-align:center; padding:10px 0; }
.success-icon-wrap { width:80px; height:80px; background:linear-gradient(135deg,#e8f5e9,#c8e6c9); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; color:#2e7d32; animation:successPop 0.5s cubic-bezier(0.34,1.56,0.64,1); }
@keyframes successPop { from{transform:scale(0);opacity:0} to{transform:scale(1);opacity:1} }
.success-title { font-size:24px; font-weight:800; color:#1a1a1a; margin-bottom:10px; }
.success-msg { font-size:14px; color:#718096; line-height:1.6; margin-bottom:24px; }
.success-details { background:#f7fafc; border-radius:10px; padding:16px; margin-bottom:24px; display:flex; flex-direction:column; gap:10px; text-align:left; }
.success-detail-row { display:flex; justify-content:space-between; font-size:14px; color:#4a5568; }
.success-detail-row span { color:#718096; }
.success-detail-row strong { color:#1a1a1a; }
.view-report-btn { display:inline-flex; align-items:center; gap:8px; background:var(--accent); color:white; text-decoration:none; padding:14px 28px; border-radius:10px; font-size:15px; font-weight:700; transition:all 0.2s; margin-bottom:12px; width:100%; justify-content:center; }
.view-report-btn:hover { background:var(--accent-hover); transform:translateY(-1px); }
.mpesa-done-btn { width:100%; background:transparent; border:1px solid #e2e8f0; border-radius:10px; padding:12px; font-size:14px; color:#718096; cursor:pointer; transition:all 0.2s; font-weight:500; }
.mpesa-done-btn:hover { background:#f7fafc; color:#4a5568; }
.spinner { animation:spin 0.8s linear infinite; }
@keyframes spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
.hidden { display:none !important; }
.copy-toast { position:fixed; bottom:30px; left:50%; transform:translateX(-50%) translateY(20px); background:#1a1a1a; color:white; padding:10px 20px; border-radius:8px; font-size:14px; font-weight:600; opacity:0; transition:all 0.3s ease; pointer-events:none; z-index:99999; }
.copy-toast.show { opacity:1; transform:translateX(-50%) translateY(0); }
</style>

<script>
let currentCarId = null;
let currentCarName = null;
let currentCarPrice = null;

function openPaymentModal(event, carId, reportPrice, carName) {
    event.stopPropagation();
    currentCarId = carId; currentCarName = carName; currentCarPrice = reportPrice;
    document.getElementById('modal-car-name').textContent = carName;
    document.getElementById('modal-amount').textContent = 'KSh ' + Number(reportPrice).toLocaleString();
    document.getElementById('modal-amount-inline').textContent = Number(reportPrice).toLocaleString();
    document.getElementById('modal-account-no').textContent = 'RPT-' + carId;
    document.getElementById('summary-car-name').textContent = carName;
    document.getElementById('summary-amount').textContent = 'KSh ' + Number(reportPrice).toLocaleString();
    goToStep1();
    document.getElementById('mpesa-code-input').value = '';
    hideError();
    document.getElementById('mpesa-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeMpesaModal(e) { if (e.target === document.getElementById('mpesa-modal')) closeMpesaModalDirect(); }
function closeMpesaModalDirect() { document.getElementById('mpesa-modal').classList.remove('open'); document.body.style.overflow = ''; }
function setStep(id) { document.querySelectorAll('.mpesa-step').forEach(s => s.classList.remove('active')); document.getElementById(id).classList.add('active'); }
function goToStep1() { setStep('mpesa-step-1'); }
function goToStep2() { setStep('mpesa-step-2'); }
function goToStep3() { setStep('mpesa-step-3'); }
function formatMpesaCode(input) { input.value = input.value.toUpperCase().replace(/[^A-Z0-9]/g,''); hideError(); }
function hideError() { document.getElementById('code-error').classList.add('hidden'); }
function showError(msg) { document.getElementById('code-error-text').textContent = msg; document.getElementById('code-error').classList.remove('hidden'); }
function copyText(text) {
    navigator.clipboard.writeText(text).catch(() => { const el = document.createElement('textarea'); el.value = text; document.body.appendChild(el); el.select(); document.execCommand('copy'); document.body.removeChild(el); });
    showToast('Copied: ' + text);
}
function copyAccountNo() { copyText('RPT-' + currentCarId); }
function showToast(msg) { const t = document.getElementById('copy-toast'); if (!t) return; t.textContent = msg; t.classList.add('show'); setTimeout(() => t.classList.remove('show'), 2000); }
function submitMpesaCode() {
    const code = document.getElementById('mpesa-code-input').value.trim();
    if (code.length < 8) { showError('Please enter a valid M-Pesa transaction code (min 8 characters)'); return; }
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfMeta) { showError('Page error — please refresh and try again.'); return; }
    const btn = document.getElementById('submit-btn');
    const btnText = document.getElementById('submit-btn-text');
    const btnIcon = document.getElementById('submit-icon');
    const spinner = document.getElementById('submit-spinner');
    if (btn) btn.disabled = true;
    if (btnText) btnText.textContent = 'Submitting...';
    if (btnIcon) btnIcon.classList.add('hidden');
    if (spinner) spinner.classList.remove('hidden');
    function resetBtn() { if (btn) btn.disabled = false; if (btnText) btnText.textContent = 'Verify & Get Report'; if (btnIcon) btnIcon.classList.remove('hidden'); if (spinner) spinner.classList.add('hidden'); }
    fetch(`/vehicles/${currentCarId}/submit-report-payment`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfMeta.getAttribute('content') },
        body: JSON.stringify({ mpesa_code: code, amount: currentCarPrice })
    })
    .then(res => {
        if (res.status === 419) throw new Error('csrf');
        if (res.status === 401) { window.location.href = '/sell?redirect=' + encodeURIComponent(window.location.href); throw new Error('unauthenticated'); }
        if (res.status === 422) return res.json().then(d => { throw { type: 'validation', errors: d.errors }; });
        if (!res.ok) throw new Error('http_' + res.status);
        return res.json();
    })
    .then(data => {
        resetBtn();
        if (data.success) { goToStep3(); }
        else { showError(data.message || 'Something went wrong. Please try again.'); }
    })
    .catch(err => {
        if (err.message === 'unauthenticated') return;
        resetBtn();
        if (err && err.type === 'validation') showError(Object.values(err.errors).flat().join(' '));
        else if (err.message === 'csrf') showError('Session expired — please refresh and try again.');
        else { showError('Request failed. Please check your connection and try again.'); console.error(err); }
    });
}
</script>
@endsection
