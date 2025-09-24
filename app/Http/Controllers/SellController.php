<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellController extends Controller
{
    // Show Sell Your Car page
    public function showSellPage()
    {
        return view('sell');
    }

    // Handle form submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // TODO: Save seller to database (e.g., User model)
        // User::create([...]);

        return redirect()->route('sell')->with('success', 'Account created successfully! You can now sell your car.');
    }

    // Example login handler (simplified)
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // TODO: Auth attempt
        // if (Auth::attempt($validated)) {
        //     return redirect()->route('dashboard');
        // }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}
