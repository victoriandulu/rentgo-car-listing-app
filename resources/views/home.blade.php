@extends('layouts.app')

@section('content')
<div class="home-container">
    {{-- Hero Section --}}
    <div class="hero-section">
        <div class="hero-watermark">
            <span>Rent</span>
            <span>Go</span>
        </div>

        <div class="hero-content">
            <h1>The Safest Way to <span class="highlight">Buy and Sell</span> Your Car in Kenya</h1>
            <p class="hero-subtitle">Find what fits you</p>
            <p class="hero-description">We help you find a car that fits your personality, dream, and pocket!</p>

            <div class="hero-buttons">
                <a href="{{ url('/vehicles') }}" class="btn-primary">Explore Vehicles</a>
                @auth
                    <a href="{{ route('cars.create') }}" class="btn-secondary">Sell Your Car</a>
                @endauth
                @guest
                    <a href="{{ url('/sell') }}" class="btn-secondary">Sell Your Car</a>
                @endguest
            </div>
        </div>
    </div>

    {{-- Car Showcase --}}
    <div class="car-showcase">
        <img src="{{ asset('images/gwagon.png') }}" alt="Featured Vehicle" class="showcase-car" />
    </div>

    {{-- Search Section --}}
    <div class="search-section">
        <div class="section-container">
            <h2 class="section-title">Find Your Perfect Vehicle</h2>
            <form action="{{ route('search.vehicle') }}" method="GET" class="search-form">
                <input
                    type="text"
                    name="query"
                    id="search-input"
                    placeholder="Search by make, model, or keyword..."
                    class="search-input"
                    required
                />
                <button type="submit" class="search-button">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    Search
                </button>
            </form>
        </div>
    </div>

    {{-- Filters Section --}}
    <div class="filters-section">
        <div class="section-container">
            <h2 class="section-title">Quick Filters</h2>

            {{-- Price Range Filters --}}
            <div class="filter-category">
                <h3 class="filter-label">Filter by Price Range</h3>
                <div class="filter-grid">
                    <button class="filter-btn" onclick="filterByPrice(0, 500000)">
                        <span class="filter-text">0 - 500K</span>
                    </button>
                    <button class="filter-btn" onclick="filterByPrice(500000, 1000000)">
                        <span class="filter-text">500K - 1M</span>
                    </button>
                    <button class="filter-btn" onclick="filterByPrice(1000000, 2000000)">
                        <span class="filter-text">1M - 2M</span>
                    </button>
                    <button class="filter-btn" onclick="filterByPrice(2000000, 3000000)">
                        <span class="filter-text">2M - 3M</span>
                    </button>
                    <button class="filter-btn" onclick="filterByPrice(3000000, 5000000)">
                        <span class="filter-text">3M - 5M</span>
                    </button>
                    <button class="filter-btn" onclick="filterByPrice(5000000, 10000000)">
                        <span class="filter-text">5M - 10M</span>
                    </button>
                    <button class="filter-btn" onclick="filterByPrice(10000000, 999999999)">
                        <span class="filter-text">Above 10M</span>
                    </button>
                </div>
            </div>

            {{-- Brand and Body Type Filters --}}
            <div class="filter-secondary">
                <div class="filter-category">
                    <h3 class="filter-label">Filter by Brand</h3>
                    <select id="brand-filter" class="filter-select" onchange="filterByBrand(this.value)">
                        <option value="">All Brands</option>
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

                <div class="filter-category">
                    <h3 class="filter-label">Filter by Body Type</h3>
                    <select id="body-filter" class="filter-select" onchange="filterByBodyType(this.value)">
                        <option value="">All Body Types</option>
                        <option value="suv">SUV</option>
                        <option value="sedan">Sedan</option>
                        <option value="hatchback">Hatchback</option>
                        <option value="pickup">Pickup</option>
                        <option value="van">Van</option>
                        <option value="coupe">Coupe</option>
                        <option value="wagon">Wagon</option>
                        <option value="convertible">Convertible</option>
                    </select>
                </div>
            </div>

            <div class="cta-section">
                <a href="{{ url('/vehicles') }}" class="btn-view-all">View All Vehicles</a>
            </div>
        </div>
    </div>
</div>

<script>
function filterByPrice(minPrice, maxPrice) {
    window.location.href = `{{ url('/vehicles') }}?price_min=${minPrice}&price_max=${maxPrice}`;
}

function filterByBrand(brand) {
    if (brand) {
        window.location.href = `{{ url('/vehicles') }}?make=${brand}`;
    }
}

function filterByBodyType(bodyType) {
    if (bodyType) {
        window.location.href = `{{ url('/vehicles') }}?body_type=${bodyType}`;
    }
}

// Search form enhancement
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('.search-form');
    const searchInput = document.getElementById('search-input');

    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            if (searchInput.value.trim() === '') {
                e.preventDefault();
                searchInput.focus();
            }
        });
    }
});
</script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --primary: #1a1a1a;
    --secondary: #d32f2f;
    --text-dark: #1a1a1a;
    --text-medium: #4a5568;
    --text-light: #718096;
    --border: #e2e8f0;
    --bg-light: #f7fafc;
    --bg-white: #ffffff;
    --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    color: var(--text-dark);
    line-height: 1.6;
}

.home-container {
    background: var(--bg-white);
    width: 100%;
    overflow-x: hidden;
}

/* Hero Section */
.hero-section {
    min-height: 65vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(to bottom, var(--bg-white) 0%, var(--bg-light) 100%);
    padding: 60px 24px 40px;
    position: relative;
    overflow: hidden;
}

.hero-watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: clamp(8rem, 20vw, 16rem);
    font-weight: 900;
    color: rgba(0, 0, 0, 0.03);
    text-transform: uppercase;
    letter-spacing: -0.02em;
    line-height: 0.9;
    pointer-events: none;
    user-select: none;
    z-index: 1;
    text-align: center;
    white-space: nowrap;
}

.hero-watermark span {
    display: block;
}

.hero-content {
    text-align: center;
    max-width: 900px;
    width: 100%;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

.hero-content h1 {
    font-size: clamp(32px, 5vw, 56px);
    font-weight: 300;
    line-height: 1.2;
    color: var(--text-dark);
    margin-bottom: 20px;
    letter-spacing: -0.5px;
}

.hero-content h1 .highlight {
    font-weight: 700;
    color: var(--primary);
}

.hero-subtitle {
    font-size: clamp(18px, 2.5vw, 24px);
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.hero-description {
    font-size: clamp(16px, 2vw, 18px);
    color: var(--text-medium);
    margin-bottom: 32px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.hero-buttons {
    display: flex;
    gap: 16px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.btn-primary,
.btn-secondary {
    padding: 16px 32px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    text-decoration: none;
    display: inline-block;
    border-radius: 6px;
}

.btn-primary {
    background: var(--primary);
    color: var(--bg-white);
    border-color: var(--primary);
}

.btn-primary:hover {
    background: transparent;
    color: var(--primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.btn-secondary {
    background: var(--bg-white);
    color: var(--primary);
    border-color: var(--primary);
}

.btn-secondary:hover {
    background: var(--primary);
    color: var(--bg-white);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Car Showcase */
.car-showcase {
    width: 100%;
    padding: 20px 24px 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: var(--bg-white);
    margin-top: -20px;
}

.showcase-car {
    width: 100%;
    max-width: 1200px;
    height: auto;
    filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.08));
}

/* Search Section */
.search-section {
    padding: 50px 24px;
    background: var(--bg-light);
}

.section-container {
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

.section-title {
    font-size: clamp(28px, 4vw, 36px);
    font-weight: 600;
    color: var(--text-dark);
    text-align: center;
    margin-bottom: 32px;
    letter-spacing: -0.5px;
}

.search-form {
    display: flex;
    gap: 12px;
    width: 100%;
    max-width: 700px;
    margin: 0 auto;
}

.search-input {
    flex: 1;
    padding: 16px 20px;
    border: 2px solid var(--border);
    font-size: 16px;
    outline: none;
    transition: border-color 0.3s, box-shadow 0.3s;
    border-radius: 6px;
    background: var(--bg-white);
}

.search-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
}

.search-button {
    padding: 16px 28px;
    background: var(--primary);
    color: var(--bg-white);
    border: none;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    white-space: nowrap;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.search-button:hover {
    background: var(--text-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Filters Section */
.filters-section {
    padding: 50px 24px;
    background: var(--bg-white);
}

.filter-category {
    margin-bottom: 40px;
}

.filter-label {
    font-size: clamp(16px, 2vw, 18px);
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 16px;
    text-align: center;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 12px;
    max-width: 1100px;
    margin: 0 auto;
}

.filter-btn {
    padding: 14px 16px;
    background: var(--bg-white);
    color: var(--text-dark);
    border: 2px solid var(--border);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    border-radius: 6px;
    text-align: center;
    white-space: nowrap;
    min-height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.filter-text {
    display: block;
}

.filter-btn:hover {
    background: var(--primary);
    color: var(--bg-white);
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.filter-secondary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    max-width: 800px;
    margin: 0 auto;
}

.filter-select {
    width: 100%;
    padding: 14px 20px;
    background: var(--bg-white);
    color: var(--text-dark);
    border: 2px solid var(--border);
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    border-radius: 6px;
    outline: none;
}

.filter-select:hover,
.filter-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
}

.cta-section {
    text-align: center;
    margin-top: 48px;
}

.btn-view-all {
    display: inline-block;
    padding: 16px 40px;
    background: var(--primary);
    color: var(--bg-white);
    border: 2px solid var(--primary);
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.3s;
}

.btn-view-all:hover {
    background: transparent;
    color: var(--primary);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

/* Responsive Design */

/* iPad Air & Similar (820px - 1024px) */
@media (min-width: 768px) and (max-width: 1024px) {
    .hero-section {
        padding: 50px 32px 30px;
        min-height: 60vh;
    }

    .hero-watermark {
        font-size: clamp(10rem, 18vw, 14rem);
    }

    .car-showcase {
        padding: 10px 32px 30px;
        margin-top: -10px;
    }

    .filter-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        max-width: 750px;
    }

    .filter-btn {
        padding: 16px 12px;
        font-size: 13px;
        min-height: 52px;
    }

    .filter-secondary {
        grid-template-columns: repeat(2, 1fr);
        max-width: 750px;
        gap: 20px;
    }

    .search-form {
        max-width: 650px;
    }

    .search-section {
        padding: 40px 32px;
    }

    .filters-section {
        padding: 40px 32px;
    }
}

/* Tablets (768px - 1024px) */
@media (max-width: 1024px) {
    .hero-section {
        padding: 50px 20px 30px;
        min-height: 60vh;
    }

    .car-showcase {
        padding: 10px 20px 30px;
    }
}

/* Tablets Portrait (768px - 991px) */
@media (max-width: 991px) {
    .hero-buttons {
        gap: 12px;
    }

    .btn-primary,
    .btn-secondary {
        padding: 14px 28px;
        font-size: 15px;
    }

    .filter-secondary {
        grid-template-columns: 1fr;
        max-width: 500px;
    }
}

/* Mobile Landscape & Small Tablets (640px - 767px) */
@media (max-width: 767px) {
    .hero-section {
        padding: 40px 20px 30px;
        min-height: 55vh;
    }

    .hero-watermark {
        display: none;
    }

    .hero-content h1 {
        margin-bottom: 16px;
    }

    .hero-description {
        margin-bottom: 24px;
    }

    .search-section,
    .filters-section {
        padding: 35px 20px;
    }

    .car-showcase {
        padding: 10px 20px 30px;
        margin-top: -10px;
    }

    .section-title {
        margin-bottom: 24px;
    }

    .filter-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    .filter-btn {
        padding: 12px 10px;
        font-size: 13px;
        min-height: 46px;
    }

    .filter-category {
        margin-bottom: 32px;
    }

    .filter-secondary {
        grid-template-columns: 1fr;
    }
}

/* Mobile Portrait (480px - 639px) */
@media (max-width: 639px) {
    .hero-section {
        padding: 35px 16px 25px;
    }

    .hero-buttons {
        flex-direction: column;
        gap: 12px;
        width: 100%;
        max-width: 320px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-primary,
    .btn-secondary {
        width: 100%;
        padding: 14px 24px;
    }

    .car-showcase {
        padding: 10px 16px 25px;
    }

    .search-section,
    .filters-section {
        padding: 30px 16px;
    }

    .search-form {
        flex-direction: column;
        gap: 12px;
    }

    .search-button {
        width: 100%;
        justify-content: center;
    }

    .filter-grid {
        grid-template-columns: 1fr;
    }

    .filter-secondary {
        gap: 16px;
    }
}

/* Small Mobile (320px - 479px) */
@media (max-width: 479px) {
    .hero-section {
        padding: 30px 12px 20px;
        min-height: 55vh;
    }

    .hero-watermark {
        display: none;
    }

    .hero-content h1 {
        margin-bottom: 14px;
    }

    .hero-subtitle {
        margin-bottom: 8px;
    }

    .hero-description {
        margin-bottom: 20px;
    }

    .hero-buttons {
        gap: 10px;
        max-width: 280px;
    }

    .btn-primary,
    .btn-secondary {
        padding: 12px 20px;
        font-size: 14px;
    }

    .search-section,
    .filters-section {
        padding: 28px 12px;
    }

    .car-showcase {
        padding: 10px 12px 25px;
        margin-top: -5px;
    }

    .section-title {
        margin-bottom: 20px;
    }

    .filter-grid {
        grid-template-columns: 1fr;
    }

    .filter-btn {
        padding: 12px 16px;
        font-size: 14px;
        min-height: 48px;
    }

    .filter-select {
        padding: 12px 16px;
        font-size: 14px;
    }

    .filter-label {
        margin-bottom: 12px;
    }

    .btn-view-all {
        padding: 14px 32px;
        font-size: 15px;
    }
}

/* Large Desktops (1440px+) */
@media (min-width: 1440px) {
    .hero-section {
        padding: 70px 24px 50px;
    }

    .car-showcase {
        padding: 20px 24px 50px;
    }

    .section-container {
        max-width: 1400px;
    }

    .search-form {
        max-width: 800px;
    }

    .filter-grid {
        max-width: 1200px;
    }
}

/* Extra Large Screens (1920px+) */
@media (min-width: 1920px) {
    .section-container {
        max-width: 1600px;
    }

    .hero-content {
        max-width: 1100px;
    }

    .hero-section {
        padding: 80px 24px 60px;
    }

    .car-showcase {
        padding: 30px 24px 60px;
    }
}
</style>
@endsection
