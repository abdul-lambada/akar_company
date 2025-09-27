<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Signed public route for downloading invoice PDF securely (no auth)
Route::get('/invoice/{invoice}/pdf', [InvoiceController::class, 'publicPdf'])
    ->middleware('signed')
    ->name('invoices.public.pdf');

// Signed public routes for payment status (no auth, but signed)
use App\Http\Controllers\InvoicePublicController;
Route::get('/invoice/{invoice}/status', [InvoicePublicController::class, 'status'])
    ->middleware('signed')
    ->name('invoices.public.status');
Route::post('/invoice/{invoice}/paid', [InvoicePublicController::class, 'confirmPaid'])
    ->middleware('signed')
    ->name('invoices.public.paid');

Route::get('/', [PublicController::class, 'home'])->name('public.index');
// Auto-open pricing modal when hitting /home
Route::get('/home', function() { return redirect()->route('public.index', ['showPricing' => 1]); });
// Public Order (lead-to-order) routes
use App\Http\Controllers\PublicOrderController;
Route::get('/order', [PublicOrderController::class, 'create'])->name('public.order.create');
Route::post('/order', [PublicOrderController::class, 'store'])->name('public.order.store');
Route::get('/order/success', [PublicOrderController::class, 'success'])->name('public.order.success');
Route::get('/services', [PublicController::class, 'services'])->name('public.services');
Route::get('/portfolio', [PublicController::class, 'portfolio'])->name('public.portfolio');
Route::get('/contact', [PublicController::class, 'contact'])->name('public.contact');
Route::post('/contact', [PublicController::class, 'contactSubmit'])->name('public.contact.submit');
Route::get('/about', [PublicController::class, 'about'])->name('public.about');
Route::get('/pricing', [PublicController::class, 'pricing'])->name('public.pricing');
Route::get('/team', [PublicController::class, 'team'])->name('public.team');
Route::get('/team/{slug}', [PublicController::class, 'teamDetail'])->name('public.team-detail');
// Detail pages (avoid conflict with admin resource routes)
Route::get('/service-details/{slug}', [PublicController::class, 'serviceDetail'])->name('public.service-details');
Route::get('/portfolio-details/{portfolio}', [PublicController::class, 'portfolioDetail'])->name('public.portfolio-details');
Route::get('/blog', [PublicController::class, 'blog'])->name('public.blog');
Route::get('/blog/{slug}', [PublicController::class, 'blogDetail'])->name('public.blog-detail');

// Auth routes
Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');



Route::middleware(['auth','role:admin'])->prefix('admin')->group(function () {
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
    Route::get('invoices/{invoice}/pdf', [App\Http\Controllers\InvoiceController::class, 'downloadPdf'])->name('invoices.pdf');
    Route::post('invoices/{invoice}/send-whatsapp', [App\Http\Controllers\InvoiceController::class, 'sendWhatsApp'])->name('invoices.sendWhatsApp');
    Route::post('invoices/{invoice}/send-whatsapp-admin', [App\Http\Controllers\InvoiceController::class, 'sendWhatsAppAdmin'])->name('invoices.sendWhatsAppAdmin');

    // Users
    Route::resource('users', App\Http\Controllers\UserController::class);

    // Settings
    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/whatsapp-test', [\App\Http\Controllers\SettingController::class, 'whatsappTest'])->name('settings.whatsappTest');

    // Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});
