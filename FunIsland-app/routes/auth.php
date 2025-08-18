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


    // Booking Routes (Hotel Booking without Middleware, Others with Hotel Booking Check)
        Route::post('/hotels/{hotel}/book', [BookingController::class, 'storeHotelBooking'])->name('bookings.hotel.store');
        Route::middleware('has.hotel.booking')->group(function () {
            Route::post('/ferries/{ferry}/book', [BookingController::class, 'storeFerryBooking'])->name('bookings.ferry.store');
            Route::post('/themeparks/{themepark}/book', [BookingController::class, 'storeThemeparkBooking'])->name('bookings.themepark.store');
            Route::post('/events/{event}/book', [EventController::class, 'book'])->name('events.book');
            Route::get('/events/booking/{booking}/confirmation', [EventController::class, 'bookingConfirmation'])->name('events.booking.confirmation');
        });

    // Hotel Manager Routes
    Route::middleware(['auth', 'role:hotel_manager,administrator'])->group(function () {
        Route::get('/hotels/dashboard', [HotelController::class, 'dashboard'])->name('hotels.dashboard');
        Route::get('/hotels/management', [HotelController::class, 'index'])->name('hotels.management.index');
        Route::get('/hotels/management/create', [HotelController::class, 'create'])->name('hotels.management.create');
        Route::post('/hotels/management', [HotelController::class, 'store'])->name('hotels.store');
        Route::get('/hotels/management/{hotel}', [HotelController::class, 'show'])->name('hotels.management.show');
        Route::get('/hotels/management/{hotel}/edit', [HotelController::class, 'edit'])->name('hotels.management.edit');
        Route::put('/hotels/management/{hotel}', [HotelController::class, 'update'])->name('hotels.update');
        Route::delete('/hotels/management/{hotel}', [HotelController::class, 'destroy'])->name('hotels.destroy');
    });

    // Ferry Operator Routes
    Route::middleware(['auth', 'role:ferry_operator,administrator'])->group(function () {
        Route::get('/ferries/dashboard', [FerryController::class, 'dashboard'])->name('ferries.dashboard');
        Route::get('/ferries/management', [FerryController::class, 'index'])->name('ferries.management.index');
        Route::get('/ferries/management/create', [FerryController::class, 'create'])->name('ferries.management.create');
        Route::post('/ferries/management', [FerryController::class, 'store'])->name('ferries.store');
        Route::get('/ferries/management/{ferry}', [FerryController::class, 'show'])->name('ferries.management.show');
        Route::get('/ferries/management/{ferry}/edit', [FerryController::class, 'edit'])->name('ferries.management.edit');
        Route::put('/ferries/management/{ferry}', [FerryController::class, 'update'])->name('ferries.update');
        Route::delete('/ferries/management/{ferry}', [FerryController::class, 'destroy'])->name('ferries.destroy');
        Route::get('/ferries/schedules', [FerryController::class, 'allSchedules'])->name('ferries.all-schedules');
        Route::get('/ferries/management/{ferry}/schedules', [FerryController::class, 'schedules'])->name('ferries.schedules');
        Route::post('/ferries/management/{ferry}/schedules', [FerryController::class, 'storeSchedule'])->name('ferries.schedules.store');
        Route::delete('/ferries/management/{ferry}/schedules/{schedule}', [FerryController::class, 'destroySchedule'])->name('ferries.schedules.destroy');
    });

    // Theme Park Manager Routes
    Route::middleware(['auth', 'role:theme_park_manager,administrator'])->group(function () {
        Route::get('/themeparks/dashboard', [ThemeparkController::class, 'dashboard'])->name('themeparks.dashboard');
        Route::get('/themeparks/management', [ThemeparkController::class, 'index'])->name('themeparks.management.index');
        Route::get('/themeparks/management/create', [ThemeparkController::class, 'create'])->name('themeparks.management.create');
        Route::post('/themeparks/management', [ThemeparkController::class, 'store'])->name('themeparks.store');
        Route::get('/themeparks/management/{themepark}', [ThemeparkController::class, 'show'])->name('themeparks.management.show');
        Route::get('/themeparks/management/{themepark}/edit', [ThemeparkController::class, 'edit'])->name('themeparks.management.edit');
        Route::put('/themeparks/management/{themepark}', [ThemeparkController::class, 'update'])->name('themeparks.update');
        Route::delete('/themeparks/management/{themepark}', [ThemeparkController::class, 'destroy'])->name('themeparks.destroy');
    });

    // Customer Routes
    Route::middleware(['auth', 'role:customer'])->group(function () {
        Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
        // Note: /hotels route is handled in web.php as hotels.customer.index
        Route::get('/hotels/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
        // Note: /ferries route is handled in web.php as ferries.customer.index
        Route::get('/ferries/{ferry}', [FerryController::class, 'show'])->name('ferries.show');
        // Note: /themeparks route is handled in web.php as themeparks.customer.index
        Route::get('/themeparks/{themepark}', [ThemeparkController::class, 'show'])->name('themeparks.show');
        Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
        Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
        
        // Booking routes for customers
        Route::post('/hotels/{hotel}/book', [BookingController::class, 'storeHotelBooking'])->name('bookings.hotel.store');
        Route::post('/ferries/{ferry}/book', [BookingController::class, 'storeFerryBooking'])->name('bookings.ferry.store');
        Route::post('/themeparks/{themepark}/book', [BookingController::class, 'storeThemeparkBooking'])->name('bookings.themepark.store');
        Route::post('/events/{event}/book', [\App\Http\Controllers\EventController::class, 'book'])->name('events.book');
        Route::get('/events/booking/{booking}/confirmation', [\App\Http\Controllers\EventController::class, 'bookingConfirmation'])->name('events.booking.confirmation');
        
        // General booking management
        Route::get('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
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
        Route::get('/admin/roles', [AdminController::class, 'roles'])->name('admin.roles');
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
