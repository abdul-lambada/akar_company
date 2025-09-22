<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
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
});
