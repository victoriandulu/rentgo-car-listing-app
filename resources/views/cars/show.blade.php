{{-- resources/views/cars/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="car-page-container">
    <div class="car-container">
        <div class="car-header">
            <div class="car-title">
                <h1>{{ $car->name }}</h1>
                <span class="year">{{ $car->year }}</span>
            </div>
            <div class="car-price">KSh {{ number_format($car->price) }}</div>
        </div>

        @if($car->images && count($car->images) > 0)
            <div class="image-gallery">
                <div class="main-image">
                    <img id="mainImg" src="{{ asset('storage/' . $car->images[0]) }}" alt="{{ $car->name }}">
                </div>
                @if(count($car->images) > 1)
                    <div class="image-thumbs">
                        @foreach($car->images as $index => $img)
                            <img src="{{ asset('storage/' . $img) }}"
                                 alt="{{ $car->name }}"
                                 onclick="changeImage('{{ asset('storage/' . $img) }}')"
                                 class="{{ $index === 0 ? 'active' : '' }}">
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <div class="car-details">
            <div class="detail-box">
                <h3>Vehicle Details</h3>
                <div class="details-grid">
                    <div><strong>Type:</strong> {{ $car->car_type }}</div>
                    <div><strong>Origin:</strong> {{ ucfirst($car->origin) }}</div>
                    <div><strong>Status:</strong> {{ $car->availability }}</div>
                    @if($car->mileage)<div><strong>Mileage:</strong> {{ number_format($car->mileage) }} km</div>@endif
                    @if($car->engine_size)<div><strong>Engine:</strong> {{ $car->engine_size }}cc</div>@endif
                    @if($car->fuel_type)<div><strong>Fuel:</strong> {{ $car->fuel_type }}</div>@endif
                    @if($car->transmission)<div><strong>Transmission:</strong> {{ $car->transmission }}</div>@endif
                    @if($car->horse_power)<div><strong>Power:</strong> {{ $car->horse_power }}hp</div>@endif
                </div>
            </div>

            @if($car->description)
            <div class="detail-box">
                <h3>Description</h3>
                <p>{{ $car->description }}</p>
            </div>
            @endif

            @if($car->specification && count(array_filter($car->specification)))
            <div class="detail-box">
                <h3>Features</h3>
                <div class="features-list">
                    @foreach($car->specification as $feature => $value)
                        @if($value)
                            <span>{{ ucwords(str_replace(['_', 'And'], [' ', ' & '], $feature)) }}</span>
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="back-link">
            <a href="{{ url('/vehicles') }}">← Back to Vehicles</a>
        </div>
    </div>
</div>

<style>
/* Page padding for header and footer space */
.car-page-container {
    padding-top: 100px; /* space for header */
    padding-bottom: 100px; /* space for footer */
    background-color: #f5f5f5;
    min-height: calc(100vh - 200px); /* total padding space accounted */
}

.car-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Header and images */
.car-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 20px;
    border-bottom: 2px solid #eee;
    margin-bottom: 25px;
}

.car-title h1 {
    margin: 0;
    font-size: 2.2rem;
    color: #222;
    font-weight: 700;
}

.year {
    color: #666;
    font-size: 1.1rem;
    margin-left: 10px;
}

.car-price {
    font-size: 2rem;
    color: #e74c3c;
    font-weight: 800;
}

.image-gallery {
    margin-bottom: 30px;
}

.main-image {
    width: 100%;
    height: 400px;
    margin-bottom: 15px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #ddd;
}

.main-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-thumbs {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding: 10px 0;
}

.image-thumbs img {
    width: 100px;
    height: 70px;
    object-fit: cover;
    border-radius: 5px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.image-thumbs img:hover,
.image-thumbs img.active {
    border-color: #e74c3c;
    opacity: 1;
}

.image-thumbs img:not(.active) {
    opacity: 0.7;
}

/* Details */
.car-details {
    display: grid;
    gap: 25px;
}

.detail-box {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #e74c3c;
}

.detail-box h3 {
    margin: 0 0 15px 0;
    color: #e74c3c;
    font-size: 1.3rem;
    font-weight: 600;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
}

.details-grid div {
    padding: 8px 0;
    border-bottom: 1px solid #dee2e6;
}

.details-grid div:last-child {
    border-bottom: none;
}

.features-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.features-list span {
    background: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    border: 1px solid #dee2e6;
    color: #495057;
}

.back-link {
    margin-top: 30px;
    text-align: center;
}

.back-link a {
    display: inline-block;
    padding: 12px 30px;
    background: #6c757d;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
    transition: background 0.3s ease;
}

.back-link a:hover {
    background: #5a6268;
}

@media (max-width: 768px) {
    .car-container {
        margin: 10px;
        padding: 15px;
    }

    .car-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .car-title h1 {
        font-size: 1.8rem;
    }

    .car-price {
        font-size: 1.6rem;
    }

    .main-image {
        height: 250px;
    }

    .details-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
function changeImage(src) {
    document.getElementById('mainImg').src = src;

    const thumbs = document.querySelectorAll('.image-thumbs img');
    thumbs.forEach(thumb => {
        thumb.classList.remove('active');
        if (thumb.src === src) thumb.classList.add('active');
    });
}
</script>
@endsection
