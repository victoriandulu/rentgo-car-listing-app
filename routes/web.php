<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    SellController,
    AboutController,
    ContactController,
    FaqController,
    AuthController,
    CarController,
    ProfileController
};

// ----------------------------------------------------
// 🌍 Public Routes
// ----------------------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs');

// Vehicles (public)
Route::get('/vehicles', [CarController::class, 'publicIndex'])->name('vehicles');
Route::post('/vehicles/{id}/buy-report', [CarController::class, 'buyReport'])->name('vehicles.buyReport');

// Search & newsletter
Route::get('/search', [HomeController::class, 'search'])->name('search.vehicle');
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('newsletter.subscribe');

// Static/demo pages
Route::get('/welcome', fn () => view('welcome'))->name('welcome');
Route::get('/listings', fn () => view('listed-vehicles'))->name('listings');

// ----------------------------------------------------
// 🔑 Authentication (Public)
// ----------------------------------------------------
Route::get('/login', [AuthController::class, 'showSellPage'])->name('login');
Route::get('/sell', [AuthController::class, 'showSellPage'])->name('sell');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// ----------------------------------------------------
// 🔒 Authenticated Routes (Requires login)
// ----------------------------------------------------
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Dashboard & Profile
    Route::get('/dashboard', fn () => redirect()->route('cars.create'))->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Cars Management
    Route::prefix('cars')->name('cars.')->group(function () {
        Route::get('/my', [CarController::class, 'index'])->name('my');
        Route::get('/create', [CarController::class, 'create'])->name('create');
        Route::post('/', [CarController::class, 'store'])->name('store');
        Route::get('/{car}/edit', [CarController::class, 'edit'])->name('edit');
        Route::put('/{car}', [CarController::class, 'update'])->name('update');
        Route::delete('/{car}', [CarController::class, 'destroy'])->name('destroy');
    });

    // Authenticated Sell Page
    Route::get('/sell/dashboard', [SellController::class, 'showSellPage'])->name('sell.auth');
});
