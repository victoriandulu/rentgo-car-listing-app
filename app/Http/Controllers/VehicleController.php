<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // Hardcoded data (later can come from DB)
    private $vehicles = [
        [
            'id' => 'KAA001B',
            'name' => '2020 Toyota Prado TX-L',
            'price' => 4500000,
            'reportPrice' => 100,
            'specs' => '2.8L Diesel, 4WD, Automatic, 45,000 km',
            'dealer' => 'Premium Motors Kenya',
            'category' => 'Kenya',
            'image' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=400&h=250&fit=crop',
        ],
        [
            'id' => 'IMP002C',
            'name' => '2019 BMW X5 xDrive40i',
            'price' => 6200000,
            'reportPrice' => 100,
            'specs' => '3.0L Petrol, AWD, Automatic, 32,000 km',
            'dealer' => 'Elite Auto Imports',
            'category' => 'Import',
            'image' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&h=250&fit=crop',
        ],
        [
            'id' => 'KAA003D',
            'name' => '2021 Nissan X-Trail',
            'price' => 3800000,
            'reportPrice' => 100,
            'specs' => '2.5L Petrol, AWD, CVT, 28,000 km',
            'dealer' => 'Nairobi Auto Mart',
            'category' => 'Kenya',
            'image' => 'https://images.unsplash.com/photo-1494905998402-395d579af36f?w=400&h=250&fit=crop',
        ],
        [
            'id' => 'IMP004E',
            'name' => '2020 Mercedes-Benz GLC 300',
            'price' => 7500000,
            'reportPrice' => 100,
            'specs' => '2.0L Turbo, 4MATIC, Automatic, 25,000 km',
            'dealer' => 'Luxury Imports Ltd',
            'category' => 'Import',
            'image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?w=400&h=250&fit=crop',
        ],
        [
            'id' => 'KAA005F',
            'name' => '2022 Toyota Hilux Double Cab',
            'price' => 4200000,
            'reportPrice' => 100,
            'specs' => '2.8L Diesel, 4WD, Manual, 15,000 km',
            'dealer' => 'Mombasa Motors',
            'category' => 'Kenya',
            'image' => 'https://images.unsplash.com/photo-1544636331-e26879cd4d9b?w=400&h=250&fit=crop',
        ],
        [
            'id' => 'IMP006G',
            'name' => '2019 Audi Q7 Premium Plus',
            'price' => 8200000,
            'reportPrice' => 100,
            'specs' => '3.0L TFSI, Quattro, Automatic, 38,000 km',
            'dealer' => 'German Auto House',
            'category' => 'Import',
            'image' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?w=400&h=250&fit=crop',
        ],
    ];

    public function index(Request $request)
    {
        $category = $request->query('category', 'All Vehicles');
        $vehicles = $this->vehicles;

        if ($category !== 'All Vehicles') {
            $vehicles = array_filter($vehicles, function ($vehicle) use ($category) {
                if ($category === 'Vehicles in Kenya') {
                    return $vehicle['category'] === 'Kenya';
                } elseif ($category === 'Imports') {
                    return $vehicle['category'] === 'Import';
                }
                return true;
            });
        }

        return view('vehicles', [
            'vehicles' => $vehicles,
            'category' => $category,
        ]);
    }

    public function buyReport($id)
    {
        // In real app -> redirect to checkout/payment
        return back()->with('message', "Buy report for vehicle ID: $id");
    }
}
