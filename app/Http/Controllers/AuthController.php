<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthController extends Controller
{
    // Show the sell page
    public function showSellPage()
    {
        return view('sell');
    }

    // Register a new user
    public function register(Request $request)
{
    $validated = $request->validate([
        'firstName' => 'required|string|max:255',
        'lastName'  => 'required|string|max:255',
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|min:8|confirmed',
    ]);

    $user = \App\Models\User::create([
        'name'     => $validated['firstName'] . ' ' . $validated['lastName'],
        'email'    => $validated['email'],
        'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
    ]);

    Auth::login($user);

    $request->session()->regenerate();

    // ✅ Has redirect param → go back there after registration
    if ($request->query('redirect')) {
        return redirect()->to($request->query('redirect'));
    }

    return redirect()->route('cars.create')
        ->with('success', 'Welcome! Your account has been created.');
}
    // Login an existing user
   public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        // ✅ Admin → go to admin dashboard
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // ✅ Has redirect param (came from vehicles page) → go back there
        if ($request->query('redirect')) {
            return redirect()->to($request->query('redirect'));
        }

        // ✅ Normal user → go to sell/create car page
        return redirect()->route('cars.create');
    }

    return back()
        ->withErrors(['email' => 'These credentials do not match our records.'])
        ->withInput($request->only('email'))
        ->with('login_tab', true);
}
    // Logout the user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sell')
            ->with('success', 'You have been logged out successfully.');
    }

    // Google OAuth redirect
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google OAuth callback
   public function handleGoogleCallback(Request $request)
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = \App\Models\User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name'              => $googleUser->getName(),
                'google_id'         => $googleUser->getId(),
                'password'          => \Illuminate\Support\Facades\Hash::make(
                    \Illuminate\Support\Str::random(24)
                ),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user);
        $request->session()->regenerate();

        // ✅ Admin check
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // ✅ Redirect param
        if ($request->query('redirect')) {
            return redirect()->to($request->query('redirect'));
        }

        return redirect()->route('cars.create');

    } catch (\Exception $e) {
        return redirect()->route('sell')
            ->withErrors(['email' => 'Google login failed. Please try again.']);
    }
}
}
