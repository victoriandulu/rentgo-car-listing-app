<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'email'            => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'            => 'nullable|string|max:20',
            'driver_license'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'proof_of_address' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'additional_doc'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Save user info
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'phone'      => $request->phone,
        ]);

        // Save documents
        foreach (['driver_license', 'proof_of_address', 'additional_doc'] as $docField) {
            if ($request->hasFile($docField)) {
                $path = $request->file($docField)->store("documents/{$user->id}", 'public');
                $user->{$docField} = $path;
            }
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', '✅ Profile and documents updated successfully!');
    }
}
