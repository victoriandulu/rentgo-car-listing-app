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
        $origins  = ['kenya', 'import'];
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
            'make'          => 'nullable|string|max:100',
            'model'         => 'nullable|string|max:100',
            'variant'       => 'nullable|string|max:100',
            'year'          => 'required|integer|min:1900|max:' . date('Y'),
            'car_type'      => 'required|string|max:50',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'availability'  => 'nullable|string|max:50',
            'drive'         => 'nullable|string|max:50',
            'location'      => 'nullable|string|max:255',
            'seats'         => 'nullable|integer|min:1|max:20',
            'doors'         => 'nullable|integer|min:1|max:10',
            'mileage'       => 'nullable|integer',
            'engine_size'   => 'nullable|string|max:50',
            'fuel_type'     => 'nullable|string|max:50',
            'fuel_consumption'   => 'nullable|string|max:50',
            'fuel_tank_capacity' => 'nullable|string|max:50',
            'cylinder_layout'    => 'nullable|string|max:50',
            'kilowatts'          => 'nullable|string|max:50',
            'gears'              => 'nullable|string|max:50',
            'horse_power'   => 'nullable|string|max:50',
            'transmission'  => 'nullable|string|max:50',
            'torque'        => 'nullable|string|max:50',
            'aspiration'    => 'nullable|string|max:50',
            'acceleration'  => 'nullable|string|max:50',
            'origin'        => 'required|string|in:kenya,import',
            'source'        => 'nullable|string|max:255',
            'specification' => 'nullable|array',
            'running_cost'  => 'nullable|array',
            'images'        => 'nullable|array|max:30',
            'images.*'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'report'        => 'nullable|file|mimes:pdf|max:10240',
            'video'         => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime|max:51200',
        ]);

        // Handle images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('cars', 'public');
            }
        }

        // Handle report
        $reportPath = $request->hasFile('report')
            ? $request->file('report')->store('reports', 'public')
            : null;

        // Handle video
        $videoPath = $request->hasFile('video')
            ? $request->file('video')->store('car-videos', 'public')
            : null;

        // First image is the cover
        $mainImage = $imagePaths[0] ?? null;

        Car::create([
            'user_id'       => auth()->id(),
            'name'          => $validated['name'],
            'make'          => $validated['make']  ?? null,
            'model'         => $validated['model'] ?? null,
            'variant'       => $validated['variant'] ?? null,
            'year'          => $validated['year'],
            'car_type'      => $validated['car_type'],
            'description'   => $validated['description'] ?? null,
            'price'         => $validated['price'],
            'availability'  => $validated['availability'] ?? 'Available',
            'drive'         => $validated['drive'] ?? null,
            'location'      => $validated['location'] ?? null,
            'seats'         => $validated['seats'] ?? null,
            'doors'         => $validated['doors'] ?? null,
            'mileage'       => $validated['mileage'] ?? null,
            'engine_size'   => $validated['engine_size'] ?? null,
            'fuel_type'     => $validated['fuel_type'] ?? null,
            'fuel_consumption'   => $validated['fuel_consumption'] ?? null,
            'fuel_tank_capacity' => $validated['fuel_tank_capacity'] ?? null,
            'cylinder_layout'    => $validated['cylinder_layout'] ?? null,
            'kilowatts'          => $validated['kilowatts'] ?? null,
            'gears'              => $validated['gears'] ?? null,
            'horse_power'   => $validated['horse_power'] ?? null,
            'transmission'  => $validated['transmission'] ?? null,
            'torque'        => $validated['torque'] ?? null,
            'aspiration'    => $validated['aspiration'] ?? null,
            'acceleration'  => $validated['acceleration'] ?? null,
            'origin'        => $validated['origin'],
            'source'        => $validated['source'] ?? null,
            'specification' => $validated['specification'] ?? null,
            'running_cost'  => $validated['running_cost'] ?? null,
            'images'        => $imagePaths ?: null,
            'image'         => $mainImage,
            'report'        => $reportPath,
            'video'         => $videoPath,
        ]);

        return redirect()->route('cars.my')->with('success', '🚀 Car listed successfully!');
    }

    /**
     * Show a specific car.
     */
    public function show(Car $car)
    {
        $specifications = $car->specification ?? [];
        $runningCosts   = $car->running_cost  ?? [];
        $images         = $car->images        ?? [];

        return view('cars.show', compact('car', 'specifications', 'runningCosts', 'images'));
    }

    /**
     * Show form to edit a car.
     */
    public function edit(Car $car)
    {
        $this->authorize('update', $car);

        $origins  = ['kenya', 'import'];
        $carTypes = ['Sedan', 'SUV', 'Truck', 'Van', 'Coupe'];

        return view('cars.edit', compact('car', 'origins', 'carTypes'));
    }

    /**
     * Update a car (handle existing images, new uploads, and video).
     */
    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'make'              => 'nullable|string|max:100',
            'model'             => 'nullable|string|max:100',
            'variant'           => 'nullable|string|max:100',
            'year'              => 'required|integer|min:1900|max:' . date('Y'),
            'car_type'          => 'required|string|max:50',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'availability'      => 'nullable|string|max:50',
            'drive'             => 'nullable|string|max:50',
            'location'          => 'nullable|string|max:255',
            'seats'             => 'nullable|integer|min:1|max:20',
            'doors'             => 'nullable|integer|min:1|max:10',
            'mileage'           => 'nullable|integer',
            'engine_size'       => 'nullable|string|max:50',
            'fuel_type'         => 'nullable|string|max:50',
            'fuel_consumption'   => 'nullable|string|max:50',
            'fuel_tank_capacity' => 'nullable|string|max:50',
            'cylinder_layout'    => 'nullable|string|max:50',
            'kilowatts'          => 'nullable|string|max:50',
            'gears'              => 'nullable|string|max:50',
            'horse_power'       => 'nullable|string|max:50',
            'transmission'      => 'nullable|string|max:50',
            'torque'            => 'nullable|string|max:50',
            'aspiration'        => 'nullable|string|max:50',
            'acceleration'      => 'nullable|string|max:50',
            'origin'            => 'required|string|in:kenya,import',
            'source'            => 'nullable|string|max:255',
            'specification'     => 'nullable|array',
            'running_cost'      => 'nullable|array',
            'existing_images'   => 'nullable|array',
            'main_image_index'  => 'nullable|integer',
            'images'            => 'nullable|array|max:30',
            'images.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'report'            => 'nullable|file|mimes:pdf|max:10240',
            'video'             => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime|max:51200',
        ]);

        // ── Images ──────────────────────────────────────────────
        $images = $request->input('existing_images', []);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $images[] = $file->store('cars', 'public');
            }
        }

        $mainIndex = $request->input('main_image_index', 0);
        $mainImage = $images[$mainIndex] ?? $car->image ?? ($images[0] ?? null);

        // ── Report ───────────────────────────────────────────────
        if ($request->hasFile('report')) {
            if ($car->report) {
                Storage::disk('public')->delete($car->report);
            }
            $car->report = $request->file('report')->store('reports', 'public');
        }

        // ── Video ────────────────────────────────────────────────
        if ($request->hasFile('video')) {
            // Delete old video to free up storage
            if ($car->video) {
                Storage::disk('public')->delete($car->video);
            }
            $car->video = $request->file('video')->store('car-videos', 'public');
        }

        // ── Save all fields ──────────────────────────────────────
        $car->update([
            'name'          => $validated['name'],
            'make'          => $validated['make']  ?? $car->make,
            'model'         => $validated['model'] ?? $car->model,
            'variant'       => $validated['variant'] ?? $car->variant,
            'year'          => $validated['year'],
            'car_type'      => $validated['car_type'],
            'description'   => $validated['description']  ?? $car->description,
            'price'         => $validated['price'],
            'availability'  => $validated['availability'] ?? $car->availability,
            'drive'         => $validated['drive']        ?? $car->drive,
            'location'      => $validated['location']     ?? $car->location,
            'seats'         => $validated['seats']        ?? $car->seats,
            'doors'         => $validated['doors']        ?? $car->doors,
            'mileage'       => $validated['mileage']      ?? $car->mileage,
            'engine_size'   => $validated['engine_size']  ?? $car->engine_size,
            'fuel_type'     => $validated['fuel_type']    ?? $car->fuel_type,
            'fuel_consumption'   => $validated['fuel_consumption']   ?? $car->fuel_consumption,
            'fuel_tank_capacity' => $validated['fuel_tank_capacity'] ?? $car->fuel_tank_capacity,
            'cylinder_layout'    => $validated['cylinder_layout']    ?? $car->cylinder_layout,
            'kilowatts'          => $validated['kilowatts']          ?? $car->kilowatts,
            'gears'              => $validated['gears']              ?? $car->gears,
            'horse_power'   => $validated['horse_power']  ?? $car->horse_power,
            'transmission'  => $validated['transmission'] ?? $car->transmission,
            'torque'        => $validated['torque']       ?? $car->torque,
            'aspiration'    => $validated['aspiration']   ?? $car->aspiration,
            'acceleration'  => $validated['acceleration'] ?? $car->acceleration,
            'origin'        => $validated['origin'],
            'source'        => $validated['source']       ?? $car->source,
            'specification' => $validated['specification'] ?? $car->specification,
            'running_cost'  => $validated['running_cost'] ?? $car->running_cost,
            'images'        => $images    ?: null,
            'image'         => $mainImage,
            'report'        => $car->report,
            'video'         => $car->video,
        ]);

        return redirect()->route('cars.my')->with('success', '✅ Car updated successfully!');
    }

    /**
     * Delete a car and all associated files.
     */
    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        // Delete cover image
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }

        // Delete all gallery images
        if ($car->images) {
            foreach ($car->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        // Delete report
        if ($car->report) {
            Storage::disk('public')->delete($car->report);
        }

        // Delete video
        if ($car->video) {
            Storage::disk('public')->delete($car->video);
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
