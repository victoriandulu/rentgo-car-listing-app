@extends('layouts.app')

@section('content')
<div class="container">

    <header class="header">
        <div class="filters">
            <a href="{{ route('vehicles', ['category' => 'All Vehicles']) }}"
               class="{{ $category === 'All Vehicles' ? 'active' : '' }}">All Vehicles</a>

            <a href="{{ route('vehicles', ['category' => 'Vehicles in Kenya']) }}"
               class="{{ $category === 'Vehicles in Kenya' ? 'active' : '' }}">Vehicles in Kenya</a>

            <a href="{{ route('vehicles', ['category' => 'Imports']) }}"
               class="{{ $category === 'Imports' ? 'active' : '' }}">Imports</a>
        </div>

        <div class="info">
            <span>Showing {{ count($vehicles) }} vehicles</span>
            <a href="{{ route('vehicles', ['category' => 'All Vehicles']) }}" class="clear">Clear Filters</a>
        </div>
    </header>

    <main class="grid">
        @foreach($vehicles as $vehicle)
            <div class="card">
                <div class="image-container">
                    <img src="{{ $vehicle['image'] }}"
                         alt="{{ $vehicle['name'] }}"
                         onerror="this.src='https://via.placeholder.com/400x250';">
                </div>
                <div class="details">
                    <div class="top-row">
                        <span class="badge">{{ $vehicle['id'] }}</span>
                        <span class="price">
                            Ksh {{ number_format($vehicle['price'], 2) }}
                        </span>
                    </div>
                    <h3>{{ $vehicle['name'] }}</h3>
                    <p>{{ $vehicle['specs'] }}</p>
                    <p class="dealer">{{ $vehicle['dealer'] }}</p>

                    <form action="{{ route('vehicles.buyReport', $vehicle['id']) }}" method="POST">
                        @csrf
                       <button type="submit" >
                     Buy Report (Ksh {{ number_format($vehicle['reportPrice'], 2) }})
                   </button>
                    </form>
                </div>
            </div>
        @endforeach
    </main>

</div>
@endsection
