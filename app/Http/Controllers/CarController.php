<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the authenticated user's cars.
     */
    public function index(Request $request)
    {
        $filterStatus = $request->query('status', 'all');

        $cars = Car::where('user_id', auth()->id())
            ->when($filterStatus !== 'all', fn($query) => $query->where('availability', $filterStatus))
            ->latest()
            ->get();

        return view('cars.index', compact('cars', 'filterStatus'));
    }

    /**
     * Display public listing of cars.
     */
    public function publicIndex(Request $request)
    {
        $category = $request->query('category', 'All Vehicles');

        $cars = Car::with('user')
            ->when($category === 'Vehicles in Kenya', fn($q) => $q->where('origin', 'kenya'))
            ->when($category === 'Imports', fn($q) => $q->where('origin', 'import'))
            ->latest()
            ->get();

        return view('vehicles', compact('cars', 'category'));
    }

    /**
     * Show form to create a car.
     */
    public function create()
    {
        $origins = ['kenya', 'import'];
        $carTypes = ['Sedan', 'SUV', 'Truck', 'Van', 'Coupe'];

        return view('cars.create', compact('origins', 'carTypes'));
    }

    /**
     * Store a new car.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'year'          => 'required|integer|min:1900|max:' . date('Y'),
            'car_type'      => 'required|string|max:50',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'availability'  => 'nullable|string|max:50',
            'drive'         => 'nullable|string|max:50',
            'mileage'       => 'nullable|integer',
            'engine_size'   => 'nullable|string|max:50',
            'fuel_type'     => 'nullable|string|max:50',
            'horse_power'   => 'nullable|string|max:50',
            'transmission'  => 'nullable|string|max:50',
            'origin'        => 'required|string|in:kenya,import',
            'source'        => 'nullable|string|max:255',
            'specification' => 'nullable|array',
            'running_cost'  => 'nullable|array',
            'images.*'      => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'report'        => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Handle new images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('cars', 'public');
            }
        }

        // Handle report
        $reportPath = $request->hasFile('report') ? $request->file('report')->store('reports', 'public') : null;

        // Set main image as the first uploaded image
        $mainImage = $imagePaths[0] ?? null;

        // Create car
        Car::create([
            'user_id'       => auth()->id(),
            'name'          => $validated['name'],
            'year'          => $validated['year'],
            'car_type'      => $validated['car_type'],
            'description'   => $validated['description'] ?? null,
            'price'         => $validated['price'],
            'availability'  => $validated['availability'] ?? 'Available',
            'drive'         => $validated['drive'] ?? null,
            'mileage'       => $validated['mileage'] ?? null,
            'engine_size'   => $validated['engine_size'] ?? null,
            'fuel_type'     => $validated['fuel_type'] ?? null,
            'horse_power'   => $validated['horse_power'] ?? null,
            'transmission'  => $validated['transmission'] ?? null,
            'origin'        => $validated['origin'],
            'source'        => $validated['source'] ?? null,
            'specification' => $validated['specification'] ?? null,
            'running_cost'  => $validated['running_cost'] ?? null,
            'images'        => $imagePaths ?: null,
            'image'         => $mainImage,
            'report'        => $reportPath,
        ]);

        return redirect()->route('cars.my')->with('success', '🚀 Car listed successfully!');
    }

    /**
     * Show a specific car.
     */
    public function show(Car $car)
    {
        $specifications = $car->specification ?? [];
        $runningCosts = $car->running_cost ?? [];
        $images = $car->images ?? [];

        return view('cars.show', compact('car', 'specifications', 'runningCosts', 'images'));
    }

    /**
     * Show form to edit a car.
     */
    public function edit(Car $car)
    {
        $this->authorize('update', $car);

        $origins = ['kenya', 'import'];
        $carTypes = ['Sedan', 'SUV', 'Truck', 'Van', 'Coupe'];

        return view('cars.edit', compact('car', 'origins', 'carTypes'));
    }

    /**
     * Update a car (handle existing images and new uploads).
     */
    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'year'          => 'required|integer|min:1900|max:' . date('Y'),
            'car_type'      => 'required|string|max:50',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'availability'  => 'nullable|string|max:50',
            'drive'         => 'nullable|string|max:50',
            'mileage'       => 'nullable|integer',
            'engine_size'   => 'nullable|string|max:50',
            'fuel_type'     => 'nullable|string|max:50',
            'horse_power'   => 'nullable|string|max:50',
            'transmission'  => 'nullable|string|max:50',
            'origin'        => 'required|string|in:kenya,import',
            'source'        => 'nullable|string|max:255',
            'specification' => 'nullable|array',
            'running_cost'  => 'nullable|array',
            'existing_images' => 'nullable|array',
            'main_image_index' => 'nullable|integer',
            'images.*'      => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'report'        => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Merge existing images (submitted via hidden inputs) with new uploads
        $images = $request->input('existing_images', []);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('cars', 'public');
            }
        }

        // Set main image
        $mainIndex = $request->input('main_image_index', 0);
        $mainImage = $images[$mainIndex] ?? ($car->image ?? ($images[0] ?? null));

        // Handle report replacement
        if ($request->hasFile('report')) {
            if ($car->report) {
                Storage::disk('public')->delete($car->report);
            }
            $car->report = $request->file('report')->store('reports', 'public');
        }

        // Update car
        $car->update([
            'name'          => $validated['name'],
            'year'          => $validated['year'],
            'car_type'      => $validated['car_type'],
            'description'   => $validated['description'] ?? $car->description,
            'price'         => $validated['price'],
            'availability'  => $validated['availability'] ?? $car->availability,
            'drive'         => $validated['drive'] ?? $car->drive,
            'mileage'       => $validated['mileage'] ?? $car->mileage,
            'engine_size'   => $validated['engine_size'] ?? $car->engine_size,
            'fuel_type'     => $validated['fuel_type'] ?? $car->fuel_type,
            'horse_power'   => $validated['horse_power'] ?? $car->horse_power,
            'transmission'  => $validated['transmission'] ?? $car->transmission,
            'origin'        => $validated['origin'],
            'source'        => $validated['source'] ?? $car->source,
            'specification' => $validated['specification'] ?? $car->specification,
            'running_cost'  => $validated['running_cost'] ?? $car->running_cost,
            'images'        => $images ?: null,
            'image'         => $mainImage,
        ]);

        return redirect()->route('cars.my')->with('success', '✅ Car updated successfully!');
    }

    /**
     * Delete a car and associated files.
     */
    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        // Delete main image
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }

        // Delete all images
        if ($car->images) {
            foreach ($car->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        // Delete report
        if ($car->report) {
            Storage::disk('public')->delete($car->report);
        }

        $car->delete();

        return redirect()->route('cars.my')->with('success', '🚗 Car deleted successfully!');
    }

    /**
     * Download a car report.
     */
    public function buyReport($id)
    {
        $car = Car::findOrFail($id);

        if (!$car->report) {
            return redirect()->back()->with('error', '❌ This car does not have a report available.');
        }

        return response()->download(storage_path('app/public/' . $car->report));
    }
}
