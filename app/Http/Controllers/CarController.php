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
     * Display a listing of the authenticated user's cars (My Cars).
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
     * Display a public listing of all cars (Vehicles page).
     */
    public function publicVehicles()
    {
        $cars = Car::with('user')->latest()->get(); // eager load dealer info
        return view('vehicles', compact('cars'));
    }
    public function publicIndex(Request $request)
{
    // Optional filter by origin (Kenya / Import / All)
    $category = $request->query('category', 'All Vehicles');

    $cars = Car::with('user')
        ->when($category === 'Vehicles in Kenya', fn($q) => $q->where('origin', 'kenya'))
        ->when($category === 'Imports', fn($q) => $q->where('origin', 'import'))
        ->latest()
        ->get();

    return view('vehicles', compact('cars', 'category'));
}


    /**
     * Show the form for creating a new car.
     */
    public function create()
    {
        $makes = ['Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes-Benz'];
        $modelsByMake = [
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Tacoma'],
            'Honda' => ['Accord', 'Civic', 'CR-V', 'Pilot', 'Odyssey'],
            'Ford' => ['F-150', 'Mustang', 'Explorer', 'Escape', 'Focus'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5', '7 Series'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'S-Class', 'GLC', 'GLE'],
        ];

        $origins = ['kenya', 'import']; // New field options

        return view('cars.create', compact('makes', 'modelsByMake', 'origins'));
    }

    /**
     * Store a newly created car in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'year'          => 'required|integer|min:1900|max:' . date('Y'),
            'location'      => 'nullable|string|max:255',
            'availability'  => 'nullable|string|max:50',
            'drive'         => 'nullable|string|max:50',
            'mileage'       => 'nullable|integer',
            'engine_size'   => 'nullable|string|max:50',
            'fuel_type'     => 'nullable|string|max:50',
            'horse_power'   => 'nullable|integer',
            'transmission'  => 'nullable|string|max:50',
            'torque'        => 'nullable|string|max:50',
            'aspiration'    => 'nullable|string|max:50',
            'acceleration'  => 'nullable|string|max:50',
            'price'         => 'required|numeric|min:0',
            'description'   => 'nullable|string',
            'specification' => 'nullable|array',
            'runningCost'   => 'nullable|array',
            'origin'        => 'required|string|in:kenya,import',
            'source'        => 'nullable|string|max:255',
            'images.*'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('cars', 'public');
            }
        }

        Car::create([
            'user_id'       => auth()->id(),
            'name'          => $validated['name'],
            'year'          => $validated['year'],
            'location'      => $validated['location'] ?? null,
            'availability'  => $validated['availability'] ?? 'pending',
            'drive'         => $validated['drive'] ?? null,
            'mileage'       => $validated['mileage'] ?? null,
            'engine_size'   => $validated['engine_size'] ?? null,
            'fuel_type'     => $validated['fuel_type'] ?? null,
            'horse_power'   => $validated['horse_power'] ?? null,
            'transmission'  => $validated['transmission'] ?? null,
            'torque'        => $validated['torque'] ?? null,
            'aspiration'    => $validated['aspiration'] ?? null,
            'acceleration'  => $validated['acceleration'] ?? null,
            'price'         => $validated['price'],
            'description'   => $validated['description'] ?? null,
            'specification' => isset($validated['specification']) ? json_encode($validated['specification']) : null,
            'running_cost'  => isset($validated['runningCost']) ? json_encode($validated['runningCost']) : null,
            'origin'        => $validated['origin'],
            'source'        => $validated['source'] ?? null,
            'image'         => $imagePaths[0] ?? null,
            'images'        => !empty($imagePaths) ? json_encode($imagePaths) : null,
        ]);

        return redirect()->route('cars.my')->with('success', '🚀 Car listed successfully!');
    }

    /**
     * Show a specific car.
     */
    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing a car.
     */
    public function edit(Car $car)
    {
        $this->authorize('update', $car);

        $makes = ['Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes-Benz'];
        $modelsByMake = [
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Tacoma'],
            'Honda' => ['Accord', 'Civic', 'CR-V', 'Pilot', 'Odyssey'],
            'Ford' => ['F-150', 'Mustang', 'Explorer', 'Escape', 'Focus'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5', '7 Series'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'S-Class', 'GLC', 'GLE'],
        ];

        $origins = ['kenya', 'import'];

        return view('cars.edit', compact('car', 'makes', 'modelsByMake', 'origins'));
    }

    /**
     * Update a car in storage.
     */
    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'year'          => 'required|integer|min:1900|max:' . date('Y'),
            'location'      => 'nullable|string|max:255',
            'availability'  => 'nullable|string|max:50',
            'drive'         => 'nullable|string|max:50',
            'mileage'       => 'nullable|integer',
            'engine_size'   => 'nullable|string|max:50',
            'fuel_type'     => 'nullable|string|max:50',
            'horse_power'   => 'nullable|integer',
            'transmission'  => 'nullable|string|max:50',
            'torque'        => 'nullable|string|max:50',
            'aspiration'    => 'nullable|string|max:50',
            'acceleration'  => 'nullable|string|max:50',
            'price'         => 'required|numeric|min:0',
            'description'   => 'nullable|string',
            'specification' => 'nullable|array',
            'runningCost'   => 'nullable|array',
            'origin'        => 'required|string|in:kenya,import',
            'source'        => 'nullable|string|max:255',
            'images.*'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('cars', 'public');
            }
        }

        $car->update([
            'name'          => $validated['name'],
            'year'          => $validated['year'],
            'location'      => $validated['location'] ?? $car->location,
            'availability'  => $validated['availability'] ?? $car->availability,
            'drive'         => $validated['drive'] ?? $car->drive,
            'mileage'       => $validated['mileage'] ?? $car->mileage,
            'engine_size'   => $validated['engine_size'] ?? $car->engine_size,
            'fuel_type'     => $validated['fuel_type'] ?? $car->fuel_type,
            'horse_power'   => $validated['horse_power'] ?? $car->horse_power,
            'transmission'  => $validated['transmission'] ?? $car->transmission,
            'torque'        => $validated['torque'] ?? $car->torque,
            'aspiration'    => $validated['aspiration'] ?? $car->aspiration,
            'acceleration'  => $validated['acceleration'] ?? $car->acceleration,
            'price'         => $validated['price'],
            'description'   => $validated['description'] ?? $car->description,
            'specification' => isset($validated['specification']) ? json_encode($validated['specification']) : $car->specification,
            'running_cost'  => isset($validated['runningCost']) ? json_encode($validated['runningCost']) : $car->running_cost,
            'origin'        => $validated['origin'],
            'source'        => $validated['source'] ?? $car->source,
            'image'         => $imagePaths[0] ?? $car->image,
            'images'        => !empty($imagePaths) ? json_encode($imagePaths) : $car->images,
        ]);

        return redirect()->route('cars.my')->with('success', '✅ Car updated successfully!');
    }

    /**
     * Remove a car from storage.
     */
    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }

        if ($car->images) {
            foreach (json_decode($car->images, true) as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $car->delete();

        return redirect()->route('cars.my')->with('success', '🚗 Car deleted successfully!');
    }
}
