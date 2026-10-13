<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserVerification;

class ProfileController extends Controller
{
    /**
     * Show profile info (view-only page).
     */
    public function show()
    {
        $user = auth()->user();

        return view('profile.show', [
            'user' => $user,
            'verification' => $user->verification, // eager load verification record
        ]);
    }

    /**
     * Show profile edit form.
     */
    public function edit()
    {
        $user = auth()->user();

        return view('profile.edit', [
            'user' => $user,
            'verification' => $user->verification,
        ]);
    }

    /**
     * Update profile and verification documents.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        // ✅ Validate input
        $validated = $request->validate([
            'first_name'         => 'required|string|max:255',
            'last_name'          => 'required|string|max:255',
            'email'              => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'              => 'nullable|string|max:20',
            'driver_license'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'proof_of_address'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'additional_docs.*'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'national_id'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'photo'              => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'verification_video' => 'nullable|file|mimes:mp4,mov,avi|max:20480', // 20MB
        ]);

        // ✅ Update user personal info
        // "name" is kept in sync so the navbar and dashboard always show the same name.
        $user->update([
            'name'       => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'phone'      => $request->phone,
        ]);

        // ✅ Handle verification record
        $verification = UserVerification::firstOrNew(['user_id' => $user->id]);

        // Single file uploads
        foreach (['driver_license', 'proof_of_address', 'national_id', 'photo', 'verification_video'] as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store("documents/{$user->id}", 'public');
                $verification->{$field} = $path;
            }
        }

        // Multiple additional documents
        if ($request->hasFile('additional_docs')) {
            $paths = [];
            foreach ($request->file('additional_docs') as $file) {
                $paths[] = $file->store("documents/{$user->id}/additional", 'public');
            }
            $verification->additional_docs = json_encode($paths);
        }

        $verification->user_id = $user->id;
        $verification->save();

        return redirect()
            ->route('profile.show')
            ->with('success', '✅ Profile and documents updated successfully!');
    }
}
