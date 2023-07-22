<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewControllers\AuthController;
use App\Http\Controllers\ViewControllers\DashboardController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ViewControllers\HistoryController;
use App\Http\Controllers\ViewControllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/bookings/{id}', [DashboardController::class, 'bookTravel'])->name('bookTravel');
    Route::get('/bookings', [HistoryController::class, 'index'])->name('bookings');
    Route::delete('/bookings/{bookingId}', [HistoryController::class, 'cancelBooking'])->name('cancelBooking');

    Route::post('/payment/{bookingId}', [HistoryController::class, 'payBooking'])->name('payBooking');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('editProfile');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('updateProfile');    
    
});


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

