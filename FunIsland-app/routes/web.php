<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\FerryController;
use App\Http\Controllers\ThemeparkController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BeachController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ============================================================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================================================

// Homepage
Route::get('/', function () {
    $activeBanner = \App\Models\AdvertisementBanner::getCurrentBanner();
    return view('welcome', compact('activeBanner'));
})->name('home');

// Public browsing routes (accessible without login)
Route::get('/browse/hotels', [HotelController::class, 'browse'])->name('browse.hotels');
Route::get('/browse/ferries', [FerryController::class, 'browse'])->name('browse.ferries');
Route::get('/browse/themeparks', [ThemeparkController::class, 'browse'])->name('browse.themeparks');
Route::get('/browse/events', [EventController::class, 'browse'])->name('browse.events');
Route::get('/browse/beaches', [BeachController::class, 'browse'])->name('browse.beaches');

// Interactive Map (accessible to all)
Route::get('/map', [LocationController::class, 'map'])->name('locations.map');
Route::get('/api/locations', [LocationController::class, 'getLocationData'])->name('api.locations');
Route::get('/api/locations/{id}', [LocationController::class, 'getLocationDetails'])->name('api.locations.details');

// About/Info pages
Route::get('/about', function () { return view('pages.about'); })->name('about');
Route::get('/contact', function () { return view('pages.contact'); })->name('contact');
Route::get('/privacy', function () { return view('pages.privacy'); })->name('privacy');
Route::get('/terms', function () { return view('pages.terms'); })->name('terms');

// ============================================================================
// CUSTOMER ROUTES (Authenticated Users)
// ============================================================================

Route::middleware('auth')->group(function () {
    
    // Dashboard (role-based routing handled in dashboard.blade.php)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Service Index Pages (Customer View)
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.customer.index');
    Route::get('/ferries', [FerryController::class, 'index'])->name('ferries.customer.index');
    Route::get('/themeparks', [ThemeparkController::class, 'index'])->name('themeparks.customer.index');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/beaches', [BeachController::class, 'index'])->name('beaches.customer.index');
    Route::get('/beaches/{id}', [BeachController::class, 'show'])->name('beaches.show');

    // Service Booking Routes
    Route::post('/hotels/book', [HotelController::class, 'book'])->name('hotels.book');
    Route::post('/ferries/book', [FerryController::class, 'book'])->middleware('require.hotel.booking')->name('ferries.book');
    Route::post('/themeparks/book', [ThemeparkController::class, 'book'])->middleware('require.hotel.booking')->name('themeparks.book');
    Route::post('/beaches/book', [BeachController::class, 'book'])->name('beaches.book');

    // Customer Booking Management
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    
    // Specific booking type routes
    Route::post('/hotels/{hotel}/book', [BookingController::class, 'hotelBooking'])->name('hotels.book');
    Route::post('/ferries/{ferry}/book', [BookingController::class, 'ferryBooking'])->name('ferries.book');
    Route::post('/themeparks/{themepark}/book', [BookingController::class, 'themeparkBooking'])->name('themeparks.book');
    Route::post('/events/{event}/book', [BookingController::class, 'eventBooking'])->name('events.book');
    
    // Booking management routes
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/staff', [BookingController::class, 'staffView'])->name('bookings.staff');
});

// ============================================================================
// STAFF ROUTES (Hotel Staff - View Only)
// ============================================================================

Route::middleware(['auth', 'role:hotel_staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/hotels', [HotelController::class, 'staffView'])->name('hotels');
    Route::get('/bookings', [BookingController::class, 'staffView'])->name('bookings');
});

// ============================================================================
// MANAGEMENT ROUTES (Managers - Role-Specific Access)
// ============================================================================

Route::middleware(['auth', 'management'])->prefix('management')->name('management.')->group(function () {
    
    // General management dashboard
    Route::get('/dashboard', function () {
        return view('management.dashboard');
    })->name('dashboard');

    // Hotel Management Routes
    Route::middleware(['permission:canManageHotels'])->prefix('hotels')->name('hotels.')->group(function () {
        Route::get('/', [HotelController::class, 'index'])->name('index');
        Route::get('/dashboard', [HotelController::class, 'dashboard'])->name('dashboard');
        Route::get('/create', [HotelController::class, 'create'])->name('create');
        Route::post('/', [HotelController::class, 'store'])->name('store');
        Route::get('/{hotel}', [HotelController::class, 'show'])->name('show');
        Route::get('/{hotel}/edit', [HotelController::class, 'edit'])->name('edit');
        Route::put('/{hotel}', [HotelController::class, 'update'])->name('update');
        Route::delete('/{hotel}', [HotelController::class, 'destroy'])->name('destroy');
        Route::get('/{hotel}/bookings', [HotelController::class, 'bookings'])->name('bookings');
        
        // Hotel-specific booking management
        Route::get('/bookings', [BookingController::class, 'hotelManagerBookings'])->name('bookings.index');
        Route::get('/bookings/pending', [BookingController::class, 'pendingHotelBookings'])->name('bookings.pending');
        Route::patch('/bookings/{booking}/approve', [BookingController::class, 'approveBooking'])->name('bookings.approve');
        Route::patch('/bookings/{booking}/reject', [BookingController::class, 'rejectBooking'])->name('bookings.reject');
        Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    });

    // Ferry Management Routes
    Route::middleware(['permission:canManageFerries'])->prefix('ferries')->name('ferries.')->group(function () {
        Route::get('/', [FerryController::class, 'index'])->name('index');
        Route::get('/dashboard', [FerryController::class, 'dashboard'])->name('dashboard');
        Route::get('/create', [FerryController::class, 'create'])->name('create');
        Route::post('/', [FerryController::class, 'store'])->name('store');
        Route::get('/{ferry}', [FerryController::class, 'show'])->name('show');
        Route::get('/{ferry}/edit', [FerryController::class, 'edit'])->name('edit');
        Route::put('/{ferry}', [FerryController::class, 'update'])->name('update');
        Route::delete('/{ferry}', [FerryController::class, 'destroy'])->name('destroy');
        Route::get('/{ferry}/schedules', [FerryController::class, 'schedules'])->name('schedules');
        Route::post('/{ferry}/schedules', [FerryController::class, 'storeSchedule'])->name('schedules.store');
        Route::delete('/{ferry}/schedules/{schedule}', [FerryController::class, 'destroySchedule'])->name('schedules.destroy');
        Route::get('/schedules/all', [FerryController::class, 'allSchedules'])->name('schedules.all');
        
        // Ferry Ticket Management
        Route::get('/tickets/management', [FerryController::class, 'ticketManagement'])->name('tickets.management');
        Route::get('/tickets/{ticket}', [FerryController::class, 'showTicket'])->name('tickets.show');
        Route::put('/tickets/{ticket}/status', [FerryController::class, 'updateTicketStatus'])->name('tickets.status.update');
        Route::get('/my-tickets', [FerryController::class, 'myTickets'])->name('tickets.my');
    });

    // Theme Park Management Routes
    Route::middleware(['permission:canManageThemeParks'])->prefix('themeparks')->name('themeparks.')->group(function () {
        Route::get('/', [ThemeparkController::class, 'index'])->name('index');
        Route::get('/dashboard', [ThemeparkController::class, 'dashboard'])->name('dashboard');
        Route::get('/create', [ThemeparkController::class, 'create'])->name('create');
        Route::post('/', [ThemeparkController::class, 'store'])->name('store');
        Route::get('/{themepark}', [ThemeparkController::class, 'show'])->name('show');
        Route::get('/{themepark}/edit', [ThemeparkController::class, 'edit'])->name('edit');
        Route::put('/{themepark}', [ThemeparkController::class, 'update'])->name('update');
        Route::delete('/{themepark}', [ThemeparkController::class, 'destroy'])->name('destroy');
        Route::get('/{themepark}/activities', [ThemeparkController::class, 'activities'])->name('activities');
    });

    // Event Management Routes
    Route::middleware(['permission:canManageTicketing'])->prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('index');
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/{event}', [EventController::class, 'show'])->name('show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
        Route::get('/{event}/bookings', [EventController::class, 'bookings'])->name('bookings');
    });

    // Reports (for managers and admins)
    Route::middleware(['permission:canViewReports'])->prefix('reports')->name('reports.')->group(function () {
        Route::get('/', function () {
            return view('management.reports.index');
        })->name('index');
        Route::get('/hotels', [HotelController::class, 'reports'])->name('hotels');
        Route::get('/themeparks', [ThemeparkController::class, 'reports'])->name('themeparks');
        Route::get('/revenue', function () {
            return view('management.reports.revenue');
        })->name('revenue');
    });
});

// ============================================================================
// ADMINISTRATOR ROUTES (Unified Admin Panel)
// ============================================================================

Route::middleware(['auth', 'role:administrator'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard & Overview
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/overview', [AdminController::class, 'overview'])->name('overview');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Role Management
    Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
    Route::post('/roles/assign', [AdminController::class, 'assignRoles'])->name('roles.assign');
    
    // System Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    
    // Banner Management Routes
    Route::get('/banners', [AdminController::class, 'banners'])->name('banners');
    Route::get('/banners/create', [AdminController::class, 'createBanner'])->name('banners.create');
    Route::post('/banners', [AdminController::class, 'storeBanner'])->name('banners.store');
    Route::get('/banners/{banner}/edit', [AdminController::class, 'editBanner'])->name('banners.edit');
    Route::put('/banners/{banner}', [AdminController::class, 'updateBanner'])->name('banners.update');
    Route::delete('/banners/{banner}', [AdminController::class, 'destroyBanner'])->name('banners.destroy');
    Route::patch('/banners/{banner}/toggle', [AdminController::class, 'toggleBanner'])->name('banners.toggle');
    
    // All Bookings Management (Admin can see ALL bookings)
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{booking}', [AdminController::class, 'showBooking'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [AdminController::class, 'editBooking'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [AdminController::class, 'updateBooking'])->name('bookings.update');
    Route::patch('/bookings/{booking}/status', [AdminController::class, 'updateBooking'])->name('bookings.updateStatus');
    Route::delete('/bookings/{booking}', [AdminController::class, 'cancelBooking'])->name('bookings.cancel');
});

// Hotel Manager routes (for managing hotel bookings)
Route::middleware(['auth', 'role:hotel_manager,administrator'])->prefix('hotel-manager')->name('hotel.manager.')->group(function () {
    Route::get('/bookings', [BookingController::class, 'hotelManagerBookings'])->name('bookings.index');
    Route::get('/bookings/pending', [BookingController::class, 'pendingHotelBookings'])->name('bookings.pending');
    Route::patch('/bookings/{booking}/approve', [BookingController::class, 'approveBooking'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [BookingController::class, 'rejectBooking'])->name('bookings.reject');
});

// Include authentication routes
require __DIR__.'/auth.php';
