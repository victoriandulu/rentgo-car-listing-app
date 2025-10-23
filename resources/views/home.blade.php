@extends('layouts.app')

@section('content')
<div class="home-container">

    {{-- Hero Section with Watermark --}}
    <div class="hero-section">
        {{-- Watermark Background --}}
        <div class="hero-watermark">
            <span>Rent</span>
            <span>Go</span>
        </div>

        {{-- Hero Content --}}
        <div class="hero-content">
            <h1>The safest Way to <span class="highlight">Buy and Sell</span> Your Car in Kenya</h1>

            <div class="hero-buttons">
                <a href="{{ url('/vehicles') }}" class="btn-primary">Explore Vehicles</a>

                @auth
                    <a href="{{ route('cars.create') }}" class="btn-secondary">Sell Your Car</a>
                @endauth
                @guest
                    <a href="{{ url('/sell') }}" class="btn-secondary">Sell Your Car</a>
                @endguest
            </div>

            <div class="scroll-indicator">
                <span>Scroll down</span>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M10 4v12m0 0l-4-4m4 4l4-4" stroke="currentColor" stroke-width="1.5"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Car Showcase --}}
    <div class="car-showcase">
        <img src="{{ asset('images/gwagon.png') }}" alt="Featured Vehicle" class="showcase-car" />
    </div>

    {{-- Search Section --}}
    <div class="search-section">
        <form action="{{ route('search.vehicle') }}" method="GET" class="search-form">
            <input
                type="text"
                name="query"
                id="search-input"
                placeholder="Search vehicle name"
                class="search-input"
            />
            <button type="submit" class="search-button">Search Vehicle</button>
        </form>
    </div>

    {{-- Price Filters --}}
    <div class="filters-section">
        <div class="filter-grid">
            <button class="filter-btn" data-min="0" data-max="500000">0 - 500K</button>
            <button class="filter-btn" data-min="500000" data-max="1000000">500K - 1M</button>
            <button class="filter-btn" data-min="1000000" data-max="2000000">1M - 2M</button>
            <button class="filter-btn" data-min="2000000" data-max="3000000">2M - 3M</button>
            <button class="filter-btn" data-min="3000000" data-max="5000000">3M - 5M</button>
            <button class="filter-btn" data-min="5000000" data-max="10000000">5M - 10M</button>
            <button class="filter-btn" data-min="10000000" data-max="999999999">Above 10M</button>
        </div>

        <div class="filter-secondary">
            <div class="filter-dropdown">
                <select id="brand-filter" class="filter-select">
                    <option value="">Filter by Brand</option>
                    <option value="toyota">Toyota</option>
                    <option value="honda">Honda</option>
                    <option value="nissan">Nissan</option>
                    <option value="mazda">Mazda</option>
                    <option value="subaru">Subaru</option>
                    <option value="mercedes">Mercedes-Benz</option>
                    <option value="bmw">BMW</option>
                </select>
            </div>
            <div class="filter-dropdown">
                <select id="body-filter" class="filter-select">
                    <option value="">Filter by Body Type</option>
                    <option value="suv">SUV</option>
                    <option value="sedan">Sedan</option>
                    <option value="hatchback">Hatchback</option>
                    <option value="pickup">Pickup</option>
                    <option value="van">Van</option>
                    <option value="coupe">Coupe</option>
                </select>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Price filter buttons
    const filterButtons = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('search-input');
    const brandFilter = document.getElementById('brand-filter');
    const bodyFilter = document.getElementById('body-filter');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const minPrice = this.dataset.min;
            const maxPrice = this.dataset.max;

            // Redirect to vehicles page with price filter
            window.location.href = `{{ url('/vehicles') }}?min_price=${minPrice}&max_price=${maxPrice}`;
        });
    });

    // Brand filter
    brandFilter.addEventListener('change', function() {
        if (this.value) {
            window.location.href = `{{ url('/vehicles') }}?make=${this.value}`;
        }
    });

    // Body type filter
    bodyFilter.addEventListener('change', function() {
        if (this.value) {
            window.location.href = `{{ url('/vehicles') }}?body_type=${this.value}`;
        }
    });
});
</script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.home-container {
    background: #ffffff;
}

/* Hero Section */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    padding: 2rem;
    overflow: hidden;
}

/* Watermark - Fixed positioning */
.hero-watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: clamp(8rem, 20vw, 16rem);
    font-weight: 900;
    color: rgba(0, 0, 0, 0.05);
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

/* Hero Content */
.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 900px;
    width: 100%;
}

.hero-content h1 {
    font-size: 54px;
    font-weight: 400;
    font-style: italic;
    line-height: 1.2;
    color: #000000;
    margin-bottom: 2.5rem;
}

.hero-content h1 .highlight {
    font-weight: 700;

}

/* Hero Buttons */
.hero-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.btn-primary,
.btn-secondary {
    padding: 1rem 2rem;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    text-decoration: none;
    display: inline-block;
}

.btn-primary {
    background: black;
    color: #ffffff;
}

.btn-primary:hover {
    background: #cc0000;
    transform: translateY(-2px);
}

.btn-secondary {
    background: white;
    color: #000000;
}

.btn-secondary:hover {
    background: #fdd835;
    transform: translateY(-2px);
}

/* Scroll Indicator */
.scroll-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: #666;
    font-size: 0.875rem;
}

.scroll-indicator svg {
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(8px); }
}

/* Car Showcase */
.car-showcase {
    width: 100%;
    padding: 3rem 2rem;

    display: flex;
    justify-content: center;
    align-items: center;
}

.showcase-car {
    width: 100%;
    max-width: 1200px;
    height: auto;
    animation: carFloat 4s ease-in-out infinite;
    filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.1));
}

@keyframes carFloat {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* Search Section */
.search-section {
    padding: 3rem 2rem;
    background: #f5f5f5;
    display: flex;
    justify-content: center;
}

.search-form {
    display: flex;
    gap: 1rem;
    width: 100%;
    max-width: 600px;
}

.search-input {
    flex: 1;
    padding: 1rem 1.5rem;
    border: 2px solid #ddd;
    font-size: 1rem;
    outline: none;
    transition: border-color 0.3s;
}

.search-input:focus {
    border-color: #ff0000;
}

.search-button {
    padding: 1rem 2rem;
    background: #ff0000;
    color: #ffffff;
    border: none;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
    white-space: nowrap;
}

.search-button:hover {
    background: #cc0000;
}

/* Filters Section */
.filters-section {
    padding: 3rem 2rem 5rem;
    background: #ffffff;
}

.filter-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    margin-bottom: 2rem;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}

.filter-btn {
    padding: 0.875rem 1.5rem;
    background: #ffffff;
    color: #000000;
    border: 2px solid #ff0000;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    min-width: 130px;
}

.filter-btn:hover {
    background: #ff0000;
    color: #ffffff;
}

.filter-secondary {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    max-width: 600px;
    margin: 0 auto;
}

.filter-dropdown {
    flex: 1;
    min-width: 200px;
}

.filter-select {
    width: 100%;
    padding: 0.875rem 1.5rem;
    background: #ffeb3b;
    color: #000000;
    border: none;
    font-size: 0.9375rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
}

.filter-select:hover {
    background: #fdd835;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section {
    min-height: 50vh;
    padding: 1.8rem 1rem 2.5rem; /* extra bottom padding to push buttons lower */
    margin-bottom: 0;
    display: flex;
    flex-direction: column;
    justify-content: flex-end; /* positions content toward the bottom */
}

.hero-watermark {
    font-size: clamp(6rem, 15vw, 10rem);
    margin-block-start: 0;
}

.hero-content h1 {
    font-size: 52px;
    margin-bottom: 1rem;
}

.hero-buttons {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 280px;
    margin: 3rem auto 1rem; /* moves buttons farther down */
    gap: 8px;
}

/* ✅ Maintain breathing space below last button */
.hero-buttons .btn-secondary:last-child {
    margin-top: 26px;
}

.btn-primary,
.btn-secondary {
    width: 100%;
}

/* ✅ Pull the car showcase closer to the hero */
.car-showcase {
    padding: 0.8rem 1rem;
    margin-top: -30px; /* negative margin lifts the section upward */
}

    .search-form {
        flex-direction: column;
    }

    .search-button {
        width: 100%;
    }

    .filter-grid {
        flex-direction: column;
        align-items: stretch;
        max-width: 280px;
    }

    .filter-btn {
        width: 100%;
    }

    .filter-secondary {
        flex-direction: column;
        max-width: 280px;
    }

    .filter-dropdown {
        width: 100%;
        min-width: unset;
    }
}

@media (max-width: 480px) {
    .hero-content h1 {
        font-size: 1.5rem;
    }

    .btn-primary,
    .btn-secondary {
        padding: 0.875rem 1.5rem;
        font-size: 0.9375rem;
    }
}
</style>
@endsection
