<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/travel', [TravelController::class, 'index']);
Route::get('/travel/{id}', [TravelController::class, 'show']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::put('/users', [AuthController::class, 'updateProfile']);
    Route::get('/users', [AuthController::class, 'getAllUsers']);
    Route::get('/users/{id}', [AuthController::class, 'getUserById']);

    Route::post('/travel', [TravelController::class, 'addTravel']);
    Route::put('/travel/{id}', [TravelController::class, 'updateTravel']);
    Route::delete('/travel/{id}', [TravelController::class, 'deleteTravel']);

    Route::post('/bookings', [BookingController::class, 'bookTravel']);
    Route::get('/bookings', [BookingController::class, 'getUserBookings']);
    Route::delete('/bookings/{id}', [BookingController::class, 'cancelBooking']);

    Route::post('/payment/{id}', [PaymentController::class, 'processPayment']);
});


