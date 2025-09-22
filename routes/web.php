<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $todaySalesCount = \App\Models\Order::whereDate('created_at', now()->toDateString())->count();
        $monthRevenue = \App\Models\Order::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');
        $yearCustomers = \App\Models\Client::whereYear('created_at', now()->year)->count();

        return view('dashboard', compact('todaySalesCount', 'monthRevenue', 'yearCustomers'));
    })->name('dashboard');

    // CRUD Master Data
    Route::resource('categories', CategoryController::class)->parameters([
        'categories' => 'category'
    ]);
    Route::resource('services', ServiceController::class)->parameters([
        'services' => 'service'
    ]);

    // CRUD Content
    Route::resource('posts', PostController::class)->parameters([
        'posts' => 'post'
    ]);
    Route::resource('portfolio', PortfolioController::class)->parameters([
        'portfolio' => 'portfolio'
    ]);
    Route::resource('testimonials', TestimonialController::class)->parameters([
        'testimonials' => 'testimonial'
    ]);

    // CRUD Sales
    Route::resource('orders', OrderController::class)->parameters([
        'orders' => 'order'
    ]);

    // CRM
    Route::resource('clients', ClientController::class)->parameters([
        'clients' => 'client'
    ]);

    // Billing
    Route::resource('invoices', InvoiceController::class)->parameters([
        'invoices' => 'invoice'
    ]);

    // Users management
    Route::resource('users', UserController::class)->parameters([
        'users' => 'user'
    ]);

    // Settings
    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');

    // Profile (user sendiri)
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});
