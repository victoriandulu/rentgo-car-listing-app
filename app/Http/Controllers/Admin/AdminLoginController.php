<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // Your admin login blade
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt(array_merge($credentials, ['is_admin' => 1]), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard'); // Redirect admin
        }

        return back()->withErrors([
            'email' => 'Invalid credentials or not an admin.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
