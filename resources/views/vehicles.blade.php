@extends('layouts.app')

@section('content')
<div class="vehicles-page">
    <!-- Header with filters -->
    <div class="header-section">
        <div class="top-controls">
            <div class="show-dropdown">
                <label for="show-select">Show</label>
                <select id="show-select" class="show-select" onchange="updateResults()">
                    <option value="12">12</option>
                    <option value="24">24</option>
                    <option value="36">36</option>
                </select>
            </div>

            <div class="search-container">
                <input type="text" id="search-input" placeholder="Search vehicles..." class="search-input" oninput="filterVehicles()">
                <button class="search-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M21 21L16.514 16.506L21 21ZM19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Advanced Filters -->
        <div class="filters-row">
            <div class="filter-group">
                <label>Make</label>
                <select id="make-filter" class="filter-select" onchange="filterVehicles()">
                    <option value="">All Makes</option>
                    <option value="toyota">Toyota</option>
                    <option value="honda">Honda</option>
                    <option value="nissan">Nissan</option>
                    <option value="mazda">Mazda</option>
                    <option value="subaru">Subaru</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Year of Manufacture</label>
                <select id="year-filter" class="filter-select" onchange="filterVehicles()">
                    <option value="">All Years</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                    <option value="2013">2013</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Price Range</label>
                <div class="price-range">
                    <span class="price-label">Ksh <span id="min-price">500,000</span></span>
                    <input type="range" id="price-slider" min="500000" max="20000000" value="10000000" class="price-slider" oninput="updatePriceRange()">
                    <span class="price-label">Ksh <span id="max-price">20,000,000</span></span>
                </div>
                <button class="clear-filters-btn" onclick="clearAllFilters()">Clear Filters</button>
            </div>
        </div>

        <!-- Category Filters -->
        <div class="category-filters">
            <a href="{{ route('vehicles', ['category' => 'All Vehicles']) }}"
               class="filter-btn {{ ($category ?? '') === 'All Vehicles' ? 'active' : '' }}"
               onclick="filterByCategory('all')">
                All
            </a>
            <a href="{{ route('vehicles', ['category' => 'Vehicles in Kenya']) }}"
               class="filter-btn {{ ($category ?? '') === 'Vehicles in Kenya' ? 'active' : '' }}"
               onclick="filterByCategory('local')">
                Local
            </a>
            <a href="{{ route('vehicles', ['category' => 'Imports']) }}"
               class="filter-btn {{ ($category ?? '') === 'Imports' ? 'active' : '' }}"
               onclick="filterByCategory('imports')">
                Imports
            </a>
        </div>
    </div>

    <!-- Results Info -->
    <div class="results-info">
        <span id="results-count">{{ $cars->count() }} vehicles found</span>
    </div>

    <!-- Vehicles Grid -->
    <div class="vehicles-grid" id="vehicles-grid">
        @forelse($cars as $car)
            @php
                $images = $car->images ? (is_string($car->images) ? json_decode($car->images, true) : (array)$car->images) : [];
                $mainImage = count($images) ? asset('storage/' . $images[0]) : 'https://via.placeholder.com/400x300';
            @endphp

            <div class="vehicle-card"
                 data-make="{{ strtolower($car->make ?? 'toyota') }}"
                 data-year="{{ $car->year ?? '2014' }}"
                 data-price="{{ $car->price ?? 2500000 }}"
                 data-category="{{ $car->category ?? 'local' }}"
                 data-name="{{ strtolower($car->name ?? 'toyota fortuner') }}">

                <div class="image-section">
                    <!-- Price and Mileage Badge -->
                    <div class="price-mileage-badge">
                        Ksh {{ number_format($car->price ?? 2500000) }} | {{ number_format($car->mileage ?? 85000) }}km
                    </div>

                    <!-- Verified Badge -->
                    @if($car->user && $car->user->is_verified)
                        <div class="verified-badge">VERIFIED</div>
                    @endif

                    <img src="{{ $mainImage }}" alt="{{ $car->name ?? 'Toyota Fortuner' }}">
                </div>

                <div class="card-content">
                    <h3 class="vehicle-title">{{ strtoupper($car->name ?? 'TOYOTA FORTUNER') }} ({{ $car->year ?? '2014' }})</h3>

                    <div class="vehicle-specs">
                        {{ $car->transmission ?? '4WD' }}, {{ $car->engine_size ?? '2982' }}cc, {{ $car->transmission_type ?? '5MT' }}, {{ $car->fuel_type ?? 'Diesel' }}, {{ $car->car_type ?? $car->body_type ?? 'SUV' }}, good condition
                    </div>

                    <div class="dealer-info">{{ $car->source ?? 'Rosefel Motors' }}</div>

                    <div class="action-buttons">
                        <a href="{{ route('vehicles.show', $car->id ?? 1) }}" class="view-btn">View</a>
                        @if($car->report ?? true)
                            <button class="report-btn">Buy Report: Ksh {{ $car->report_price ?? '2500' }}</button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="no-vehicles">
                <p>No vehicles available at the moment.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
function filterVehicles() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    const selectedMake = document.getElementById('make-filter').value.toLowerCase();
    const selectedYear = document.getElementById('year-filter').value;
    const minPrice = 500000; // Minimum price threshold
    const maxPrice = parseInt(document.getElementById('price-slider').value);

    const cards = document.querySelectorAll('.vehicle-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const cardMake = card.dataset.make;
        const cardYear = card.dataset.year;
        const cardPrice = parseInt(card.dataset.price);
        const cardName = card.dataset.name;

        const matchesSearch = !searchTerm || cardName.includes(searchTerm);
        const matchesMake = !selectedMake || cardMake === selectedMake;
        const matchesYear = !selectedYear || cardYear === selectedYear;
        const matchesPrice = cardPrice >= minPrice && cardPrice <= maxPrice;

        if (matchesSearch && matchesMake && matchesYear && matchesPrice) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('results-count').textContent = `${visibleCount} vehicles found`;
}

function updatePriceRange() {
    const slider = document.getElementById('price-slider');
    const maxPriceSpan = document.getElementById('max-price');
    maxPriceSpan.textContent = parseInt(slider.value).toLocaleString();
    filterVehicles();
}

function clearAllFilters() {
    document.getElementById('search-input').value = '';
    document.getElementById('make-filter').value = '';
    document.getElementById('year-filter').value = '';
    document.getElementById('price-slider').value = '20000000';
    document.getElementById('max-price').textContent = '20,000,000';
    filterVehicles();
}

function filterByCategory(category) {
    // Remove active class from all buttons
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));

    // Add active class to clicked button
    event.target.classList.add('active');

    const cards = document.querySelectorAll('.vehicle-card');
    let visibleCount = 0;

    cards.forEach(card => {
        if (category === 'all' || card.dataset.category === category) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('results-count').textContent = `${visibleCount} vehicles found`;
}

function updateResults() {
    // Handle show dropdown change
    filterVehicles();
}
</script>

<style>
.vehicles-page {
    background-color: #f8f9fa;
    min-height: 100vh;
    padding: 70px 20px;
    margin-bottom: 70px;
}

.header-section {
    background: white;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.top-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.show-dropdown {
    display: flex;
    align-items: center;
    gap: 10px;
}

.show-dropdown label {
    font-weight: 500;
    color: black;
}

.show-select, .filter-select {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: white;
}

.search-container {
    display: flex;
    align-items: center;
    position: relative;
}

.search-input {
    padding: 8px 40px 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 300px;
    outline: none;
}

.search-btn {
    position: absolute;
    right: 8px;
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
}

.filters-row {
    display: grid;
    grid-template-columns: 1fr 1fr 2fr;
    gap: 20px;
    margin-bottom: 20px;
}

.filter-group label {
    display: block;
    font-weight: 500;
    color: black;
    margin-bottom: 5px;
}

.price-range {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.price-label {
    font-size: 14px;
    color: #666;
    min-width: 120px;
}

.price-slider {
    width: 100%;
    height: 4px;
    border-radius: 2px;
    background: #ddd;
    outline: none;
    appearance: none;
    flex: 1;
}

.price-slider::-webkit-slider-thumb {
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: red;
    cursor: pointer;
}

.clear-filters-btn {
    color: red;
    background: none;
    border: none;
    cursor: pointer;
    text-decoration: underline;
    font-size: 14px;
}

.category-filters {
    display: flex;
    gap: 10px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.filter-btn {
    padding: 8px 16px;
    background: #f8f9fa;
    color: black;
    text-decoration: none;
    border-radius: 20px;
    font-weight: 500;
    transition: all 0.3s;
    border: 1px solid #ddd;
}

.filter-btn:hover, .filter-btn.active {
    background: red;
    color: white;
    border-color: red;
}

.results-info {
    background: white;
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.vehicles-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.vehicle-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}

.vehicle-card:hover {
    transform: translateY(-2px);
}

.image-section {
    position: relative;
    height: 240px;
    overflow: hidden;
}

.image-section img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #f8f9fa;
}

.price-mileage-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: yellow;
    color: black;
    padding: 6px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 600;
}

.verified-badge {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: red;
    color: white;
    padding: 4px 8px;
    border-radius: 15px;
    font-size: 10px;
    font-weight: 600;
}

.card-content {
    padding: 16px;
}

.vehicle-title {
    font-size: 18px;
    font-weight: 700;
    color: black;
    margin-bottom: 8px;
}

.vehicle-specs {
    color: #666;
    font-size: 13px;
    line-height: 1.4;
    margin-bottom: 12px;
}

.dealer-info {
    background: #fff3cd;
    color: #856404;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    display: inline-block;
    margin-bottom: 16px;
}

.action-buttons {
    display: flex;
    gap: 8px;
}

.view-btn {
    background: red;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
}

.view-btn:hover {
    background: #cc0000;
}

.report-btn {
    background: black;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
    white-space: nowrap;
}

.report-btn:hover {
    background: #333;
}

.no-vehicles {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    color: #666;
    background: white;
    border-radius: 8px;
}

@media (max-width: 768px) {
    .vehicles-page {
        padding: 70px 15px;
    }

    .top-controls {
        flex-direction: column;
        gap: 15px;
    }

    .search-input {
        width: 100%;
    }

    .filters-row {
        grid-template-columns: 1fr;
    }

    .vehicles-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .vehicles-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
