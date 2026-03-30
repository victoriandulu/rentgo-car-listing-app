@extends('layouts.dashboard')

@section('dashboard-content')

<div class="ml-wrap">

    {{-- Page Header --}}
    <div class="ml-hero">
        <div class="ml-hero-inner">
            <div class="ml-trust-badge">
                <span class="ml-dot"></span> YOUR LISTINGS
            </div>
            <h1 class="ml-headline">My Listed <em>Cars.</em></h1>
            <p class="ml-sub">Manage your listings, track performance, and reach verified buyers.</p>
        </div>
        <a href="{{ route('cars.create') }}" class="ml-btn-new">+ List a New Car</a>
    </div>

    @if(session('success'))
        <div class="ml-success">{{ session('success') }}</div>
    @endif

    @if($cars->isEmpty())
        <div class="ml-empty">
            <div class="ml-empty-icon">🚗</div>
            <h3>No cars listed yet</h3>
            <p>You haven't listed any cars yet. <a href="{{ route('cars.create') }}">List your first car</a> and start reaching verified buyers today.</p>
        </div>
    @else
        <div class="ml-grid">
            @foreach($cars as $car)
                <div class="ml-card">
                    <div class="ml-img-wrap">
                        <img
                            src="{{ $car->image ? asset('storage/' . $car->image) : 'https://placehold.co/600x400?text=Car' }}"
                            alt="{{ $car->name }}"
                        >
                        <span class="ml-car-name">{{ $car->name }}</span>
                        <span class="ml-avail-badge {{ ($car->availability ?? '') === 'Available' ? 'available' : 'unavailable' }}">
                            {{ $car->availability ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="ml-details">
                        <div class="ml-top-row">
                            <span class="ml-year-badge">{{ $car->year ?? 'N/A' }}</span>
                            <span class="ml-price">Ksh {{ number_format($car->price ?? 0) }}</span>
                        </div>
                        <h3 class="ml-name">{{ $car->name }}</h3>
                        <p class="ml-spec">{{ $car->engine_size ?? 'N/A' }} cc &nbsp;·&nbsp; {{ $car->transmission ?? 'N/A' }}</p>
                        <p class="ml-dealer">{{ $car->source ?? 'Dealer Unknown' }}</p>
                        <div class="ml-actions">
                            <a href="{{ route('cars.edit', $car) }}" class="ml-btn ml-btn-edit">Edit</a>
                            <form action="{{ route('cars.destroy', $car) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this car?');" style="display:contents">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-btn ml-btn-delete">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=DM+Sans:wght@400;500;600&display=swap');

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.ml-wrap {
    min-height: 100vh;
    background: #fdf6ee;
    font-family: 'DM Sans', sans-serif;
    color: #1f1a14;
    padding: 48px 40px 80px;
}

@media (max-width: 640px) {
    .ml-wrap { padding: 32px 20px 60px; }
}

/* ── Page Hero ── */
.ml-hero {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 24px;
    margin-bottom: 40px;
    padding-bottom: 32px;
    border-bottom: 1px solid #e8ddd0;
}

.ml-trust-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: white;
    border: 1px solid #e8ddd0;
    border-radius: 100px;
    padding: 6px 14px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: #6b5c4e;
    margin-bottom: 14px;
    width: fit-content;
}

.ml-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #ef4444;
    display: inline-block;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.3); }
}

.ml-headline {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 2.8rem);
    font-weight: 700;
    color: #1f1a14;
    line-height: 1.15;
    margin-bottom: 8px;
}
.ml-headline em { font-style: italic; color: #ef4444; }

.ml-sub { font-size: 0.95rem; color: #9c8878; }

.ml-btn-new {
    display: inline-flex;
    align-items: center;
    padding: 13px 24px;
    background: #ef4444;
    color: white;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s;
    white-space: nowrap;
    font-family: 'DM Sans', sans-serif;
}
.ml-btn-new:hover { background: #dc2626; transform: translateY(-1px); }

/* ── Success ── */
.ml-success {
    background: #ecfdf5;
    border: 1.5px solid #6ee7b7;
    color: #065f46;
    border-radius: 10px;
    padding: 14px 18px;
    font-weight: 500;
    margin-bottom: 28px;
    font-size: 0.95rem;
}

/* ── Empty State ── */
.ml-empty {
    text-align: center;
    background: white;
    border: 1px solid #e8ddd0;
    border-radius: 16px;
    padding: 80px 40px;
}
.ml-empty-icon { font-size: 3rem; margin-bottom: 16px; }
.ml-empty h3 { font-family: 'Playfair Display', serif; font-size: 1.5rem; margin-bottom: 10px; }
.ml-empty p { font-size: 0.95rem; color: #9c8878; }
.ml-empty a { color: #ef4444; font-weight: 600; text-decoration: none; }
.ml-empty a:hover { text-decoration: underline; }

/* ── Grid ── */
.ml-grid {
    display: grid;
    gap: 28px;
    grid-template-columns: repeat(1, 1fr);
}
@media (min-width: 640px)  { .ml-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1100px) { .ml-grid { grid-template-columns: repeat(3, 1fr); } }

/* ── Card ── */
.ml-card {
    background: white;
    border: 1px solid #e8ddd0;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s, box-shadow 0.2s;
}
.ml-card:hover { transform: translateY(-5px); box-shadow: 0 12px 32px rgba(31,26,20,0.1); }

/* ── Card Image ── */
.ml-img-wrap {
    position: relative;
    width: 100%;
    height: 220px;
    background: #fdf6ee;
    overflow: hidden;
}
.ml-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s;
}
.ml-card:hover .ml-img-wrap img { transform: scale(1.04); }

.ml-car-name {
    position: absolute;
    bottom: 12px; left: 12px;
    background: rgba(31,26,20,0.78);
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.95rem;
    font-weight: 600;
    backdrop-filter: blur(6px);
}

.ml-avail-badge {
    position: absolute;
    top: 12px; right: 12px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.05em;
}
.ml-avail-badge.available { background: #ecfdf5; color: #065f46; border: 1px solid #6ee7b7; }
.ml-avail-badge.unavailable { background: #fff1f1; color: #991b1b; border: 1px solid #fca5a5; }

/* ── Card Details ── */
.ml-details {
    padding: 20px 22px 22px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex-grow: 1;
}

.ml-top-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.ml-year-badge {
    background: #fdf6ee;
    border: 1px solid #e8ddd0;
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 0.85rem;
    font-weight: 700;
    color: #4a3f35;
}

.ml-price {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem;
    font-weight: 700;
    color: #ef4444;
}

.ml-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f1a14;
    margin-top: 2px;
}

.ml-spec {
    font-size: 0.88rem;
    color: #6b5c4e;
}

.ml-dealer {
    font-size: 0.88rem;
    color: #ef4444;
    font-weight: 500;
}

/* ── Actions ── */
.ml-actions {
    display: flex;
    gap: 10px;
    margin-top: auto;
    padding-top: 14px;
}

.ml-btn {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    font-family: 'DM Sans', sans-serif;
    transition: opacity 0.2s, transform 0.15s;
    display: inline-block;
}
.ml-btn:hover { opacity: 0.88; transform: translateY(-1px); }

.ml-btn-edit {
    background: #1f1a14;
    color: white;
}

.ml-btn-delete {
    background: #ef4444;
    color: white;
    width: 100%;
}
</style>

@endsection
