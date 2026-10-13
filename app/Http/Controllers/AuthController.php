<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

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

        $user = User::create([
            'name'       => $validated['firstName'] . ' ' . $validated['lastName'],
            'first_name' => $validated['firstName'],
            'last_name'  => $validated['lastName'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

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

            if ($user->is_admin) {
                return redirect()->route('admin.dashboard');
            }

            if ($request->query('redirect')) {
                return redirect()->to($request->query('redirect'));
            }

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

    // Google OAuth redirect — stateful (no ->stateless())
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google OAuth callback — must match redirect (stateful, no ->stateless())
    public function handleGoogleCallback(Request $request)
    {
        try {
            // ✅ No ->stateless() here — must match redirectToGoogle()
            $googleUser = Socialite::driver('google')->user();

            // Split the Google name into first / last (Google gives given_name / family_name)
            $fullName  = trim((string) $googleUser->getName());
            $nameParts = explode(' ', $fullName, 2);
            $google    = is_array($googleUser->user ?? null) ? $googleUser->user : [];
            $first     = $google['given_name']  ?? ($nameParts[0] !== '' ? $nameParts[0] : null);
            $last      = $google['family_name'] ?? ($nameParts[1] ?? null);

            $user = User::firstOrNew(['email' => $googleUser->getEmail()]);

            if (!$user->exists) {
                // Brand-new account: set everything, including a random password
                $user->name       = $fullName;
                $user->first_name = $first;
                $user->last_name  = $last;
                $user->password   = Hash::make(Str::random(24));
            } else {
                // Existing account: never overwrite a name the user already has
                // (keeps profile edits) and never reset their password.
                if (empty($user->getAttributes()['name'] ?? null)) {
                    $user->name = $fullName;
                }
                if (empty($user->getAttributes()['first_name'] ?? null)) {
                    $user->first_name = $first;
                }
                if (empty($user->getAttributes()['last_name'] ?? null)) {
                    $user->last_name = $last;
                }
            }

            $user->google_id         = $googleUser->getId();
            $user->email_verified_at = $user->email_verified_at ?? now();
            $user->save();

            Auth::login($user);
            $request->session()->regenerate();

            if ($user->is_admin) {
                return redirect()->route('admin.dashboard');
            }

            if ($request->query('redirect')) {
                return redirect()->to($request->query('redirect'));
            }

            return redirect()->route('cars.create');

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            // State mismatch — usually means the session expired or user hit back button
            Log::error('Google OAuth InvalidStateException: ' . $e->getMessage());
            return redirect()->route('sell')
                ->withErrors(['email' => 'Login session expired. Please try again.']);

        } catch (\Exception $e) {
            // Log the REAL error so you can debug it
            Log::error('Google OAuth failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('sell')
                ->withErrors(['email' => 'Google login failed. Please try again.']);
        }
    }
}
