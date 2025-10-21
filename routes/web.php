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
use App\Http\Controllers\Admin\{
    AdminController,
    AdminAuthController
};

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs');

// Vehicles Public
Route::get('/vehicles', [CarController::class, 'publicIndex'])->name('vehicles');
Route::get('/vehicles/{car}', [CarController::class, 'show'])->name('vehicles.show');
Route::post('/vehicles/{id}/buy-report', [CarController::class, 'buyReport'])->name('vehicles.buyReport');

// Search & Newsletter
Route::get('/search', [HomeController::class, 'search'])->name('search.vehicle');
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('newsletter.subscribe');

// Static / Demo Pages
Route::view('/welcome', 'welcome')->name('welcome');
Route::view('/listings', 'listed-vehicles')->name('listings');

/*
|--------------------------------------------------------------------------
| Authentication (Public)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showSellPage'])->name('login');
Route::get('/sell', [AuthController::class, 'showSellPage'])->name('sell');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Dashboard
    Route::get('/dashboard', fn() => redirect()->route('cars.create'))->name('dashboard');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
    });

    // Cars Management (User)
    Route::prefix('cars')->name('cars.')->group(function () {
        Route::get('/my', [CarController::class, 'index'])->name('my');
        Route::get('/create', [CarController::class, 'create'])->name('create');
        Route::post('/', [CarController::class, 'store'])->name('store');
        Route::get('/{car}/edit', [CarController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{car}', [CarController::class, 'update'])->name('update');
        Route::delete('/{car}', [CarController::class, 'destroy'])->name('destroy');
    });

    // Sell Dashboard
    Route::get('/sell/dashboard', [SellController::class, 'showSellPage'])->name('sell.auth');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Auth (Public)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Admin Protected Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Users Management
        Route::get('/users', [AdminController::class, 'userIndex'])->name('users.index');
        Route::get('/users/{id}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
        Route::get('/users/{id}/unverify', [AdminController::class, 'unverifyUser'])->name('users.unverify');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

        // Cars Management (Admin)
        Route::get('/cars', [AdminController::class, 'carIndex'])->name('cars.index');
        Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
        Route::match(['put', 'patch'], '/cars/{car}', [CarController::class, 'update'])->name('cars.update');
        Route::delete('/cars/{id}', [AdminController::class, 'deleteCar'])->name('cars.delete');

        // Verifications Management
        Route::get('/verifications', [AdminController::class, 'verificationIndex'])->name('verifications.index');

        // Reports Management
        Route::get('/reports', [AdminController::class, 'reportIndex'])->name('reports.index');
    });
});
