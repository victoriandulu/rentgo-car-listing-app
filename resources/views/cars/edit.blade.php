@extends('layouts.dashboard')

@section('dashboard-content')
<div class="list-car-container">
    <h1 class="page-title">Edit Car Listing</h1>

    @if ($errors->any())
        <div class="message-box error">
            <p><strong>Please correct the following issues:</strong></p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="car-form" id="carForm">
        @csrf
        @method('PATCH')

        <!-- General Information -->
        <div class="form-section">
            <h2 class="section-title">General Details</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">Car Name</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $car->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="year" class="form-label">Year of Manufacture</label>
                    <input type="number" id="year" name="year" class="form-input" value="{{ old('year', $car->year) }}" required>
                </div>
                <div class="form-group">
                    <label for="car_type" class="form-label">Car Type</label>
                    <select id="car_type" name="car_type" class="form-input" required>
                        <option value="">Select Car Type</option>
                        <option value="Sedan" {{ old('car_type', $car->car_type) == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                        <option value="SUV" {{ old('car_type', $car->car_type) == 'SUV' ? 'selected' : '' }}>SUV</option>
                        <option value="Hatchback" {{ old('car_type', $car->car_type) == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                        <option value="Coupe" {{ old('car_type', $car->car_type) == 'Coupe' ? 'selected' : '' }}>Coupe</option>
                        <option value="Convertible" {{ old('car_type', $car->car_type) == 'Convertible' ? 'selected' : '' }}>Convertible</option>
                        <option value="Pickup" {{ old('car_type', $car->car_type) == 'Pickup' ? 'selected' : '' }}>Pickup</option>
                        <option value="Van" {{ old('car_type', $car->car_type) == 'Van' ? 'selected' : '' }}>Van</option>
                        <option value="Minivan" {{ old('car_type', $car->car_type) == 'Minivan' ? 'selected' : '' }}>Minivan</option>
                        <option value="Crossover" {{ old('car_type', $car->car_type) == 'Crossover' ? 'selected' : '' }}>Crossover</option>
                        <option value="Truck" {{ old('car_type', $car->car_type) == 'Truck' ? 'selected' : '' }}>Truck</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-textarea" rows="4">{{ old('description', $car->description) }}</textarea>
            </div>

            <!-- Image Upload Section with existing images loaded -->
            <div class="form-group">
                <label for="images" class="form-label">Upload Photos</label>
                <div class="image-upload-container">
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="form-file" style="display: none;">
                    <div class="upload-area" onclick="document.getElementById('images').click()">
                        <div class="upload-icon">📷</div>
                        <p class="upload-text">Click to upload images or drag and drop</p>
                        <p class="upload-subtext">You can select multiple images at once</p>
                    </div>
                    <div id="imagePreviewContainer" class="image-preview-grid"></div>
                </div>
                <p class="form-help-text">First photo will be the main image. Maximum 10 images allowed.</p>
            </div>

            <div class="form-group">
                <label for="report" class="form-label">Upload Car Report (PDF)</label>
                <input type="file" id="report" name="report" accept="application/pdf" class="form-file">
                @if($car->report)
                    <p class="current-report">Current report: <a href="{{ asset('storage/' . $car->report) }}" target="_blank">📄 View Current Report</a></p>
                @endif
                <p class="form-help-text">Upload a new PDF to replace the current report (optional)</p>
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
                        <option value="kenya" {{ old('origin', $car->origin) == 'kenya' ? 'selected' : '' }}>Kenya</option>
                        <option value="import" {{ old('origin', $car->origin) == 'import' ? 'selected' : '' }}>Import</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="source" class="form-label">Dealer / Source</label>
                    <input type="text" id="source" name="source" class="form-input" value="{{ old('source', $car->source) }}">
                </div>
            </div>
        </div>

        <!-- Specifications -->
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
                        <option value="Manual" {{ old('transmission', $car->transmission) == 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option value="Automatic" {{ old('transmission', $car->transmission) == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                        <option value="CVT" {{ old('transmission', $car->transmission) == 'CVT' ? 'selected' : '' }}>CVT</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="drive" class="form-label">Drive</label>
                    <select id="drive" name="drive" class="form-input">
                        <option value="">Select Drive</option>
                        <option value="FWD" {{ old('drive', $car->drive) == 'FWD' ? 'selected' : '' }}>FWD</option>
                        <option value="RWD" {{ old('drive', $car->drive) == 'RWD' ? 'selected' : '' }}>RWD</option>
                        <option value="4WD" {{ old('drive', $car->drive) == '4WD' ? 'selected' : '' }}>4WD</option>
                        <option value="AWD" {{ old('drive', $car->drive) == 'AWD' ? 'selected' : '' }}>AWD</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="availability" class="form-label">Availability</label>
                    <select id="availability" name="availability" class="form-input">
                        <option value="">Select Availability</option>
                        <option value="Available" {{ old('availability', $car->availability) == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Unavailable" {{ old('availability', $car->availability) == 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Features -->
        <div class="form-section">
            <h2 class="section-title">⭐ Features</h2>
            <div class="features-grid">
                @php
                    $features = [
                        'heatedSeats' => 'Heated Seats',
                        'powerWindows' => 'Power Windows',
                        'steeringControls' => 'Steering Controls',
                        'phoneConnectivity' => 'Phone Connectivity',
                        'autoStartStop' => 'Auto Start/Stop',
                        'isofixAnchors' => 'ISOFIX Anchors',
                        'keylessEntryAndPushStart' => 'Keyless Entry & Push Start'
                    ];
                    $carSpecs = $car->specification ?? [];
                @endphp
                @foreach($features as $key => $label)
                    <label class="feature-label">
                        <input type="checkbox" name="specification[{{ $key }}]" value="1" class="feature-checkbox"
                               {{ old("specification.{$key}", $carSpecs[$key] ?? 0) ? 'checked' : '' }}>
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Running Costs -->
        <div class="form-section">
            <h2 class="section-title">💰 Running Costs</h2>
            @php $running = $car->running_cost ?? []; @endphp
            <div class="form-grid">
                <div class="form-group">
                    <label for="insuranceAnnualCost" class="form-label">Insurance (KSh/year)</label>
                    <input type="text" id="insuranceAnnualCost" name="running_cost[insuranceAnnualCost]" class="form-input" value="{{ old('running_cost.insuranceAnnualCost', $running['insuranceAnnualCost'] ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="fuelUrban" class="form-label">Fuel Urban (L/100km)</label>
                    <input type="text" id="fuelUrban" name="running_cost[fuelUrban]" class="form-input" value="{{ old('running_cost.fuelUrban', $running['fuelUrban'] ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="fuelHighway" class="form-label">Fuel Highway (L/100km)</label>
                    <input type="text" id="fuelHighway" name="running_cost[fuelHighway]" class="form-input" value="{{ old('running_cost.fuelHighway', $running['fuelHighway'] ?? '') }}">
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="form-submit">
            <button type="submit" class="submit-button">💾 Update Car</button>
        </div>
    </form>
</div>

<style>
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
}

.form-input, .form-textarea, .form-file, select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 0.75rem;
    font-size: 1rem;
    background-color: white;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    box-sizing: border-box;
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

.current-report {
    margin-top: 0.5rem;
    padding: 0.5rem;
    background-color: #f0fdf4;
    border-radius: 0.5rem;
    border: 1px solid #22c55e;
}

.current-report a {
    color: var(--rentgo-red);
    text-decoration: none;
    font-weight: 600;
}

.current-report a:hover {
    text-decoration: underline;
}

/* Image Upload Styles */
.image-upload-container {
    width: 100%;
}

.upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 1rem;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: #fafafa;
}

.upload-area:hover {
    border-color: var(--rentgo-yellow);
    background-color: #fffbeb;
}

.upload-area.drag-over {
    border-color: var(--rentgo-red);
    background-color: #fef2f2;
}

.upload-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.upload-text {
    font-weight: 600;
    color: var(--rentgo-dark-gray);
    margin-bottom: 0.5rem;
}

.upload-subtext {
    font-size: 0.9rem;
    color: #6b7280;
}

.image-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1.5rem;
}

.image-preview-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 0.75rem;
    overflow: hidden;
    border: 2px solid #e5e7eb;
    background-color: white;
}

.image-preview-item.main-image {
    border-color: var(--rentgo-yellow);
    box-shadow: 0 0 0 2px rgba(252, 203, 21, 0.2);
}

.image-preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-preview-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-preview-item:hover .image-preview-overlay {
    opacity: 1;
}

.delete-button {
    background: var(--rentgo-red);
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    font-size: 1.2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease;
}

.delete-button:hover {
    transform: scale(1.1);
}

.main-image-badge {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    background: var(--rentgo-yellow);
    color: var(--rentgo-dark-gray);
    padding: 0.25rem 0.5rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
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
    background-image: linear-gradient(135deg, var(--rentgo-red) 0%, var(--rentgo-yellow) 100%);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.submit-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

@media (min-width: 768px) {
    .form-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .features-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .image-preview-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}

@media (min-width: 1024px) {
    .image-preview-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    }
}
</style>

<script>
// Load existing images and then allow new uploads
let selectedFiles = [];
let mainImageIndex = 0;

document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('images');
    const uploadArea = document.querySelector('.upload-area');
    const previewContainer = document.getElementById('imagePreviewContainer');

    // Load existing images first
    loadExistingImages();

    // Handle file input change
    imageInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
        const files = e.dataTransfer.files;
        handleFiles(files);
    });

    function loadExistingImages() {
        const existingImages = @json($car->images ?? []);

        existingImages.forEach((imagePath, index) => {
            fetch('{{ asset("storage/") }}/' + imagePath)
                .then(response => response.blob())
                .then(blob => {
                    const file = new File([blob], `existing-image-${index}.jpg`, { type: blob.type });
                    file.isExisting = true;
                    file.existingPath = imagePath;
                    selectedFiles.push(file);

                    if (index === existingImages.length - 1) {
                        updateImagePreviews();
                    }
                })
                .catch(error => {
                    console.error('Error loading existing image:', error);
                });
        });
    }

    function handleFiles(files) {
        const maxFiles = 10;
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

        for (let i = 0; i < files.length; i++) {
            if (selectedFiles.length >= maxFiles) {
                alert(`Maximum ${maxFiles} images allowed`);
                break;
            }

            const file = files[i];
            if (allowedTypes.includes(file.type)) {
                selectedFiles.push(file);
            } else {
                alert(`File "${file.name}" is not a supported image format`);
            }
        }

        updateImagePreviews();
        updateFileInput();
    }

    function updateImagePreviews() {
        previewContainer.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            if (file.isExisting) {
                const previewItem = createImagePreview('{{ asset("storage/") }}/' + file.existingPath, index, true);
                previewContainer.appendChild(previewItem);
            } else {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = createImagePreview(e.target.result, index, false);
                    previewContainer.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    function createImagePreview(src, index, isExisting) {
        const previewItem = document.createElement('div');
        previewItem.className = `image-preview-item${index === mainImageIndex ? ' main-image' : ''}`;

        previewItem.innerHTML = `
            <img src="${src}" alt="Preview ${index + 1}">
            <div class="image-preview-overlay">
                <button type="button" class="delete-button" onclick="removeImage(${index})">×</button>
            </div>
            ${index === mainImageIndex ? '<div class="main-image-badge">Main</div>' : ''}
        `;

        // Make image clickable to set as main image
        if (index !== mainImageIndex) {
            previewItem.addEventListener('click', function(e) {
                if (!e.target.classList.contains('delete-button')) {
                    setMainImage(index);
                }
            });
            previewItem.style.cursor = 'pointer';
            previewItem.title = 'Click to set as main image';
        }

        return previewItem;
    }

    window.removeImage = function(index) {
        selectedFiles.splice(index, 1);

        // Adjust main image index if necessary
        if (index === mainImageIndex && selectedFiles.length > 0) {
            mainImageIndex = 0;
        } else if (index < mainImageIndex) {
            mainImageIndex--;
        } else if (mainImageIndex >= selectedFiles.length) {
            mainImageIndex = Math.max(0, selectedFiles.length - 1);
        }

        updateImagePreviews();
        updateFileInput();
    };

    window.setMainImage = function(index) {
        mainImageIndex = index;
        updateImagePreviews();
    };

    function updateFileInput() {
        // Create a new FileList-like object with only new files
        const dt = new DataTransfer();
        selectedFiles.forEach(file => {
            if (!file.isExisting) {
                dt.items.add(file);
            }
        });
        imageInput.files = dt.files;
    }
});
</script>

@endsection
