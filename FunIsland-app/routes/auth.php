<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\FerryController;
use App\Http\Controllers\ThemeparkController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Hotel Manager Routes
    Route::middleware(['auth', 'role:hotel_manager,administrator'])->group(function () {
        Route::get('/hotels/dashboard', [HotelController::class, 'dashboard'])->name('hotels.dashboard');
        Route::resource('hotels', HotelController::class);
    });

    // Ferry Operator Routes
    Route::middleware(['auth', 'role:ferry_operator,administrator'])->group(function () {
        Route::get('/ferries/dashboard', [FerryController::class, 'dashboard'])->name('ferries.dashboard');
        Route::resource('ferries', FerryController::class);
    });

    // Theme Park Manager Routes
    Route::middleware(['auth', 'role:theme_park_manager,administrator'])->group(function () {
        Route::get('/themeparks/dashboard', [ThemeparkController::class, 'dashboard'])->name('themeparks.dashboard');
        Route::resource('themeparks', ThemeparkController::class);
    });

    // Customer Routes
    Route::middleware(['auth', 'role:customer'])->group(function () {
        Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
        Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
        Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
        Route::get('/ferries', [FerryController::class, 'index'])->name('ferries.index');
        Route::get('/ferries/{ferry}', [FerryController::class, 'show'])->name('ferries.show');
        Route::get('/themeparks', [ThemeparkController::class, 'index'])->name('themeparks.index');
        Route::get('/themeparks/{themepark}', [ThemeparkController::class, 'show'])->name('themeparks.show');
        
        // Booking routes for customers
        Route::post('/hotels/{hotel}/book', [BookingController::class, 'storeHotelBooking'])->name('bookings.hotel.store');
        Route::post('/ferries/{ferry}/book', [BookingController::class, 'storeFerryBooking'])->name('bookings.ferry.store');
        Route::post('/themeparks/{themepark}/book', [BookingController::class, 'storeThemeparkBooking'])->name('bookings.themepark.store');
    });

    // Administrator Routes
    Route::middleware(['auth', 'role:administrator'])->group(function () {
        // Admin overview and system management
        Route::get('/admin/overview', [AdminController::class, 'overview'])->name('admin.overview');
        Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
        
        // User management routes
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
        Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        
        // Role assignment routes
        Route::get('/admin/roles', [AdminController::class, 'roleAssignment'])->name('admin.roles');
        Route::post('/admin/roles/assign', [AdminController::class, 'assignRoles'])->name('admin.roles.assign');
        
        // System statistics and reports
        Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/admin/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    });

    // Staff and Management shared routes (multiple roles can access)
    Route::middleware(['auth', 'role:hotel_manager,ferry_operator,theme_park_manager,ticketing_staff,administrator'])->group(function () {
        // Booking management (staff can view/manage bookings)
        Route::get('/manage/bookings', [BookingController::class, 'manageBookings'])->name('manage.bookings');
        Route::get('/manage/bookings/{booking}', [BookingController::class, 'showBooking'])->name('manage.bookings.show');
        Route::put('/manage/bookings/{booking}', [BookingController::class, 'updateBooking'])->name('manage.bookings.update');
        Route::delete('/manage/bookings/{booking}', [BookingController::class, 'cancelBooking'])->name('manage.bookings.cancel');
    });
});
