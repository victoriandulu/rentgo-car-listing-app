<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use App\Models\UserVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with users, cars, reports, and verifications.
     * This is the main dashboard with only stat cards.
     */
    public function index()
    {
        // Users (deduplicated by email)
        $users = User::select('id', 'name', 'email', 'is_verified', 'is_admin')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('email')
            ->values();

        // Cars with their owners
        $cars = Car::with('user')->get();

        // Reports = cars that have a report file
        $reports = $cars->filter(fn($car) => !empty($car->report));

        // User verification documents
        $verifications = UserVerification::with('user')->latest()->get();

        return view('admin.dashboard', compact('users', 'cars', 'reports', 'verifications'));
    }

    /**
     * Users Management Page with Pagination and Search
     */
    public function userIndex(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Cars Management Page with Pagination and Search
     */
    public function carIndex(Request $request)
    {
        $query = Car::with('user');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $cars = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Verifications Management Page with Pagination and Search
     */
    public function verificationIndex(Request $request)
    {
        $query = UserVerification::with('user');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($userQuery) use ($search) {
                $userQuery->where('name', 'like', '%' . $search . '%');
            });
        }

        $verifications = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.verifications.index', compact('verifications'));
    }

    /**
     * Reports Management Page with Pagination and Search
     */
    public function reportIndex(Request $request)
    {
        $query = Car::whereNotNull('report')->with('user');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Verify a user.
     */
    public function verifyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            return back()->with('error', 'Admins are always verified.');
        }

        $user->update(['is_verified' => true]);

        return back()->with('success', 'User verified successfully!');
    }

    /**
     * Unverify a user.
     */
    public function unverifyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            return back()->with('error', 'Admins cannot be unverified.');
        }

        $user->update(['is_verified' => false]);

        return back()->with('success', 'User unverified successfully!');
    }

    /**
     * Delete a user and all associated data.
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting admin users
        if ($user->is_admin) {
            return back()->with('error', 'Cannot delete admin users!');
        }

        // Delete user's cars and associated files
        foreach ($user->cars as $car) {
            $this->deleteCarFiles($car);
            $car->delete();
        }

        // Delete user's verification documents
        if ($user->verification) {
            $this->deleteVerificationFiles($user->verification);
            $user->verification->delete();
        }

        // Delete the user
        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }

    /**
     * Delete a car and all its files.
     */
    public function deleteCar($id)
    {
        $car = Car::findOrFail($id);

        // Delete all car files
        $this->deleteCarFiles($car);

        // Delete the car record
        $car->delete();

        return back()->with('success', 'Car deleted successfully!');
    }

    /**
     * Helper: Delete all files associated with a car
     */
    private function deleteCarFiles($car)
    {
        // Delete main image
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }

        // Delete additional images
        if (is_array($car->images)) {
            foreach ($car->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        // Delete report file
        if ($car->report) {
            Storage::disk('public')->delete($car->report);
        }
    }

    /**
     * Helper: Delete all verification files
     */
    private function deleteVerificationFiles($verification)
    {
        $fields = [
            'driver_license',
            'proof_of_address',
            'national_id',
            'photo',
            'verification_video'
        ];

        foreach ($fields as $field) {
            if ($verification->$field) {
                Storage::disk('public')->delete($verification->$field);
            }
        }

        // Delete additional docs
        if (is_array($verification->additional_docs)) {
            foreach ($verification->additional_docs as $doc) {
                Storage::disk('public')->delete($doc);
            }
        }
    }
}
