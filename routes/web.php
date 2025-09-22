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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // CRUD Master Data
    Route::resource('categories', CategoryController::class)->parameters([
        'categories' => 'category'
    ])->except(['show']);
    Route::resource('services', ServiceController::class)->parameters([
        'services' => 'service'
    ])->except(['show']);

    // CRUD Content
    Route::resource('posts', PostController::class)->parameters([
        'posts' => 'post'
    ])->except(['show']);
    Route::resource('portfolio', PortfolioController::class)->parameters([
        'portfolio' => 'portfolio'
    ])->except(['show']);
    Route::resource('testimonials', TestimonialController::class)->parameters([
        'testimonials' => 'testimonial'
    ])->except(['show']);

    // CRUD Sales
    Route::resource('orders', OrderController::class)->parameters([
        'orders' => 'order'
    ])->except(['show']);

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
});
