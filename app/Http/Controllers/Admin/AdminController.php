<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with users, cars, and reports (from cars).
     */
    public function index()
    {
        // Unique users by email
        $users = User::select('id', 'name', 'email', 'is_verified', 'is_admin')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('email')
            ->values();

        // Get all cars with their owners
        $cars = Car::with('user')->get();

        // Reports = cars that have a report file
        $reports = $cars->filter(fn($car) => !empty($car->report));

        return view('admin.dashboard', compact('users', 'cars', 'reports'));
    }

    /**
     * Verify a user (admins are always verified automatically).
     */
    public function verifyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            return redirect()->back()->with('error', 'Admins are always verified.');
        }

        $user->is_verified = true;
        $user->save();

        return redirect()->back()->with('success', 'User verified successfully!');
    }

    /**
     * Unverify a user (cannot unverify admins).
     */
    public function unverifyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            return redirect()->back()->with('error', 'Admins cannot be unverified.');
        }

        $user->is_verified = false;
        $user->save();

        return redirect()->back()->with('success', 'User unverified successfully!');
    }

    /**
     * Delete a user.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    /**
     * Delete a car (removes images & reports from storage too).
     */
    public function deleteCar($id)
    {
        $car = Car::findOrFail($id);

        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }

        if (!empty($car->images) && is_array($car->images)) {
            foreach ($car->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        if ($car->report) {
            Storage::disk('public')->delete($car->report);
        }

        $car->delete();

        return redirect()->back()->with('success', 'Car deleted successfully!');
    }
}
