<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/services', [PublicController::class, 'services'])->name('public.services');
Route::get('/portfolio', [PublicController::class, 'portfolio'])->name('public.portfolio');
Route::get('/contact', [PublicController::class, 'contact'])->name('public.contact');
// Detail pages (avoid conflict with admin resource routes)
Route::get('/service-details/{slug}', [PublicController::class, 'serviceDetail'])->name('public.service-details');
Route::get('/portfolio-details/{portfolio}', [PublicController::class, 'portfolioDetail'])->name('public.portfolio-details');

// Auth scaffolding routes are not auto-registered because laravel/ui is not installed.
// If you need authentication routes, install Breeze/Fortify or define custom routes.
// Auth::routes();

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AuthController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', App\Http\Controllers\CategoryController::class);

    // Services
    Route::resource('services', App\Http\Controllers\ServiceController::class);

    // Posts
    Route::resource('posts', App\Http\Controllers\PostController::class);

    // Portfolio
    Route::resource('portfolio', App\Http\Controllers\PortfolioController::class);

    // Testimonials
    Route::resource('testimonials', App\Http\Controllers\TestimonialController::class);

    // Orders
    Route::resource('orders', App\Http\Controllers\OrderController::class);

    // Clients
    Route::resource('clients', App\Http\Controllers\ClientController::class);

    // Invoices
    Route::resource('invoices', App\Http\Controllers\InvoiceController::class);

    // Users
    Route::resource('users', App\Http\Controllers\UserController::class);

    // Settings
    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');

    // Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
