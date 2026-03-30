<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\ReportPayment;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Submit M-Pesa payment — user must be logged in
     */
    public function submitReportPayment(Request $request, $car)
    {
        $carModel = Car::findOrFail($car);

        $validated = $request->validate([
            'mpesa_code' => 'required|string|min:8|max:12',
            'amount'     => 'required|numeric|min:0',
        ]);

        // Prevent duplicate code submissions
        if (ReportPayment::where('mpesa_code', strtoupper($validated['mpesa_code']))->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This M-Pesa code has already been submitted. Contact support if this is an error.'
            ]);
        }

        // Check if user already has a pending/verified payment for this car
        $existing = ReportPayment::where('car_id', $carModel->id)
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'verified'])
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => $existing->status === 'verified'
                    ? 'You already have access to this report.'
                    : 'You already have a pending payment for this vehicle.'
            ]);
        }

        ReportPayment::create([
            'car_id'     => $carModel->id,
            'user_id'    => auth()->id(),
            'mpesa_code' => strtoupper($validated['mpesa_code']),
            'phone'      => auth()->user()->phone ?? '',
            'amount'     => $validated['amount'],
            'status'     => 'pending',
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Check report payment status for logged-in user
     */
    public function reportStatus(Request $request, $car)
    {
        $payment = ReportPayment::where('car_id', $car)
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        if (!$payment) {
            return response()->json(['verified' => false, 'reason' => 'not_found']);
        }

        if ($payment->status === 'verified') {
            return response()->json(['verified' => true]);
        }

        if ($payment->status === 'rejected') {
            return response()->json(['verified' => false, 'reason' => 'rejected']);
        }

        return response()->json(['verified' => false, 'reason' => 'pending']);
    }

    /**
     * View report — logged-in user must have a verified payment
     */
    public function viewReport(Request $request, $car)
    {
        $carModel = Car::findOrFail($car);

        if (!$carModel->report) {
            abort(404, 'No report available for this vehicle.');
        }

        $payment = ReportPayment::where('car_id', $carModel->id)
            ->where('user_id', auth()->id())
            ->where('status', 'verified')
            ->first();

        if (!$payment) {
            $pending = ReportPayment::where('car_id', $carModel->id)
                ->where('user_id', auth()->id())
                ->where('status', 'pending')
                ->first();

            $rejected = ReportPayment::where('car_id', $carModel->id)
                ->where('user_id', auth()->id())
                ->where('status', 'rejected')
                ->first();

            return view('vehicles.report-locked', [
                'car'    => $carModel,
                'reason' => $pending ? 'pending' : ($rejected ? 'rejected' : 'not_paid'),
            ]);
        }

        return view('vehicles.report-view', [
            'car'     => $carModel,
            'payment' => $payment,
        ]);
    }
}
