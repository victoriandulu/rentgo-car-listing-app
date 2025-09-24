@extends('layouts.dashboard')
@section('dashboard-content')
<div class="list-car-container">
    <h1 class="page-title">✏️ Edit Car: {{ $car->name }}</h1>

    @if ($errors->any())
        <div class="message-box error">
            <p><strong>Please correct the following issues:</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.update', $car) }}" method="POST" enctype="multipart/form-data" class="car-form">
        @csrf
        @method('PUT')

        <!-- General Information -->
        <div class="form-section">
            <h2 class="section-title">General Details</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">Car Name</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $car->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="year_of_manufacture" class="form-label">Year of Manufacture</label>
                    <input type="number" id="year_of_manufacture" name="year" class="form-input" value="{{ old('year', $car->year) }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-textarea" rows="4">{{ old('description', $car->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="images" class="form-label">Upload Photos</label>
                <input type="file" id="images" name="images[]" multiple class="form-file">
                <p class="form-help-text">First photo will be the main image</p>

                @if($car->images)
                    <div class="existing-images" style="margin-top: 1rem;">
                        @foreach(json_decode($car->images) as $img)
                            <img src="{{ asset('storage/' . $img) }}" alt="Car Image" class="existing-image">
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="price" class="form-label">Price (KSh)</label>
                <input type="number" id="price" name="price" class="form-input" value="{{ old('price', $car->price) }}" required>
            </div>
        </div>

        <!-- Origin & Dealer -->
        <div class="form-section">
            <h2 class="section-title">📍 Origin & Dealer</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="origin" class="form-label">Origin</label>
                    <select id="origin" name="origin" class="form-input" required>
                        <option value="">Select Origin</option>
                        <option value="kenya" {{ old('origin', $car->origin) === 'kenya' ? 'selected' : '' }}>Kenya</option>
                        <option value="import" {{ old('origin', $car->origin) === 'import' ? 'selected' : '' }}>Import</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="source" class="form-label">Dealer / Source</label>
                    <input type="text" id="source" name="source" class="form-input" value="{{ old('source', $car->source) }}" placeholder="e.g., Nairobi Auto Mart">
                    <p class="form-help-text">Specify dealer or source if known (optional)</p>
                </div>
            </div>
        </div>

        <!-- Specifications -->
        @php
            $specifications = json_decode($car->specification ?? '{}', true);
        @endphp
        <div class="form-section">
            <h2 class="section-title">📋 Specifications</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="mileage" class="form-label">Mileage (km)</label>
                    <input type="text" id="mileage" name="mileage" class="form-input" value="{{ old('mileage', $car->mileage) }}">
                </div>
                <div class="form-group">
                    <label for="engine_size" class="form-label">Engine Size (cc)</label>
                    <input type="text" id="engine_size" name="engine_size" class="form-input" value="{{ old('engine_size', $car->engine_size) }}">
                </div>
                <div class="form-group">
                    <label for="fuel_type" class="form-label">Fuel Type</label>
                    <input type="text" id="fuel_type" name="fuel_type" class="form-input" value="{{ old('fuel_type', $car->fuel_type) }}">
                </div>
                <div class="form-group">
                    <label for="horse_power" class="form-label">Horse Power</label>
                    <input type="text" id="horse_power" name="horse_power" class="form-input" value="{{ old('horse_power', $car->horse_power) }}">
                </div>
                <div class="form-group">
                    <label for="transmission" class="form-label">Transmission</label>
                    <select id="transmission" name="transmission" class="form-input">
                        <option value="">Select Transmission</option>
                        <option {{ old('transmission', $car->transmission) === 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option {{ old('transmission', $car->transmission) === 'Automatic' ? 'selected' : '' }}>Automatic</option>
                        <option {{ old('transmission', $car->transmission) === 'CVT' ? 'selected' : '' }}>CVT</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="drive" class="form-label">Drive</label>
                    <select id="drive" name="drive" class="form-input">
                        <option value="">Select Drive</option>
                        <option {{ old('drive', $car->drive) === 'FWD' ? 'selected' : '' }}>FWD</option>
                        <option {{ old('drive', $car->drive) === 'RWD' ? 'selected' : '' }}>RWD</option>
                        <option {{ old('drive', $car->drive) === '4WD' ? 'selected' : '' }}>4WD</option>
                        <option {{ old('drive', $car->drive) === 'AWD' ? 'selected' : '' }}>AWD</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="availability" class="form-label">Availability</label>
                    <select id="availability" name="availability" class="form-input">
                        <option value="">Select Availability</option>
                        <option {{ old('availability', $car->availability) === 'Available' ? 'selected' : '' }}>Available</option>
                        <option {{ old('availability', $car->availability) === 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Features -->
        @php
            $features = [
                'heatedSeats' => 'Heated Seats',
                'powerWindows' => 'Power Windows',
                'steeringControls' => 'Steering Controls',
                'phoneConnectivity' => 'Phone Connectivity',
                'autoStartStop' => 'Auto Start/Stop',
                'isofixAnchors' => 'ISOFIX Anchors',
                'keylessEntryAndPushStart' => 'Keyless Entry & Push Start',
            ];
        @endphp
        <div class="form-section">
            <h2 class="section-title">⭐ Features</h2>
            <div class="features-grid">
                @foreach($features as $key => $label)
                    <label class="feature-label">
                        <input type="checkbox" name="specification[{{ $key }}]" value="1"
                               class="feature-checkbox"
                               {{ old("specification.$key", $specifications[$key] ?? null) ? 'checked' : '' }}>
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Running Costs -->
        @php
            $runningCosts = json_decode($car->running_cost ?? '{}', true);
        @endphp
        <div class="form-section">
            <h2 class="section-title">💰 Running Costs</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="insuranceAnnualCost" class="form-label">Insurance (KSh/year)</label>
                    <input type="text" id="insuranceAnnualCost" name="running_cost[insuranceAnnualCost]" class="form-input"
                           value="{{ old('running_cost.insuranceAnnualCost', $runningCosts['insuranceAnnualCost'] ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="fuelUrban" class="form-label">Fuel Urban (L/100km)</label>
                    <input type="text" id="fuelUrban" name="running_cost[fuelUrban]" class="form-input"
                           value="{{ old('running_cost.fuelUrban', $runningCosts['fuelUrban'] ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="fuelHighway" class="form-label">Fuel Highway (L/100km)</label>
                    <input type="text" id="fuelHighway" name="running_cost[fuelHighway]" class="form-input"
                           value="{{ old('running_cost.fuelHighway', $runningCosts['fuelHighway'] ?? '') }}">
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="form-submit">
            <button type="submit" class="submit-button">
                💾 UPDATE CAR
            </button>
        </div>
    </form>
</div>

<style>
/* Your existing CSS remains unchanged */
:root {
    --rentgo-red: #ef4444;
    --rentgo-yellow: #facc15;
    --rentgo-dark-gray: #1f2937;
    --rentgo-light-gray: #f3f4f6;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: var(--rentgo-light-gray);
    color: var(--rentgo-dark-gray);
}

.list-car-container {
    max-width: 900px;
    margin: 70px auto;
    padding: 2.5rem;
    background-color: white;
    border-radius: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.page-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 2rem;
    text-align: center;
    color: var(--rentgo-dark-gray);
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.message-box {
    padding: 1.5rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
    font-size: 1rem;
    font-weight: 500;
    line-height: 1.5;
}

.message-box.error {
    background-color: #fca5a5;
    color: #7f1d1d;
    border: 2px solid #ef4444;
}

.message-box ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.message-box li {
    margin-bottom: 0.5rem;
}

.car-form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.form-section {
    background-color: var(--rentgo-light-gray);
    padding: 2rem;
    border-radius: 1.5rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.section-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: var(--rentgo-red);
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(1, minmax(0, 1fr));
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--rentgo-dark-gray);
}

.form-input, .form-textarea, .form-file, select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    font-size: 1rem;
    background-color: white;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-input:focus, .form-textarea:focus, .form-file:focus, select:focus {
    outline: none;
    border-color: var(--rentgo-yellow);
    box-shadow: 0 0 0 4px rgba(252, 203, 21, 0.2);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.form-help-text {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.5rem;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(1, minmax(0, 1fr));
    gap: 1rem;
}

.feature-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-weight: 500;
    transition: color 0.3s ease;
}

.feature-label:hover {
    color: var(--rentgo-red);
}

.feature-checkbox {
    width: 1.25rem;
    height: 1.25rem;
    border-radius: 0.25rem;
    border: 2px solid #d1d5db;
    appearance: none;
    background-color: white;
    transition: all 0.2s ease;
    margin-right: 0.75rem;
}

.feature-checkbox:checked {
    background-color: var(--rentgo-red);
    border-color: var(--rentgo-red);
}

.form-submit {
    text-align: center;
    margin-top: 2rem;
}

.submit-button {
    padding: 1rem 2.5rem;
    border-radius: 2rem;
    font-size: 1.1rem;
    font-weight: 700;
    color: white;
    border: none;
    cursor: pointer;
    background-color: var(--rentgo-red);
    background-image: linear-gradient(135deg, var(--rentgo-red) 0%, var(--rentgo-yellow) 100%);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.submit-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.existing-image {
    width: 80px;
    margin-right: 10px;
    border-radius: 5px;
}

@media (min-width: 768px) {
    .form-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .features-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
</style>
@endsection
