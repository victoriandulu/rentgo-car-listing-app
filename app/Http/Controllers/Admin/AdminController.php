<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use App\Models\UserVerification;
use App\Models\ReportPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'is_verified', 'is_admin')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('email')
            ->values();

        $cars = Car::with('user')->get();

        $reports = $cars->filter(fn($car) => !empty($car->report));

        $verifications = UserVerification::with('user')->latest()->get();

        $pendingPayments = ReportPayment::with('car')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $allPayments = ReportPayment::with('car')
            ->latest()
            ->get();

        return view('admin.dashboard', compact(
            'users',
            'cars',
            'reports',
            'verifications',
            'pendingPayments',
            'allPayments'
        ));
    }

    /**
     * Users Management
     */
    public function userIndex(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Cars Management
     */
    public function carIndex(Request $request)
    {
        $query = Car::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $search . '%'));
            });
        }

        $cars = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Verifications Management
     */
    public function verificationIndex(Request $request)
    {
        $query = UserVerification::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn($u) => $u->where('name', 'like', '%' . $search . '%'));
        }

        $verifications = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.verifications.index', compact('verifications'));
    }

    /**
     * Reports Management
     */
    public function reportIndex(Request $request)
    {
        $query = Car::whereNotNull('report')->with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $search . '%'));
            });
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Verify a user
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
     * Unverify a user
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
     * Delete a user and all associated data
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_admin) {
            return back()->with('error', 'Cannot delete admin users!');
        }

       foreach ($user->cars ?? [] as $car) {
    $this->deleteCarFiles($car);
    $car->delete();
}

        if ($user->verification) {
            $this->deleteVerificationFiles($user->verification);
            $user->verification->delete();
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }

    /**
     * Delete a car
     */
    public function deleteCar($id)
    {
        $car = Car::findOrFail($id);
        $this->deleteCarFiles($car);
        $car->delete();

        return back()->with('success', 'Car deleted successfully!');
    }

    /**
     * Update report price for a car
     */
    public function updateReportPrice(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $validated = $request->validate([
            'report_price' => 'nullable|numeric|min:0'
        ]);

        $car->update(['report_price' => $validated['report_price']]);

        return back()->with('success', 'Report price updated successfully!');
    }

    /**
     * Upload report PDF for a car
     */
    public function uploadReport(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $request->validate([
            'report'       => 'required|file|mimes:pdf|max:10240',
            'report_price' => 'nullable|numeric|min:0'
        ]);

        if ($car->report) {
            Storage::disk('public')->delete($car->report);
        }

        $reportPath = $request->file('report')->store('reports', 'public');

        $car->update([
            'report'       => $reportPath,
            'report_price' => $request->report_price
        ]);

        return back()->with('success', 'Report uploaded successfully!');
    }

    /**
     * Delete report from a car
     */
    public function deleteReport($id)
    {
        $car = Car::findOrFail($id);

        if (!$car->report) {
            return back()->with('error', 'No report found to delete!');
        }

        Storage::disk('public')->delete($car->report);
        $car->update(['report' => null, 'report_price' => null]);

        return back()->with('success', 'Report deleted successfully!');
    }

    /**
     * Toggle car status between available / sold
     */
    public function toggleCarStatus($id)
    {
        $car       = Car::findOrFail($id);
        $newStatus = $car->status === 'available' ? 'sold' : 'available';
        $car->update(['status' => $newStatus]);

        return back()->with('success', "Car status changed to {$newStatus}!");
    }

    /**
     * Verify or reject an M-Pesa report payment (AJAX)
     */
    public function verifyReportPayment(ReportPayment $payment, Request $request)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected'
        ]);

        $payment->update([
            'status'      => $request->status,
            'verified_at' => $request->status === 'verified' ? now() : null,
            'verified_by' => auth()->id(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Bulk delete cars
     */
    public function bulkDeleteCars(Request $request)
    {
        $request->validate([
            'car_ids'   => 'required|array',
            'car_ids.*' => 'exists:cars,id'
        ]);

        $cars = Car::whereIn('id', $request->car_ids)->get();

        foreach ($cars as $car) {
            $this->deleteCarFiles($car);
            $car->delete();
        }

        return back()->with('success', count($request->car_ids) . ' cars deleted successfully!');
    }

    /**
     * Helper: delete all files attached to a car
     */
    private function deleteCarFiles(Car $car): void
    {
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }

        if (is_array($car->images)) {
            foreach ($car->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        if ($car->report) {
            Storage::disk('public')->delete($car->report);
        }
    }

    /**
     * Helper: delete all files attached to a verification record
     */
    private function deleteVerificationFiles(UserVerification $verification): void
    {
        foreach (['driver_license', 'proof_of_address', 'national_id', 'photo', 'verification_video'] as $field) {
            if ($verification->$field) {
                Storage::disk('public')->delete($verification->$field);
            }
        }

        if (is_array($verification->additional_docs)) {
            foreach ($verification->additional_docs as $doc) {
                Storage::disk('public')->delete($doc);
            }
        }
    }
}
