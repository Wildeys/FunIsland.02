<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\FerryController;
use App\Http\Controllers\ThemeparkController;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication required for all API routes
Route::middleware('auth:sanctum')->group(function () {
    
    // User information
    Route::get('/user', function (Request $request) {
        return $request->user()->load('role');
    });

    // Hotels API
    Route::apiResource('hotels', HotelController::class);
    Route::get('/hotels/{hotel}/availability', [HotelController::class, 'checkAvailability']);
    Route::get('/hotels/{hotel}/rooms', [HotelController::class, 'getRooms']);

    // Ferries API
    Route::apiResource('ferries', FerryController::class);
    Route::get('/ferries/{ferry}/schedules', [FerryController::class, 'getSchedules']);
    Route::get('/ferries/{ferry}/availability', [FerryController::class, 'checkAvailability']);

    // Theme Parks API
    Route::apiResource('themeparks', ThemeparkController::class);
    Route::get('/themeparks/{themepark}/activities', [ThemeparkController::class, 'getActivities']);
    Route::get('/themeparks/{themepark}/availability', [ThemeparkController::class, 'checkAvailability']);

    // Bookings API
    Route::apiResource('bookings', BookingController::class);
    Route::get('/my-bookings', [BookingController::class, 'myBookings']);
    Route::put('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);
    Route::put('/bookings/{booking}/confirm', [BookingController::class, 'confirm']);

    // Search API
    Route::get('/search/hotels', [HotelController::class, 'search']);
    Route::get('/search/ferries', [FerryController::class, 'search']);
    Route::get('/search/themeparks', [ThemeparkController::class, 'search']);
    Route::get('/search/all', function (Request $request) {
        $query = $request->get('q');
        return [
            'hotels' => app(HotelController::class)->search($request),
            'ferries' => app(FerryController::class)->search($request),
            'themeparks' => app(ThemeparkController::class)->search($request),
        ];
    });
});

// Public API routes (no authentication required)
Route::get('/locations', function () {
    return \App\Models\Location::all();
});

Route::get('/public/hotels', [HotelController::class, 'publicIndex']);
Route::get('/public/ferries', [FerryController::class, 'publicIndex']);
Route::get('/public/themeparks', [ThemeparkController::class, 'publicIndex']);

// Health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});