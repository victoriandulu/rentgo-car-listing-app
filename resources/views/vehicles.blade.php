@extends('layouts.app')

@section('content')
<div class="vehicles-page">
    <!-- Enhanced Top Bar -->
    <div class="top-navigation">
        <div class="container-wrapper">
            <div class="currency-selector">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
    </div>

    <!-- Hero Search Section with Filters -->
    <div class="hero-search">
        <div class="container-wrapper">
            <h1 class="hero-title">Find Your Perfect Vehicle</h1>
            <p class="hero-subtitle">Browse {{ $cars->count() }} quality vehicles from trusted dealers</p>

            <!-- Main Search Bar -->
            <div class="search-box-container">
                <div class="search-box">
                    <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    <input type="text" id="main-search" placeholder="Search by make, model, or keyword..." oninput="filterVehicles()">
                </div>
            </div>

            <!-- Advanced Filters Card -->
            <div class="filters-card">
                <!-- Primary Filters Row -->
                <div class="filters-row primary-filters">
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
                            <option value="500000">KSh 500,000</option>
                            <option value="1000000">KSh 1,000,000</option>
                            <option value="2000000">KSh 2,000,000</option>
                            <option value="3000000">KSh 3,000,000</option>
                            <option value="5000000">KSh 5,000,000</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Max Price</label>
                        <select id="price-max" class="filter-select" onchange="filterVehicles()">
                            <option value="20000000">No Max</option>
                            <option value="1000000">KSh 1,000,000</option>
                            <option value="2000000">KSh 2,000,000</option>
                            <option value="3000000">KSh 3,000,000</option>
                            <option value="5000000">KSh 5,000,000</option>
                            <option value="10000000">KSh 10,000,000</option>
                        </select>
                    </div>
                </div>

                <!-- Secondary Filters Row -->
                <div class="filters-row secondary-filters">
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
                </div>

                <!-- Mileage Filter Row -->
                <div class="filters-row mileage-filters">
                    <div class="filter-group">
                        <label class="filter-label">Min Mileage (km)</label>
                        <input type="number" id="mileage-from" class="filter-input" placeholder="e.g., 0" onchange="filterVehicles()">
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Max Mileage (km)</label>
                        <input type="number" id="mileage-to" class="filter-input" placeholder="e.g., 150000" onchange="filterVehicles()">
                    </div>

                    <div class="filter-group filter-spacer"></div>
                    <div class="filter-group filter-spacer"></div>
                </div>

                <!-- Quick Filters -->
                <div class="quick-filters">
                    <button class="quick-filter-btn active" data-filter="all" onclick="quickFilter('all')">All Vehicles</button>
                    <button class="quick-filter-btn" data-filter="local" onclick="quickFilter('local')">In Kenya</button>
                    <button class="quick-filter-btn" data-filter="imports" onclick="quickFilter('imports')">Imports</button>
                    <button class="quick-filter-btn" data-filter="verified" onclick="quickFilter('verified')">Verified Dealers</button>
                    <button class="clear-btn" onclick="clearAllFilters()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                        Clear All
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-wrapper">
        <!-- Results Toolbar -->
        <div class="results-toolbar">
            <div class="results-info">
                <span class="count" id="results-count">{{ $cars->count() }}</span>
                <span class="text">vehicles found</span>
            </div>

            <div class="toolbar-controls">
                <div class="sort-wrapper">
                    <label>Sort by:</label>
                    <select id="sort-select" class="toolbar-select" onchange="sortVehicles()">
                        <option value="featured">Featured</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="year-new">Newest First</option>
                        <option value="year-old">Oldest First</option>
                        <option value="mileage-low">Lowest Mileage</option>
                    </select>
                </div>

                <div class="view-toggle">
                    <button class="view-btn active" data-view="grid" onclick="switchView('grid')" title="Grid View">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <rect x="3" y="3" width="7" height="7" rx="1"/>
                            <rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/>
                            <rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                    </button>
                    <button class="view-btn" data-view="list" onclick="switchView('list')" title="List View">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="8" y1="6" x2="21" y2="6"/>
                            <line x1="8" y1="12" x2="21" y2="12"/>
                            <line x1="8" y1="18" x2="21" y2="18"/>
                            <rect x="3" y="4" width="2" height="4"/>
                            <rect x="3" y="10" width="2" height="4"/>
                            <rect x="3" y="16" width="2" height="4"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Vehicles Grid -->
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

                    <!-- Image Container -->
                    <div class="card-image-wrapper">
                        <a href="{{ route('vehicles.show', $car->id ?? 1) }}" class="image-link">
                            <img src="{{ $mainImage }}" alt="{{ $car->name ?? 'Vehicle' }}" loading="lazy">
                        </a>

                        <button class="wishlist-icon" onclick="toggleWishlist(event, this)" aria-label="Add to wishlist">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                            </svg>
                        </button>

                        <div class="card-badges">
                            @if($car->user && $car->user->is_verified)
                                <span class="badge verified">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                    Verified
                                </span>
                            @endif
                            @if($car->featured ?? false)
                                <span class="badge featured">Featured</span>
                            @endif
                        </div>

                        @if(count($images) > 1)
                            <div class="image-counter">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                </svg>
                                {{ count($images) }}
                            </div>
                        @endif
                    </div>

                    <!-- Card Content -->
                    <div class="card-body">
                        <div class="card-top">
                            <div class="vehicle-title-section">
                                <h3 class="vehicle-title">
                                    <a href="{{ route('vehicles.show', $car->id ?? 1) }}">
                                        {{ $car->name ?? 'Toyota Fortuner' }}
                                    </a>
                                </h3>
                                <span class="vehicle-year">{{ $car->year ?? 2014 }}</span>
                            </div>

                            <div class="vehicle-price" data-original-price="{{ $car->price ?? 2500000 }}">
                                KSh {{ number_format($car->price ?? 2500000) }}
                            </div>
                        </div>

                        <div class="vehicle-specs">
                            <span class="spec">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ number_format($car->mileage ?? 85000) }} km
                            </span>
                            <span class="spec">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="10" rx="2"/>
                                    <circle cx="7" cy="16" r="1"/>
                                    <circle cx="17" cy="16" r="1"/>
                                </svg>
                                {{ $car->transmission_type ?? 'Auto' }}
                            </span>
                            <span class="spec">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                {{ $car->fuel_type ?? 'Petrol' }}
                            </span>
                        </div>

                        <div class="card-footer">
                            <div class="dealer-info">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                {{ $car->location ?? 'Nairobi' }}
                            </div>
                            <a href="{{ route('vehicles.show', $car->id ?? 1) }}" class="view-details">
                                View
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6"/>
                                </svg>
                            </a>
                        </div>

                        <!-- Buy Report Button -->
                        @if($car->report ?? true)
                            <div class="report-section">
                                <button class="report-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                        <polyline points="14 2 14 8 20 8"/>
                                        <line x1="16" y1="13" x2="8" y2="13"/>
                                        <line x1="16" y1="17" x2="8" y2="17"/>
                                        <polyline points="10 9 9 9 8 9"/>
                                    </svg>
                                    @if($car->report_price)
                                        Buy Report: KSh {{ number_format($car->report_price) }}
                                    @else
                                        Buy Report: N/A
                                    @endif
                                </button>
                            </div>
                        @endif
                    </div>
                </article>
            @empty
                <div class="no-results-state">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    <h3>No vehicles found</h3>
                    <p>Try adjusting your filters or search criteria</p>
                    <button class="btn-primary" onclick="clearAllFilters()">Clear Filters</button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <nav class="pagination-wrapper" aria-label="Pagination">
            <button class="page-nav" aria-label="Previous page" disabled>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </button>
            <button class="page-num active">1</button>
            <button class="page-num">2</button>
            <button class="page-num">3</button>
            <span class="page-ellipsis">...</span>
            <button class="page-num">10</button>
            <button class="page-nav" aria-label="Next page">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </button>
        </nav>
    </div>
</div>

<script>
// Global variables
let currentCurrency = 'KES';
let currentRate = 1;
let currentSymbol = 'KSh';
let currentQuickFilter = 'all';

// Currency conversion
function updateCurrency() {
    const select = document.getElementById('currency-select');
    const option = select.options[select.selectedIndex];
    currentCurrency = option.value;
    currentRate = parseFloat(option.dataset.rate);
    currentSymbol = option.dataset.symbol;

    document.querySelectorAll('.vehicle-price').forEach(el => {
        const originalPrice = parseFloat(el.dataset.originalPrice);
        const converted = originalPrice * currentRate;
        el.textContent = formatPrice(converted);
    });
}

function formatPrice(amount) {
    if (['KES', 'UGX', 'TZS'].includes(currentCurrency)) {
        return `${currentSymbol} ${Math.round(amount).toLocaleString()}`;
    }
    return `${currentSymbol}${Math.round(amount).toLocaleString()}`;
}

// Quick filter
function quickFilter(type) {
    currentQuickFilter = type;

    document.querySelectorAll('.quick-filter-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.filter === type);
    });

    filterVehicles();
}

// Filter vehicles
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

    const cards = document.querySelectorAll('.vehicle-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const cardMake = card.dataset.make;
        const cardYear = parseInt(card.dataset.year);
        const cardPrice = parseInt(card.dataset.price);
        const cardMileage = parseInt(card.dataset.mileage);
        const cardName = card.dataset.name;
        const cardCategory = card.dataset.category;
        const cardBodyType = card.dataset.bodyType;
        const cardTransmission = card.dataset.transmission;
        const cardFuel = card.dataset.fuel;
        const cardVerified = card.dataset.verified === 'true';

        let matches = true;

        // Quick filter
        if (currentQuickFilter !== 'all') {
            if (currentQuickFilter === 'local' && cardCategory !== 'local') matches = false;
            if (currentQuickFilter === 'imports' && cardCategory !== 'imports') matches = false;
            if (currentQuickFilter === 'verified' && !cardVerified) matches = false;
        }

        // Search
        if (searchTerm && !cardName.includes(searchTerm)) matches = false;

        // Make
        if (selectedMake && cardMake !== selectedMake) matches = false;

        // Body Type
        if (selectedBodyType && cardBodyType !== selectedBodyType) matches = false;

        // Transmission
        if (selectedTransmission && cardTransmission !== selectedTransmission) matches = false;

        // Fuel
        if (selectedFuel && cardFuel !== selectedFuel) matches = false;

        // Year
        if (yearFrom && cardYear < parseInt(yearFrom)) matches = false;
        if (yearTo && cardYear > parseInt(yearTo)) matches = false;

        // Price
        if (cardPrice < minPrice || cardPrice > maxPrice) matches = false;

        // Mileage
        if (mileageFrom && cardMileage < parseInt(mileageFrom)) matches = false;
        if (mileageTo && cardMileage > parseInt(mileageTo)) matches = false;

        card.style.display = matches ? 'block' : 'none';
        if (matches) visibleCount++;
    });

    document.getElementById('results-count').textContent = visibleCount;
}

// Sort vehicles
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

// Clear filters
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

// View switching
function switchView(view) {
    const container = document.getElementById('vehicles-container');
    const buttons = document.querySelectorAll('.view-btn');

    buttons.forEach(btn => {
        btn.classList.toggle('active', btn.dataset.view === view);
    });

    container.classList.toggle('list-view', view === 'list');
}

// Toggle wishlist
function toggleWishlist(event, btn) {
    event.preventDefault();
    event.stopPropagation();
    btn.classList.toggle('active');
    const svg = btn.querySelector('svg');
    svg.setAttribute('fill', btn.classList.contains('active') ? 'currentColor' : 'none');
}
</script>

<style>
:root {
    --primary: #d32f2f;
    --primary-dark: #b71c1c;
    --primary-light: #ef5350;
    --secondary: #1976d2;
    --text-dark: #1a1a1a;
    --text-medium: #4a5568;
    --text-light: #718096;
    --border: #e2e8f0;
    --bg-light: #f7fafc;
    --bg-white: #ffffff;
    --success: #10b981;
    --warning: #f59e0b;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    --radius: 8px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    color: var(--text-dark);
    background: var(--bg-light);
    line-height: 1.6;
}

.vehicles-page {
    min-height: 100vh;
    padding-top: 70px;
}

/* TOP NAVIGATION */
.top-navigation {
    background: var(--bg-white);
    border-bottom: 1px solid var(--border);
    padding: 12px 0;
    position: fixed;
    top: 60px;
    left: 0;
    right: 0;
    z-index: 999;
}

.container-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
}

.top-navigation .container-wrapper {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.currency-selector {
    display: flex;
    align-items: center;
    gap: 8px;
}

.currency-selector svg {
    color: var(--text-light);
}

.currency-dropdown {
    padding: 6px 12px;
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: 14px;
    background: var(--bg-white);
    cursor: pointer;
    transition: var(--transition);
}

.currency-dropdown:hover {
    border-color: var(--primary);
}

/* HERO SEARCH WITH FILTERS */
.hero-search {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    padding: 50px 24px 70px;
    margin-top: 48px;
    color: white;
}

.hero-title {
    font-size: 42px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 12px;
    letter-spacing: -0.5px;
}

.hero-subtitle {
    text-align: center;
    font-size: 18px;
    opacity: 0.95;
    margin-bottom: 32px;
}

.search-box-container {
    max-width: 900px;
    margin: 0 auto 24px;
}

.search-box {
    background: white;
    border-radius: 12px;
    padding: 6px 6px 6px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--shadow-xl);
}

.search-icon {
    color: var(--text-light);
    flex-shrink: 0;
}

.search-box input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 16px;
    color: var(--text-dark);
    padding: 16px 0;
}

.search-box input::placeholder {
    color: var(--text-light);
}

/* FILTERS CARD */
.filters-card {
    max-width: 1100px;
    margin: 0 auto;
    background: white;
    border-radius: 12px;
    padding: 32px;
    box-shadow: var(--shadow-xl);
}

.filters-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}

.filters-row:last-of-type {
    margin-bottom: 0;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-group.filter-spacer {
    visibility: hidden;
}

.filter-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-dark);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-select,
.filter-input {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 14px;
    background: var(--bg-white);
    cursor: pointer;
    transition: var(--transition);
    outline: none;
    color: var(--text-dark);
}

.filter-input {
    cursor: text;
}

.filter-select:hover,
.filter-select:focus,
.filter-input:hover,
.filter-input:focus {
    border-color: var(--primary);
}

/* Quick Filters */
.quick-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
    padding-top: 24px;
    border-top: 1px solid var(--border);
    margin-top: 24px;
}

.quick-filter-btn {
    padding: 10px 20px;
    border: 2px solid var(--border);
    border-radius: 8px;
    background: white;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    color: var(--text-medium);
}

.quick-filter-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-1px);
}

.quick-filter-btn.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.clear-btn {
    padding: 10px 20px;
    border: 2px solid var(--border);
    border-radius: 8px;
    background: var(--bg-light);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    color: var(--text-medium);
    display: flex;
    align-items: center;
    gap: 8px;
    margin-left: auto;
}

.clear-btn:hover {
    background: var(--text-dark);
    color: white;
    border-color: var(--text-dark);
}

/* RESULTS TOOLBAR */
.results-toolbar {
    background: var(--bg-white);
    padding: 20px 24px;
    border-radius: var(--radius);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 32px 0 24px;
    box-shadow: var(--shadow-sm);
}

.results-info {
    display: flex;
    align-items: baseline;
    gap: 8px;
}

.results-info .count {
    font-size: 28px;
    font-weight: 700;
    color: var(--primary);
}

.results-info .text {
    font-size: 15px;
    color: var(--text-medium);
}

.toolbar-controls {
    display: flex;
    align-items: center;
    gap: 20px;
}

.sort-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sort-wrapper label {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-medium);
}

.toolbar-select {
    padding: 10px 16px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 14px;
    background: var(--bg-white);
    cursor: pointer;
    transition: var(--transition);
    min-width: 180px;
}

.toolbar-select:hover {
    border-color: var(--primary);
}

.view-toggle {
    display: flex;
    gap: 6px;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 4px;
    background: var(--bg-light);
}

.view-btn {
    background: transparent;
    border: none;
    padding: 10px 14px;
    border-radius: 6px;
    cursor: pointer;
    color: var(--text-light);
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.view-btn:hover {
    color: var(--text-dark);
}

.view-btn.active {
    background: var(--bg-white);
    color: var(--primary);
    box-shadow: var(--shadow-sm);
}

/* VEHICLES GRID - 4 CARDS PER ROW */
.vehicles-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 48px;
}

.vehicles-grid.list-view {
    grid-template-columns: 1fr;
}

/* VEHICLE CARD */
.vehicle-card {
    background: var(--bg-white);
    border-radius: 8px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    border: 1px solid var(--border);
    display: flex;
    flex-direction: column;
}

.vehicle-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.list-view .vehicle-card {
    display: grid;
    grid-template-columns: 350px 1fr;
    flex-direction: row;
}

/* FIXED IMAGE CONTAINER - NO CROPPING */
.card-image-wrapper {
    position: relative;
    background: var(--bg-light);
    overflow: hidden;
    width: 100%;
    aspect-ratio: 4/3;
    display: flex;
    align-items: center;
    justify-content: center;
}

.list-view .card-image-wrapper {
    aspect-ratio: auto;
    height: 100%;
    min-height: 250px;
}

.image-link {
    display: block;
    width: 100%;
    height: 100%;
}

.card-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.4s ease;
}

.vehicle-card:hover .card-image-wrapper img {
    transform: scale(1.05);
}

.wishlist-icon {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.95);
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--text-light);
    transition: var(--transition);
    z-index: 10;
    box-shadow: var(--shadow-md);
}

.wishlist-icon svg {
    width: 16px;
    height: 16px;
}

.wishlist-icon:hover, .wishlist-icon.active {
    color: var(--primary);
    transform: scale(1.1);
}

.card-badges {
    position: absolute;
    top: 10px;
    left: 10px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    z-index: 10;
}

.badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    box-shadow: var(--shadow-sm);
}

.badge.verified {
    background: var(--success);
    color: white;
}

.badge.featured {
    background: var(--warning);
    color: white;
}

.image-counter {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.75);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
}

.card-body {
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
}

.card-top {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.vehicle-title-section {
    display: flex;
    justify-content: space-between;
    align-items: start;
    gap: 8px;
}

.vehicle-title {
    font-size: 15px;
    font-weight: 700;
    line-height: 1.3;
    flex: 1;
}

.vehicle-title a {
    color: var(--text-dark);
    text-decoration: none;
    transition: color 0.2s;
}

.vehicle-title a:hover {
    color: var(--primary);
}

.vehicle-year {
    font-size: 12px;
    color: var(--text-light);
    font-weight: 600;
    white-space: nowrap;
}

.vehicle-price {
    font-size: 17px;
    font-weight: 700;
    color: var(--primary);
}

.vehicle-specs {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding: 10px 0;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
}

.spec {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: var(--text-medium);
    font-weight: 500;
}

.spec svg {
    flex-shrink: 0;
    color: var(--text-light);
    width: 12px;
    height: 12px;
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
}

.dealer-info {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: var(--text-medium);
}

.dealer-info svg {
    color: var(--text-light);
    flex-shrink: 0;
}

.view-details {
    color: var(--primary);
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: var(--transition);
    white-space: nowrap;
}

.view-details:hover {
    gap: 8px;
}

/* BUY REPORT SECTION */
.report-section {
    padding-top: 12px;
    border-top: 1px solid var(--border);
    margin-top: auto;
}

.report-btn {
    width: 100%;
    background: #a16207;
    color: white;
    border: none;
    padding: 10px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.report-btn:hover {
    background: #000;
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
}

.report-btn svg {
    flex-shrink: 0;
}

/* LIST VIEW ADJUSTMENTS */
.list-view .vehicle-card {
    min-height: 240px;
}

.list-view .card-body {
    padding: 24px;
}

.list-view .vehicle-title {
    font-size: 17px;
}

.list-view .vehicle-price {
    font-size: 22px;
}

.list-view .vehicle-specs {
    flex-wrap: nowrap;
    gap: 20px;
}

.list-view .spec {
    font-size: 13px;
}

.list-view .spec svg {
    width: 14px;
    height: 14px;
}

.list-view .report-btn {
    width: auto;
    padding: 12px 20px;
    font-size: 13px;
}

/* NO RESULTS STATE */
.no-results-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
}

.no-results-state svg {
    color: var(--text-light);
    margin-bottom: 24px;
}

.no-results-state h3 {
    font-size: 26px;
    margin-bottom: 12px;
}

.no-results-state p {
    color: var(--text-medium);
    margin-bottom: 28px;
    font-size: 16px;
}

.btn-primary {
    background: var(--primary);
    color: white;
    border: none;
    padding: 14px 28px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    font-size: 15px;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* PAGINATION */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    gap: 10px;
    padding: 48px 0;
}

.page-nav, .page-num {
    background: var(--bg-white);
    border: 1px solid var(--border);
    width: 42px;
    height: 42px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-weight: 600;
    color: var(--text-medium);
    transition: var(--transition);
    font-size: 15px;
}

.page-nav:hover:not(:disabled), .page-num:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: translateY(-2px);
}

.page-num.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
}

.page-nav:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

.page-ellipsis {
    display: flex;
    align-items: center;
    padding: 0 6px;
    color: var(--text-light);
}

/* RESPONSIVE DESIGN */
@media (max-width: 1400px) {
    .vehicles-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 1200px) {
    .filters-row {
        grid-template-columns: repeat(3, 1fr);
    }

    .vehicles-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 992px) {
    .filters-row {
        grid-template-columns: repeat(2, 1fr);
    }

    .vehicles-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .list-view .vehicle-card {
        grid-template-columns: 1fr;
    }

    .list-view .card-image-wrapper {
        aspect-ratio: 4/3;
        height: auto;
        min-height: auto;
    }
}

@media (max-width: 768px) {
    .vehicles-page {
        padding-top: 60px;
    }

    .hero-search {
        padding: 32px 20px 50px;
        margin-top: 42px;
    }

    .hero-title {
        font-size: 30px;
    }

    .hero-subtitle {
        font-size: 16px;
        margin-bottom: 24px;
    }

    .search-box {
        padding: 16px 20px;
    }

    .filters-card {
        padding: 24px 20px;
    }

    .filters-row {
        grid-template-columns: 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    .filter-group.filter-spacer {
        display: none;
    }

    .quick-filters {
        padding-top: 20px;
        margin-top: 20px;
    }

    .quick-filter-btn, .clear-btn {
        font-size: 13px;
        padding: 9px 16px;
    }

    .clear-btn {
        margin-left: 0;
        width: 100%;
        justify-content: center;
    }

    .results-toolbar {
        flex-direction: column;
        align-items: stretch;
        gap: 16px;
        padding: 18px 20px;
    }

    .toolbar-controls {
        flex-direction: column;
        align-items: stretch;
        gap: 14px;
    }

    .sort-wrapper {
        justify-content: space-between;
    }

    .toolbar-select {
        flex: 1;
        min-width: auto;
    }

    .vehicles-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .card-image-wrapper {
        aspect-ratio: 4/3;
    }

    .card-body {
        padding: 14px;
    }

    .vehicle-specs {
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
    }

    .vehicle-price {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .container-wrapper {
        padding: 0 16px;
    }

    .hero-title {
        font-size: 26px;
    }

    .hero-subtitle {
        font-size: 15px;
    }

    .filters-card {
        padding: 20px 16px;
    }

    .quick-filters {
        flex-direction: column;
        align-items: stretch;
    }

    .quick-filter-btn {
        width: 100%;
        justify-content: center;
    }

    .vehicles-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .card-image-wrapper {
        aspect-ratio: 4/3;
    }

    .vehicle-title {
        font-size: 14px;
    }

    .card-body {
        padding: 14px;
    }

    .report-btn {
        font-size: 11px;
        padding: 10px 12px;
    }
}

@media (min-width: 1600px) {
    .vehicles-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .container-wrapper {
        max-width: 1600px;
    }

    .filters-card {
        max-width: 1300px;
    }
}
</style>
@endsection
