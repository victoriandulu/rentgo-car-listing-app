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
    VehicleController,
    ProfileController
};
use App\Http\Controllers\Admin\{
    AdminController,
    AdminAuthController,
    HeroSlideController
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

Route::get('/search', [HomeController::class, 'search'])->name('search.vehicle');
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('newsletter.subscribe');

Route::view('/welcome', 'welcome')->name('welcome');
Route::view('/listings', 'listed-vehicles')->name('listings');

/*
|--------------------------------------------------------------------------
| Vehicles — Public listing, protected report access
|--------------------------------------------------------------------------
*/
Route::get('/vehicles', [CarController::class, 'publicIndex'])->name('vehicles');
Route::get('/vehicles/{car}', [CarController::class, 'show'])->name('vehicles.show');

/*
|--------------------------------------------------------------------------
| Authentication (Public)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showSellPage'])->name('login');
Route::get('/sell', [AuthController::class, 'showSellPage'])->name('sell');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/dashboard', fn() => redirect()->route('cars.create'))->name('dashboard');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
    });

    // Cars Management
    Route::prefix('cars')->name('cars.')->group(function () {
        Route::get('/my', [CarController::class, 'index'])->name('my');
        Route::get('/create', [CarController::class, 'create'])->name('create');
        Route::post('/', [CarController::class, 'store'])->name('store');
        Route::get('/{car}/edit', [CarController::class, 'edit'])->name('edit');
        Route::match(['put', 'patch'], '/{car}', [CarController::class, 'update'])->name('update');
        Route::delete('/{car}', [CarController::class, 'destroy'])->name('destroy');
    });

    Route::get('/sell/dashboard', [SellController::class, 'showSellPage'])->name('sell.auth');

    // ✅ Report routes — ALL require login
    Route::post('/vehicles/{car}/submit-report-payment', [VehicleController::class, 'submitReportPayment'])
        ->name('vehicles.submitReportPayment');

    Route::get('/vehicles/{car}/report-status', [VehicleController::class, 'reportStatus'])
        ->name('vehicles.report-status');

    Route::get('/vehicles/{car}/report', [VehicleController::class, 'viewReport'])
        ->name('vehicles.report');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::get('/users', [AdminController::class, 'userIndex'])->name('users.index');
        Route::get('/users/{id}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
        Route::get('/users/{id}/unverify', [AdminController::class, 'unverifyUser'])->name('users.unverify');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

        Route::get('/cars', [AdminController::class, 'carIndex'])->name('cars.index');
        Route::get('/cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
        Route::match(['put', 'patch'], '/cars/{car}', [CarController::class, 'update'])
            ->name('cars.update');
        Route::delete('/cars/{id}', [AdminController::class, 'deleteCar'])->name('cars.delete');
        Route::patch('/cars/{car}/update-report-price', [AdminController::class, 'updateReportPrice'])
            ->name('cars.update-report-price');

        Route::get('/verifications', [AdminController::class, 'verificationIndex'])
            ->name('verifications.index');
        Route::get('/reports', [AdminController::class, 'reportIndex'])->name('reports.index');

        // Home page sliding images (admin managed)
        Route::prefix('hero-slides')->name('hero-slides.')->group(function () {
            Route::get('/', [HeroSlideController::class, 'index'])->name('index');
            Route::post('/', [HeroSlideController::class, 'store'])->name('store');
            Route::get('/{heroSlide}/edit', [HeroSlideController::class, 'edit'])->name('edit');
            Route::put('/{heroSlide}', [HeroSlideController::class, 'update'])->name('update');
            Route::patch('/{heroSlide}/toggle', [HeroSlideController::class, 'toggle'])->name('toggle');
            Route::delete('/{heroSlide}', [HeroSlideController::class, 'destroy'])->name('destroy');
        });

        Route::post('/report-payments/{payment}/verify', [AdminController::class, 'verifyReportPayment'])
            ->name('report-payments.verify');
    });
});
