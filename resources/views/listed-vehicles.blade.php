@extends('layouts.app')

@section('title', 'My Listings')

@section('content')
    <style>
        /* ✨ Paste your ListedVehicles.css here later */
    </style>

    <div class="dashboard-section">
        <!-- Filter Bar -->
        <div class="filter-bar">
            <select class="form-select">
                <option value="all">All Listings</option>
                <option value="active">Active</option>
                <option value="pending">Pending</option>
                <option value="draft">Draft</option>
                <option value="sold">Sold</option>
            </select>

            <button class="btn-primary">+ Create New Listing</button>
        </div>

        <!-- Example: No Listings -->
        {{--
        <div class="empty-state">
            <div class="empty-icon">🚗</div>
            <h3>No listings found</h3>
            <p>You haven't created any listings yet.</p>
            <button class="btn-primary">Create Your First Listing</button>
        </div>
        --}}

        <!-- Example: Listings Grid -->
        <div class="cars-grid">
            <div class="car-card">
                <div class="car-image">
                    <img src="{{ asset('images/sample-car.jpg') }}" alt="Toyota Corolla 2018">
                    <div class="status-badge active">Active</div>
                </div>
                <div class="car-details">
                    <h3 class="car-title">Toyota Corolla 2018</h3>
                    <p class="car-price">$12,500</p>
                    <div class="car-stats">
                        <div>Views: 145</div>
                        <div>Inquiries: 12</div>
                    </div>
                    <div class="car-actions">
                        <button class="btn-edit">Edit</button>
                        <button class="btn-delete">Delete</button>
                    </div>
                </div>
            </div>

            <div class="car-card">
                <div class="car-image">
                    <img src="{{ asset('images/sample-car2.jpg') }}" alt="Honda Civic 2019">
                    <div class="status-badge pending">Pending</div>
                </div>
                <div class="car-details">
                    <h3 class="car-title">Honda Civic 2019</h3>
                    <p class="car-price">$14,200</p>
                    <div class="car-stats">
                        <div>Views: 98</div>
                        <div>Inquiries: 7</div>
                    </div>
                    <div class="car-actions">
                        <button class="btn-edit">Edit</button>
                        <button class="btn-delete">Delete</button>
                    </div>
                </div>
            </div>

            <!-- Add more car-card blocks as needed -->
        </div>
    </div>
@endsection
