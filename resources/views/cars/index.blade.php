@extends('layouts.dashboard')

@section('dashboard-content')
<style>
/* Container */
.my-cars-container {
    width: 100%;
    max-width: 1600px;
    margin: 40px auto 60px auto;
    padding: 0 16px; /* smaller padding on mobile */
}

/* Header */
.my-cars-header {
    margin-bottom: 32px;
}
.my-cars-header h2 {
    font-size: 2.2rem;
    margin: 0;
    color: #1f2937;
    font-weight: 700;
    text-align: center;
}

/* Grid layout */
.my-cars-grid {
    display: grid;
    gap: 24px;
    grid-template-columns: 1fr; /* full width on mobile */
}
@media (min-width: 640px) {
    .my-cars-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 28px;
    }
}
@media (min-width: 1024px) {
    .my-cars-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
    }
}

/* Card styles */
.my-car-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    border: 1px solid #e5e7eb;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.my-car-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.12);
}

/* Image */
.my-car-image-wrapper {
    width: 100%;
    padding-top: 56.25%; /* 16:9 aspect ratio */
    position: relative;
    background: #f9fafb;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.my-car-image-wrapper img {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transform: translate(-50%, -50%);
}
.my-car-name-label {
    position: absolute;
    bottom: 12px;
    left: 12px;
    background: rgba(0,0,0,0.6);
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
}

/* Card details */
.my-car-details {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex-grow: 1;
}
.my-car-top-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.my-car-badge {
    background: #facc15;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.85rem;
    color: #1f2937;
    font-weight: 600;
}
.my-car-price {
    font-size: 1.2rem;
    font-weight: 700;
    color: #ef4444;
}
.my-car-details h3 {
    margin: 4px 0;
    font-size: 1.2rem;
    color: #1f2937;
    font-weight: 600;
}
.my-car-details p {
    margin: 0;
    font-size: 0.95rem;
    color: #4b5563;
}
.my-car-dealer {
    color: #ef4444;
    font-weight: 500;
}

/* Actions */
.my-car-actions {
    margin-top: auto;
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.my-car-actions button {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 6px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s ease;
}
.my-car-actions button.edit {
    background: #3b82f6;
    color: #fff;
}
.my-car-actions button.edit:hover {
    background: #1d4ed8;
}
.my-car-actions button.delete {
    background: #ef4444;
    color: #fff;
}
.my-car-actions button.delete:hover {
    background: #b91c1c;
}

/* Success message */
.my-cars-success {
    margin-bottom: 24px;
    padding: 16px;
    background: #10b981;
    color: white;
    border-radius: 8px;
    font-weight: 500;
    text-align: center;
}

/* Empty state */
.my-cars-empty {
    padding: 60px 20px;
    text-align: center;
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}
.my-cars-empty p {
    font-size: 1.05rem;
    color: #6b7280;
}
.my-cars-empty a {
    color: #ef4444;
    font-weight: 600;
    text-decoration: none;
}
.my-cars-empty a:hover {
    text-decoration: underline;
}
</style>

<div class="my-cars-container">
    <div class="my-cars-header">
        <h2>📋 My Listed Cars</h2>
    </div>

    @if(session('success'))
        <div class="my-cars-success">
            {{ session('success') }}
        </div>
    @endif

    @if($cars->isEmpty())
        <div class="my-cars-empty">
            <p>
                You haven't listed any cars yet.
                <a href="{{ route('cars.create') }}">List your first car</a>.
            </p>
        </div>
    @else
        <div class="my-cars-grid">
            @foreach($cars as $car)
                <div class="my-car-card">
                    <div class="my-car-image-wrapper">
                        <img src="{{ $car->image ? asset('storage/' . $car->image) : 'https://placehold.co/600x400?text=Car' }}" alt="{{ $car->name }}">
                        <span class="my-car-name-label">{{ $car->name }}</span>
                    </div>
                    <div class="my-car-details">
                        <div class="my-car-top-row">
                            <span class="my-car-badge">{{ $car->year ?? 'N/A' }}</span>
                            <span class="my-car-price">Ksh {{ number_format($car->price ?? 0, 2) }}</span>
                        </div>
                        <h3>{{ $car->name }}</h3>
                        <p>{{ $car->engine_size ?? 'N/A' }}, {{ $car->transmission ?? 'N/A' }}</p>
                        <p class="my-car-dealer">{{ $car->source ?? 'Dealer Unknown' }}</p>
                        <div class="my-car-actions">
                            <a href="{{ route('cars.edit', $car) }}">
                                <button type="button" class="edit">Edit</button>
                            </a>
                            <form action="{{ route('cars.destroy', $car) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this car?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
