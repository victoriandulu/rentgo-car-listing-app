<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Handle login submission
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials or not an admin']);
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
