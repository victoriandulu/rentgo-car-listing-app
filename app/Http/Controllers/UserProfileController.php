<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    // Show static profile page
    public function index()
    {
        return view('user-profile');
    }

    // Handle form submission (for now, just dump request data)
    public function update(Request $request)
    {
        // You can just log or dump data for now
        // Later you will save it in DB when auth is ready
        return back()->with('success', 'Profile updated successfully (static mode)');
    }
}
