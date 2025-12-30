<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Models\Movie;
use App\Http\Controllers\BookingController;

// Use HomeController
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Movie Detail
Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

// Theater Routes
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\PaymentController;

Route::get('/theaters', [TheaterController::class, 'index'])->name('theaters.index');
Route::get('/theaters/{id}', [TheaterController::class, 'show'])->name('theaters.show');

// Payment & Ticket Routes
Route::post('/payment', [PaymentController::class, 'index'])->name('payment.index'); // Show Payment Page (POST from Booking)
Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/payment/resume/{id}', [PaymentController::class, 'resume'])->name('payment.resume');
Route::get('/payment/complete/{id}', [PaymentController::class, 'complete'])->name('payment.complete');
Route::get('/tickets/{id}', [PaymentController::class, 'showTicket'])->name('tickets.show');

// History Route
use App\Http\Controllers\HistoryController;
Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
Route::post('/history/rate', [HistoryController::class, 'storeReview'])->name('history.rate');

// Customer Service Route
Route::view('/customer-service', 'pages.customer_service')->name('customer_service');
Route::view('/notification', 'pages.notification')->name('notification');
Route::view('/profile', 'pages.profile')->name('profile');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');

    // Admin Dashboard
    Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard')->middleware('isAdmin');

    // Movie Management
    // Movie Management
    Route::resource('/admin/movies', \App\Http\Controllers\Admin\MovieController::class, ['names' => 'admin.movies'])->middleware('isAdmin');

    // Schedule Management
    Route::resource('/admin/schedules', \App\Http\Controllers\Admin\ScheduleController::class, ['names' => 'admin.schedules'])->middleware('isAdmin');

    // Transaction Verification
    Route::get('/admin/transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.transactions.index')->middleware('isAdmin');
    Route::put('/admin/transactions/{id}', [\App\Http\Controllers\Admin\TransactionController::class, 'update'])->name('admin.transactions.update')->middleware('isAdmin');

    // Theater Management
    Route::resource('/admin/theaters', \App\Http\Controllers\Admin\TheaterController::class, ['names' => 'admin.theaters'])->middleware('isAdmin');

    // Analytics
    Route::get('/admin/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.analytics.index')->middleware('isAdmin');

    // Location Management
    Route::resource('/admin/locations', \App\Http\Controllers\Admin\LocationController::class, ['names' => 'admin.locations'])->middleware('isAdmin');
});

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
