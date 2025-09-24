<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'All Vehicles');

        $query = Vehicle::query();

        if ($category === 'Vehicles in Kenya') {
            $query->where('category', 'Kenya');
        } elseif ($category === 'Imports') {
            $query->where('category', 'Import');
        }

        $vehicles = $query->get();

        return view('vehicles', [
            'vehicles' => $vehicles,
            'category' => $category,
        ]);
    }

    public function buyReport($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return back()->with('message', "Buy report for vehicle: {$vehicle->name}");
    }
}
