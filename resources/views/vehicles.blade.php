@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Header with filters --}}
    <header class="header">
    <div class="filters">
        <a href="{{ route('vehicles', ['category' => 'All Vehicles']) }}"
           class="{{ ($category ?? '') === 'All Vehicles' ? 'active' : '' }}">
            All Vehicles
        </a>

        <a href="{{ route('vehicles', ['category' => 'Vehicles in Kenya']) }}"
           class="{{ ($category ?? '') === 'Vehicles in Kenya' ? 'active' : '' }}">
            Vehicles in Kenya
        </a>

        <a href="{{ route('vehicles', ['category' => 'Imports']) }}"
           class="{{ ($category ?? '') === 'Imports' ? 'active' : '' }}">
            Imports
        </a>
    </div>

    <div class="info">
        <span>Showing {{ $cars->count() }} vehicles</span>
        <a href="{{ route('vehicles', ['category' => 'All Vehicles']) }}" class="clear">Clear Filters</a>
    </div>
</header>

<style>
/* Header container */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 16px; /* compact */
    margin-bottom: 20px;
    background: #ffffff;
    border: 1px solid #e5e7eb; /* subtle border */
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05); /* light professional shadow */
}

/* Filter links */
.filters a {
    margin-right: 8px;
    padding: 6px 12px;
    font-size: 0.85rem;
    font-weight: 500;
    color: #374151;
    text-decoration: none;
    border-radius: 16px;
    transition: all 0.2s ease;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
}
.filters a:last-child { margin-right: 0; }

/* Active filter */
.filters a.active {
    background: #facc15;
    color: #7f1d1d;
    border-color: #facc15;
}

/* Hover */
.filters a:hover {
    background: #fef3c7;
    color: #b91c1c;
}

/* Info section */
.info {
    font-size: 0.8rem;
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 12px;
}
.info .clear {
    font-size: 0.8rem;
    color: #ef4444;
    text-decoration: none;
    font-weight: 500;
}
.info .clear:hover {
    text-decoration: underline;
}
</style>

    {{-- Vehicles grid --}}
    <main class="grid">
        @forelse($cars as $car)
            <div class="card">
                <div class="image-container">
                    {{-- Availability Badge --}}
                    <span class="badge {{ strtolower($car->availability) === 'available' ? 'available' : 'unavailable' }}">
                        {{ ucfirst($car->availability ?? 'Unavailable') }}
                    </span>

                    <img src="{{ $car->image ? asset('storage/' . $car->image) : 'https://via.placeholder.com/400x250' }}"
                         alt="{{ $car->name }}">
                </div>

                <div class="details">
                    {{-- Car title --}}
                    <h3>{{ $car->name }} ({{ $car->year ?? 'N/A' }})</h3>

                    {{-- Specs as a paragraph --}}
                    <p class="specs">
                        <strong>Engine Size:</strong> {{ $car->engine_size ?? 'N/A' }} cc,
                        <strong>Mileage:</strong> {{ $car->mileage ?? 'N/A' }} km,
                        <strong>Fuel:</strong> {{ $car->fuel_type ?? 'N/A' }},
                        <strong>Drive:</strong> {{ $car->drive ?? 'N/A' }}
                    </p>

                    {{-- Dealer / Source as badge --}}
                    @if(!empty($car->source))
                        <span class="dealer-badge">
                            Dealer / Source: {{ $car->source }}
                        </span>
                    @else
                        <span class="dealer-badge unknown">
                            Dealer / Source: Not Provided
                        </span>
                    @endif

                    {{-- Short description --}}
                    <p class="description">
                        {{ Str::limit(strip_tags($car->description), 200, '...') }}
                    </p>

                    {{-- Actions --}}
                    <div class="actions">
                        {{-- View more button --}}
                        <button type="button" class="view-btn" onclick="toggleDetails({{ $car->id }}, this)">
                            View
                        </button>

                        {{-- Buy Report --}}
                        <form action="{{ route('vehicles.buyReport', $car->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="buy-report-btn">
                                Buy Report (Ksh {{ number_format($car->report_price ?? 500, 2) }})
                            </button>
                        </form>
                    </div>

                    {{-- Hidden extra details --}}
                    <div id="details-{{ $car->id }}" class="extra-details hidden">
                        <p>{{ $car->description }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-600">No vehicles available at the moment.</p>
        @endforelse
    </main>

</div>

{{-- Scripts --}}
<script>
function toggleDetails(carId, btn) {
    const details = document.getElementById(`details-${carId}`);
    details.classList.toggle('hidden');
    btn.textContent = details.classList.contains('hidden') ? 'View' : 'Hide';
}
</script>

{{-- Inline styles --}}
<style>
.grid {
    display: grid;
    gap: 32px;
    grid-template-columns: repeat(1, 1fr);
}
@media (min-width: 640px) { .grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .grid { grid-template-columns: repeat(3, 1fr); } }

.card {
    background: #fffbea;
    border: 2px solid #facc15;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.15);
}
.image-container {
    position: relative;
    width: 100%;
    height: 250px;
    overflow: hidden;
    background: #fef9c3;
}
.image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Availability Badge */
.badge {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 10;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
    color: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.25);
    text-transform: uppercase;
}
.badge.available {
    background: linear-gradient(90deg, #22c55e, #facc15, #ef4444);
}
.badge.unavailable {
    background: linear-gradient(90deg, #ef4444, #facc15);
}

.details {
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.specs {
    font-size: 0.9rem;
    color: #991b1b;
    line-height: 1.5;
}
.dealer-badge {
    display: inline-block;
    margin-top: 4px;
    padding: 6px 12px;
    border-radius: 16px;
    font-size: 0.85rem;
    font-weight: 600;
    background: #fff1f2;
    color: #b91c1c;
}
.dealer-badge.unknown {
    background: #fef3c7;
    color: #92400e;
}
.description {
    color: #78350f;
    font-size: 0.9rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.actions {
    margin-top: 10px;
    display: flex;
    gap: 10px;
    align-items: center;
}

.view-btn {
    padding: 8px 12px;
    background: #facc15;
    color: #991b1b;
    font-weight: 700;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
}
.view-btn:hover { background: #eab308; color: #7f1d1d; }

.buy-report-btn {
    padding: 8px 12px;
    background: #ef4444;
    color: #fff;
    font-weight: 700;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s;
}
.buy-report-btn:hover { background: #b91c1c; }

.extra-details {
    margin-top: 12px;
    padding: 10px;
    border-top: 2px solid #facc15;
    background: #fffde7;
    color: #44403c;
}
.hidden { display: none; }
</style>
@endsection
