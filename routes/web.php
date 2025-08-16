<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\UserProfileController;
// routes/web.php
Route::get('/listings', function () {
    return view('listed-vehicles');
})->name('listings');


// Show Profile Page
Route::get('/profile', [UserProfileController::class, 'index'])->name('profile.index');

// Handle Save Changes (static for now)
Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');


Route::get('/faqs', [FaqController::class, 'index'])->name('faqs');


// Contact Us Page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');


Route::get('/about', [AboutController::class, 'index'])->name('about');


// Sell your car page
Route::get('/sell', [SellController::class, 'index'])->name('sell');

// Handle signup form submission
Route::post('/sell', [SellController::class, 'store'])->name('sell.store');

// (Optional) Login route if you separate login form
Route::post('/sell/login', [SellController::class, 'login'])->name('sell.login');


// Vehicles page
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles');

// Buy Report
Route::post('/vehicles/{id}/buy-report', [VehicleController::class, 'buyReport'])->name('vehicles.buyReport');

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Sell Your Car page
Route::get('/sell', function () {
    return view('sell');
})->name('sell');

// About Us page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Us page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// FAQs page
Route::get('/faqs', function () {
    return view('faqs');
})->name('faqs');

// Vehicle Search (from search bar on Home)
Route::get('/search', [HomeController::class, 'search'])->name('search.vehicle');

// Newsletter subscription
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/welcome', function () {
    return view('welcome');
});
