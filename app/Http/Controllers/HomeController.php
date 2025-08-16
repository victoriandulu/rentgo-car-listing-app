<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Show Home Page
    public function index()
    {
        return view('home');
    }

    // Handle Vehicle Search
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Later you can implement search logic using a Car model
        return back()->with('message', "Search results for: " . $query);
    }

    // Handle Newsletter Subscription
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Save to DB or Send Mail (placeholder)
        // Newsletter::create(['email' => $request->email]);

        return back()->with('success', 'Thanks for subscribing!');
    }
}
