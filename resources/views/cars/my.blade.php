@extends('layouts.dashboard')

@section('dashboard-content')
<style>
.container {
    width: 100%;
    max-width: 1600px;
    margin: 40px auto 60px auto;
    padding: 0 32px;
}
.header { margin-bottom: 28px; }
h2 { font-size: 2.4rem; margin: 0; color: #1f2937; font-weight: bold; }

.grid { display: grid; gap: 32px; grid-template-columns: repeat(1, 1fr); }
@media (min-width: 640px) { .grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .grid { grid-template-columns: repeat(3, 1fr); } }

.card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover { transform: translateY(-6px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

.image-container {
    width: 100%;
    height: 300px;
    position: relative;
    overflow: hidden;
    background: #f9fafb;
}
.image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.image-container .car-name {
    position: absolute;
    bottom: 8px;
    left: 12px;
    background: rgba(0,0,0,0.6);
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 1.2rem;
    font-weight: 600;
}

.details {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex-grow: 1;
}
.top-row { display: flex; justify-content: space-between; align-items: center; }
.badge { background: #facc15; padding: 6px 12px; border-radius: 6px; font-size: 0.95rem; color: #1f2937; font-weight: bold; }
.price { font-size: 1.5rem; font-weight: bold; color: #ef4444; }
.details h3 { margin: 0; font-size: 1.3rem; color: #1f2937; font-weight: 600; }
.details p { margin: 0; font-size: 1rem; color: #4b5563; }
.dealer { color: #ef4444; font-weight: 500; }
.actions { margin-top: auto; display: flex; justify-content: space-between; gap: 14px; }
.details button {
    flex: 1;
    padding: 12px;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
}
.details button.edit { background: #3b82f6; color: #fff; }
.details button.edit:hover { background: #1d4ed8; }
.details button.delete { background: #ef4444; color: #fff; }
.details button.delete:hover { background: #b91c1c; }
</style>

<div class="container">
    <div class="header">
        <h2>📋 My Listed Cars</h2>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-500 text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($cars->isEmpty())
        <div class="card p-10 text-center">
            <p class="text-gray-600 text-lg">
                You haven’t listed any cars yet.
                <a href="{{ route('cars.create') }}" class="text-red-600 font-semibold">
                    List your first car
                </a>.
            </p>
        </div>
    @else
        <div class="grid">
            @foreach($cars as $car)
                <div class="card">
                    <div class="image-container">
                        <img src="{{ $car->image ? asset('storage/' . $car->image) : 'https://placehold.co/600x400?text=Car' }}" alt="{{ $car->name }}">
                        <span class="car-name">{{ $car->name }}</span>
                    </div>
                    <div class="details">
                        <div class="top-row">
                            <span class="badge">{{ $car->year ?? 'N/A' }}</span>
                            <span class="price">Ksh {{ number_format($car->price ?? 0, 2) }}</span>
                        </div>
                        <h3>{{ $car->name }}</h3>
                        <p>{{ $car->engine_size ?? 'N/A' }}, {{ $car->transmission ?? 'N/A' }}</p>
                        <!-- Correct dealer/source field -->
                        <p class="dealer">{{ $car->source ?? 'Dealer Unknown' }}</p>

                        <div class="actions">
                            <a href="{{ route('cars.edit', $car) }}">
                                <button type="button" class="edit">Edit</button>
                            </a>
                            <form action="{{ route('cars.destroy', $car) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this car?');">
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
