@extends('layouts.app')

@section('content')
<div class="home-container">

    {{-- Hero Section --}}
    <div class="hero">
        <h1>The Safest Way to Buy or Sell Your Car in Kenya</h1>
        <p>Find what fits you</p>
        <p>We help you find a car that fits your personality, dream, and pocket!</p>
    </div>

    {{-- Watermark --}}
    <div class="watermark">
        <span>Rent</span> <br />
        <span>Go</span>
    </div>

    {{-- Search Filters --}}
    <div class="search-section">
        <form action="{{ route('search.vehicle') }}" method="GET">
            <input
                type="text"
                name="query"
                placeholder="Search vehicle name"
                class="search-box"
            />
            <button type="submit" class="search-btn">Search Vehicle</button>
        </form>
    </div>

    {{-- Image Section --}}
    <div class="image-container">
        <img src="{{ asset('images/gwagon.png') }}" alt="Car Rental" class="background-image" />
    </div>

    {{-- Filters --}}
    <div class="filters">
        <button>Filter by Brand</button>
        <button>Filter by Body Type</button>
        <button>0 - 500K</button>
        <button>500K - 1M</button>
        <button>1M - 2M</button>
        <button>2M - 3M</button>
        <button>3M - 5M</button>
        <button>5M - 10M</button>
        <button>Above 10M</button>
    </div>

    {{-- Newsletter Signup --}}
    <div class="newsletter">
        <h2>Stay Up to Date</h2>
        <form action="{{ route('newsletter.subscribe') }}" method="POST">
            @csrf
            <input
                type="email"
                name="email"
                placeholder="Your email address"
                class="email-input"
                required
            />
            <button type="submit" class="subscribe-btn">Subscribe</button>
        </form>
    </div>

    {{-- Watermark --}}
    <div class="watermark">
        <span>Rent</span> <br />
        <span>Go</span>
    </div>
</div>
@endsection
