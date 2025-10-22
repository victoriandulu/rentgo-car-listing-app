@extends('layouts.dashboard')
@section('dashboard-content')
<div class="list-car-container">
    <div class="page-header">
        <h1>🚗 List Your Car</h1>
        <p>Fill in the details below</p>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            <strong>⚠️ Please correct the following:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" id="carForm">
        @csrf

        <div class="section">
            <h2>📝 General Details</h2>
            <div class="grid">
                <div class="field full">
                    <label>Car Name <span class="req">*</span></label>
                    <input type="text" name="name" placeholder="e.g., Toyota Camry" value="{{ old('name') }}" required>
                </div>
                <div class="field">
                    <label>Year <span class="req">*</span></label>
                    <input type="number" name="year" placeholder="2020" value="{{ old('year') }}" required>
                </div>
                <div class="field">
                    <label>Type <span class="req">*</span></label>
                    <select name="car_type" required>
                        <option value="">Select</option>
                        <option {{ old('car_type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                        <option {{ old('car_type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                        <option {{ old('car_type') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                        <option {{ old('car_type') == 'Coupe' ? 'selected' : '' }}>Coupe</option>
                        <option {{ old('car_type') == 'Convertible' ? 'selected' : '' }}>Convertible</option>
                        <option {{ old('car_type') == 'Pickup' ? 'selected' : '' }}>Pickup</option>
                        <option {{ old('car_type') == 'Van' ? 'selected' : '' }}>Van</option>
                        <option {{ old('car_type') == 'Truck' ? 'selected' : '' }}>Truck</option>
                    </select>
                </div>
                <div class="field full">
                    <label>Description</label>
                    <textarea name="description" rows="3" placeholder="Describe your car...">{{ old('description') }}</textarea>
                </div>
                <div class="field full">
                    <label>Price (KSh) <span class="req">*</span></label>
                    <input type="number" name="price" placeholder="1,500,000" value="{{ old('price') }}" required>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>📷 Photos</h2>
            <input type="file" id="images" name="images[]" multiple accept="image/*" style="display:none">
            <div class="upload-box" onclick="document.getElementById('images').click()">
                <div class="upload-icon">📸</div>
                <p><strong>Upload Photos</strong></p>
                <small>Click or drag images (Max 10)</small>
            </div>
            <div id="previews" class="preview-grid"></div>
        </div>

        <div class="section">
            <h2>📍 Origin & Dealer</h2>
            <div class="grid">
                <div class="field">
                    <label>Origin <span class="req">*</span></label>
                    <select name="origin" required>
                        <option value="">Select</option>
                        <option value="kenya" {{ old('origin') == 'kenya' ? 'selected' : '' }}>Kenya</option>
                        <option value="import" {{ old('origin') == 'import' ? 'selected' : '' }}>Import</option>
                    </select>
                </div>
                <div class="field">
                    <label>Dealer/Source</label>
                    <input type="text" name="source" placeholder="e.g., Auto Mart" value="{{ old('source') }}">
                </div>
            </div>
        </div>

        <div class="section">
            <h2>⚙️ Specifications</h2>
            <div class="grid">
                <div class="field">
                    <label>Mileage (km)</label>
                    <input type="text" name="mileage" placeholder="50,000" value="{{ old('mileage') }}">
                </div>
                <div class="field">
                    <label>Engine (cc)</label>
                    <input type="text" name="engine_size" placeholder="2000" value="{{ old('engine_size') }}">
                </div>
                <div class="field">
                    <label>Fuel Type</label>
                    <input type="text" name="fuel_type" placeholder="Petrol" value="{{ old('fuel_type') }}">
                </div>
                <div class="field">
                    <label>Horsepower</label>
                    <input type="text" name="horse_power" placeholder="150" value="{{ old('horse_power') }}">
                </div>
                <div class="field">
                    <label>Transmission</label>
                    <select name="transmission">
                        <option value="">Select</option>
                        <option {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                        <option {{ old('transmission') == 'CVT' ? 'selected' : '' }}>CVT</option>
                    </select>
                </div>
                <div class="field">
                    <label>Drive</label>
                    <select name="drive">
                        <option value="">Select</option>
                        <option {{ old('drive') == 'FWD' ? 'selected' : '' }}>FWD</option>
                        <option {{ old('drive') == 'RWD' ? 'selected' : '' }}>RWD</option>
                        <option {{ old('drive') == '4WD' ? 'selected' : '' }}>4WD</option>
                        <option {{ old('drive') == 'AWD' ? 'selected' : '' }}>AWD</option>
                    </select>
                </div>
                <div class="field full">
                    <label>Availability</label>
                    <select name="availability">
                        <option value="">Select</option>
                        <option {{ old('availability') == 'Available' ? 'selected' : '' }}>Available</option>
                        <option {{ old('availability') == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>⭐ Features</h2>
            <div class="features">
                @php
                    $features = [
                        'heatedSeats' => '🔥 Heated Seats',
                        'powerWindows' => '🪟 Power Windows',
                        'steeringControls' => '🎮 Steering Controls',
                        'phoneConnectivity' => '📱 Phone Connectivity',
                        'autoStartStop' => '⚡ Auto Start/Stop',
                        'isofixAnchors' => '👶 ISOFIX Anchors',
                        'keylessEntryAndPushStart' => '🔑 Keyless Entry'
                    ];
                @endphp
                @foreach($features as $key => $label)
                    <label class="feature">
                        <input type="checkbox" name="specification[{{ $key }}]" value="1" {{ old("specification.{$key}") ? 'checked' : '' }}>
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="section">
            <h2>💰 Running Costs</h2>
            <div class="grid">
                <div class="field full">
                    <label>Insurance (KSh/year)</label>
                    <input type="text" name="running_cost[insuranceAnnualCost]" placeholder="50,000" value="{{ old('running_cost.insuranceAnnualCost') }}">
                </div>
                <div class="field">
                    <label>Fuel Urban (L/100km)</label>
                    <input type="text" name="running_cost[fuelUrban]" placeholder="8.5" value="{{ old('running_cost.fuelUrban') }}">
                </div>
                <div class="field">
                    <label>Fuel Highway (L/100km)</label>
                    <input type="text" name="running_cost[fuelHighway]" placeholder="6.2" value="{{ old('running_cost.fuelHighway') }}">
                </div>
            </div>
        </div>

        <div class="section">
            <h2>📄 Report (Optional)</h2>
            <input type="file" name="report" accept="application/pdf" class="file-input">
        </div>

        <button type="submit" class="btn-submit">🚀 List My Car</button>
    </form>
</div>

<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: -apple-system, BlinkMacSystemFont, sans-serif; background: #f3f4f6; color: #1f2937; }
.list-car-container { max-width: 100%; padding: 1rem; margin: 0 auto; }
.page-header { text-align: center; background: linear-gradient(135deg, #ef4444, #facc15); color: white; padding: 2rem 1rem; border-radius: 1rem; margin-bottom: 1.5rem; }
.page-header h1 { font-size: 1.75rem; margin-bottom: 0.5rem; }
.page-header p { opacity: 0.9; font-size: 0.95rem; }
.alert-error { background: #fef2f2; border: 2px solid #fca5a5; border-radius: 0.75rem; padding: 1rem; margin-bottom: 1.5rem; color: #7f1d1d; }
.alert-error ul { margin: 0.5rem 0 0 1.5rem; }
.section { background: white; border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.section h2 { font-size: 1.25rem; margin-bottom: 1.25rem; color: #ef4444; border-bottom: 2px solid #f3f4f6; padding-bottom: 0.75rem; }
.grid { display: grid; gap: 1rem; }
.field { display: flex; flex-direction: column; gap: 0.5rem; }
.field.full { grid-column: 1 / -1; }
.field label { font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; }
.req { color: #ef4444; }
input, select, textarea { width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; font-size: 1rem; font-family: inherit; transition: all 0.2s; }
input:focus, select:focus, textarea:focus { outline: none; border-color: #facc15; box-shadow: 0 0 0 3px rgba(250,204,21,0.1); }
textarea { resize: vertical; }
.upload-box { border: 2px dashed #d1d5db; border-radius: 0.75rem; padding: 2rem 1rem; text-align: center; cursor: pointer; background: #fafafa; transition: all 0.3s; }
.upload-box:hover { border-color: #facc15; background: #fffbeb; }
.upload-icon { font-size: 2.5rem; margin-bottom: 0.5rem; }
.preview-grid { display: grid; grid-template-columns: 1fr; gap: 0.75rem; margin-top: 1rem; }
.preview-item { position: relative; aspect-ratio: 16/9; border-radius: 0.5rem; overflow: hidden; border: 2px solid #e5e7eb; }
.preview-item img { width: 100%; height: 100%; object-fit: cover; }
.preview-item.main { border-color: #facc15; box-shadow: 0 0 0 2px rgba(250,204,21,0.2); }
.preview-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.7); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s; }
.preview-item:hover .preview-overlay { opacity: 1; }
.btn-delete { background: #ef4444; color: white; border: none; border-radius: 50%; width: 2.5rem; height: 2.5rem; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s; }
.btn-delete:hover { transform: scale(1.1); }
.main-badge { position: absolute; top: 0.5rem; left: 0.5rem; background: #facc15; color: #1f2937; padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 700; }
.features { display: grid; grid-template-columns: 1fr; gap: 0.75rem; }
.feature { display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s; background: white; }
.feature:hover { border-color: #facc15; background: #fffbeb; }
.feature input { width: auto; margin: 0; }
.feature input:checked + span { font-weight: 700; }
.file-input { width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; cursor: pointer; }
.btn-submit { width: 100%; padding: 1rem 2rem; background: linear-gradient(135deg, #ef4444, #facc15); color: white; border: none; border-radius: 0.75rem; font-size: 1.1rem; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.15); transition: transform 0.2s; margin-top: 1rem; }
.btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.2); }

@media (min-width: 768px) {
    .list-car-container { padding: 2rem; max-width: 900px; }
    .page-header { padding: 2.5rem; }
    .page-header h1 { font-size: 2.25rem; }
    .section { padding: 2rem; }
    .grid { grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
    .features { grid-template-columns: repeat(2, 1fr); }
    .preview-grid { grid-template-columns: repeat(2, 1fr); }
    .btn-submit { width: auto; min-width: 300px; margin: 1rem auto; display: block; }
}

@media (min-width: 1024px) {
    .list-car-container { max-width: 1000px; }
    .preview-grid { grid-template-columns: repeat(3, 1fr); }
}
</style>

<script>
let files = [], mainIdx = 0;
const input = document.getElementById('images'), previews = document.getElementById('previews');

input.addEventListener('change', e => addFiles(e.target.files));

document.querySelector('.upload-box').addEventListener('dragover', e => {
    e.preventDefault();
    e.currentTarget.style.borderColor = '#ef4444';
});

document.querySelector('.upload-box').addEventListener('drop', e => {
    e.preventDefault();
    e.currentTarget.style.borderColor = '';
    addFiles(e.dataTransfer.files);
});

function addFiles(newFiles) {
    const allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    for (let f of newFiles) {
        if (files.length >= 10) { alert('Max 10 images'); break; }
        if (allowed.includes(f.type)) files.push(f);
        else alert(`${f.name} not supported`);
    }
    render();
}

function render() {
    previews.innerHTML = '';
    files.forEach((f, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = `preview-item${i === mainIdx ? ' main' : ''}`;
            div.innerHTML = `
                <img src="${e.target.result}">
                <div class="preview-overlay">
                    <button type="button" class="btn-delete" onclick="remove(${i})">×</button>
                </div>
                ${i === mainIdx ? '<div class="main-badge">Main</div>' : ''}
            `;
            if (i !== mainIdx) {
                div.style.cursor = 'pointer';
                div.onclick = () => { mainIdx = i; render(); };
            }
            previews.appendChild(div);
        };
        reader.readAsDataURL(f);
    });
    const dt = new DataTransfer();
    files.forEach(f => dt.items.add(f));
    input.files = dt.files;
}

function remove(i) {
    files.splice(i, 1);
    if (i === mainIdx && files.length > 0) mainIdx = 0;
    else if (i < mainIdx) mainIdx--;
    else if (mainIdx >= files.length) mainIdx = Math.max(0, files.length - 1);
    render();
}
</script>
@endsection
