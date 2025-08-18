<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\FerryController;
use App\Http\Controllers\ThemeparkController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BeachController;
use App\Http\Controllers\LocationController;
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
    return view('welcome');
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

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Booking routes
    Route::post('/hotels/book', [HotelController::class, 'book'])->name('hotels.book');
    Route::post('/ferries/book', [FerryController::class, 'book'])->name('ferries.book');
    Route::post('/themeparks/book', [ThemeparkController::class, 'book'])->name('themeparks.book');
    Route::post('/beaches/book', [BeachController::class, 'book'])->name('beaches.book');
    
    // Index routes for authenticated users
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.customer.index');
    Route::get('/ferries', [FerryController::class, 'index'])->name('ferries.customer.index');
    Route::get('/themeparks', [ThemeparkController::class, 'index'])->name('themeparks.customer.index');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/beaches', [BeachController::class, 'index'])->name('beaches.customer.index');
    Route::get('/beaches/{id}', [BeachController::class, 'show'])->name('beaches.show');
    
    // Booking management routes
    Route::get('/my-bookings', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.my');
});

// About/Info pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

// Dashboard (role-based routing handled in dashboard.blade.php)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role-based Management Routes
Route::middleware(['auth', 'management'])->prefix('management')->name('management.')->group(function () {
    
    // General management dashboard
    Route::get('/dashboard', function () {
        return view('management.dashboard');
    })->name('dashboard');

    // Hotel Management Routes
    Route::middleware(['permission:canManageHotels'])->prefix('hotels')->name('hotels.')->group(function () {
        Route::get('/', [HotelController::class, 'index'])->name('index');
        Route::get('/create', [HotelController::class, 'create'])->name('create');
        Route::post('/', [HotelController::class, 'store'])->name('store');
        Route::get('/{hotel}', [HotelController::class, 'show'])->name('show');
        Route::get('/{hotel}/edit', [HotelController::class, 'edit'])->name('edit');
        Route::put('/{hotel}', [HotelController::class, 'update'])->name('update');
        Route::delete('/{hotel}', [HotelController::class, 'destroy'])->name('destroy');
        Route::get('/{hotel}/bookings', [HotelController::class, 'bookings'])->name('bookings');
    });

    // Ferry Management Routes
    Route::middleware(['permission:canManageFerries'])->prefix('ferries')->name('ferries.')->group(function () {
        Route::get('/', [FerryController::class, 'index'])->name('index');
        Route::get('/create', [FerryController::class, 'create'])->name('create');
        Route::post('/', [FerryController::class, 'store'])->name('store');
        Route::get('/{ferry}', [FerryController::class, 'show'])->name('show');
        Route::get('/{ferry}/edit', [FerryController::class, 'edit'])->name('edit');
        Route::put('/{ferry}', [FerryController::class, 'update'])->name('update');
        Route::delete('/{ferry}', [FerryController::class, 'destroy'])->name('destroy');
        Route::get('/{ferry}/schedules', [FerryController::class, 'schedules'])->name('schedules');
    });

    // Theme Park Management Routes
    Route::middleware(['permission:canManageThemeParks'])->prefix('themeparks')->name('themeparks.')->group(function () {
        Route::get('/', [ThemeparkController::class, 'index'])->name('index');
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

    // Booking Management (for ticketing staff and managers)
    Route::middleware(['permission:canManageTicketing'])->prefix('management/bookings')->name('management.bookings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\BookingController::class, 'index'])->name('index');
        Route::get('/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('show');
        Route::put('/{booking}/status', [\App\Http\Controllers\BookingController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{booking}', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('cancel');
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

// Administrator-only routes
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [\App\Http\Controllers\AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/roles', [\App\Http\Controllers\AdminController::class, 'roles'])->name('roles');
    Route::get('/system', [\App\Http\Controllers\AdminController::class, 'system'])->name('system');
});

// Customer-specific routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'customerBookings'])->name('bookings');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});

// Hotel Staff routes (view-only access to hotel data)
Route::middleware(['auth', 'role:hotel_staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/hotels', [HotelController::class, 'staffView'])->name('hotels');
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'staffView'])->name('bookings');
});

// Additional booking routes (accessible by customers and staff)
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/staff', [\App\Http\Controllers\BookingController::class, 'staffView'])->name('bookings.staff');
    Route::get('/bookings/my', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.my');
    // Booking CRUD routes (individually defined for better control)
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [\App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [\App\Http\Controllers\BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'destroy'])->name('bookings.destroy');

    
    
    // Specific booking type routes
    Route::post('/hotels/{hotel}/book', [\App\Http\Controllers\BookingController::class, 'hotelBooking'])->name('hotels.book');
    Route::post('/ferries/{ferry}/book', [\App\Http\Controllers\BookingController::class, 'ferryBooking'])->name('ferries.book');
    Route::post('/themeparks/{themepark}/book', [\App\Http\Controllers\BookingController::class, 'themeparkBooking'])->name('themeparks.book');
    Route::post('/events/{event}/book', [\App\Http\Controllers\BookingController::class, 'eventBooking'])->name('events.book');
    
    // Booking management routes
    Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::patch('/bookings/{booking}/cancel', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Hotel Manager routes (for managing hotel bookings)
Route::middleware(['auth', 'role:hotel_manager,administrator'])->prefix('hotel-manager')->name('hotel.manager.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'hotelManagerBookings'])->name('bookings.index');
    Route::get('/bookings/pending', [\App\Http\Controllers\BookingController::class, 'pendingHotelBookings'])->name('bookings.pending');
    Route::patch('/bookings/{booking}/approve', [\App\Http\Controllers\BookingController::class, 'approveBooking'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [\App\Http\Controllers\BookingController::class, 'rejectBooking'])->name('bookings.reject');
});// Hotel Manager routes (for managing hotel bookings)
Route::middleware(['auth', 'role:hotel_manager,administrator'])->prefix('hotel-manager')->name('hotel.manager.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'hotelManagerBookings'])->name('bookings.index');
    Route::get('/bookings/pending', [\App\Http\Controllers\BookingController::class, 'pendingHotelBookings'])->name('bookings.pending');
    Route::patch('/bookings/{booking}/approve', [\App\Http\Controllers\BookingController::class, 'approveBooking'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [\App\Http\Controllers\BookingController::class, 'rejectBooking'])->name('bookings.reject');
});
// ============================================================================

// Homepage
Route::get('/', function () {
    return view('welcome');
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

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Booking routes
    Route::post('/hotels/book', [HotelController::class, 'book'])->name('hotels.book');
    Route::post('/ferries/book', [FerryController::class, 'book'])->name('ferries.book');
    Route::post('/themeparks/book', [ThemeparkController::class, 'book'])->name('themeparks.book');
    Route::post('/beaches/book', [BeachController::class, 'book'])->name('beaches.book');
    
    // Index routes for authenticated users
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.customer.index');
    Route::get('/ferries', [FerryController::class, 'index'])->name('ferries.customer.index');
    Route::get('/themeparks', [ThemeparkController::class, 'index'])->name('themeparks.customer.index');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/beaches', [BeachController::class, 'index'])->name('beaches.customer.index');
    Route::get('/beaches/{id}', [BeachController::class, 'show'])->name('beaches.show');
    
    // Booking management routes
    Route::get('/my-bookings', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.my');
});

// About/Info pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

// Dashboard (role-based routing handled in dashboard.blade.php)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role-based Management Routes
Route::middleware(['auth', 'management'])->prefix('management')->name('management.')->group(function () {
    
    // General management dashboard
    Route::get('/dashboard', function () {
        return view('management.dashboard');
    })->name('dashboard');

    // Hotel Management Routes
    Route::middleware(['permission:canManageHotels'])->prefix('hotels')->name('hotels.')->group(function () {
        Route::get('/', [HotelController::class, 'index'])->name('index');
        Route::get('/create', [HotelController::class, 'create'])->name('create');
        Route::post('/', [HotelController::class, 'store'])->name('store');
        Route::get('/{hotel}', [HotelController::class, 'show'])->name('show');
        Route::get('/{hotel}/edit', [HotelController::class, 'edit'])->name('edit');
        Route::put('/{hotel}', [HotelController::class, 'update'])->name('update');
        Route::delete('/{hotel}', [HotelController::class, 'destroy'])->name('destroy');
        Route::get('/{hotel}/bookings', [HotelController::class, 'bookings'])->name('bookings');
    });

    // Ferry Management Routes
    Route::middleware(['permission:canManageFerries'])->prefix('ferries')->name('ferries.')->group(function () {
        Route::get('/', [FerryController::class, 'index'])->name('index');
        Route::get('/create', [FerryController::class, 'create'])->name('create');
        Route::post('/', [FerryController::class, 'store'])->name('store');
        Route::get('/{ferry}', [FerryController::class, 'show'])->name('show');
        Route::get('/{ferry}/edit', [FerryController::class, 'edit'])->name('edit');
        Route::put('/{ferry}', [FerryController::class, 'update'])->name('update');
        Route::delete('/{ferry}', [FerryController::class, 'destroy'])->name('destroy');
        Route::get('/{ferry}/schedules', [FerryController::class, 'schedules'])->name('schedules');
    });

    // Theme Park Management Routes
    Route::middleware(['permission:canManageThemeParks'])->prefix('themeparks')->name('themeparks.')->group(function () {
        Route::get('/', [ThemeparkController::class, 'index'])->name('index');
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

    // Booking Management (for ticketing staff and managers)
    Route::middleware(['permission:canManageTicketing'])->prefix('management/bookings')->name('management.bookings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\BookingController::class, 'index'])->name('index');
        Route::get('/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('show');
        Route::put('/{booking}/status', [\App\Http\Controllers\BookingController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{booking}', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('cancel');
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

// Administrator-only routes
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [\App\Http\Controllers\AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/roles', [\App\Http\Controllers\AdminController::class, 'roles'])->name('roles');
    Route::get('/system', [\App\Http\Controllers\AdminController::class, 'system'])->name('system');
});

// Customer-specific routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'customerBookings'])->name('bookings');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});

// Hotel Staff routes (view-only access to hotel data)
Route::middleware(['auth', 'role:hotel_staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/hotels', [HotelController::class, 'staffView'])->name('hotels');
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'staffView'])->name('bookings');
});

// Additional booking routes (accessible by customers and staff)
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/staff', [\App\Http\Controllers\BookingController::class, 'staffView'])->name('bookings.staff');
    Route::get('/bookings/my', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.my');
    // Booking CRUD routes (individually defined for better control)
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [\App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [\App\Http\Controllers\BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'destroy'])->name('bookings.destroy');

    
    
    // Specific booking type routes
    Route::post('/hotels/{hotel}/book', [\App\Http\Controllers\BookingController::class, 'hotelBooking'])->name('hotels.book');
    Route::post('/ferries/{ferry}/book', [\App\Http\Controllers\BookingController::class, 'ferryBooking'])->name('ferries.book');
    Route::post('/themeparks/{themepark}/book', [\App\Http\Controllers\BookingController::class, 'themeparkBooking'])->name('themeparks.book');
    Route::post('/events/{event}/book', [\App\Http\Controllers\BookingController::class, 'eventBooking'])->name('events.book');
    
    // Booking management routes
    Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::patch('/bookings/{booking}/cancel', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Hotel Manager routes (for managing hotel bookings)
Route::middleware(['auth', 'role:hotel_manager,administrator'])->prefix('hotel-manager')->name('hotel.manager.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'hotelManagerBookings'])->name('bookings.index');
    Route::get('/bookings/pending', [\App\Http\Controllers\BookingController::class, 'pendingHotelBookings'])->name('bookings.pending');
    Route::patch('/bookings/{booking}/approve', [\App\Http\Controllers\BookingController::class, 'approveBooking'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [\App\Http\Controllers\BookingController::class, 'rejectBooking'])->name('bookings.reject');
});

// Include authentication routes
require __DIR__.'/auth.php';
// Hotel Manager routes (for managing hotel bookings)
Route::middleware(['auth', 'role:hotel_manager,administrator'])->prefix('hotel-manager')->name('hotel.manager.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'hotelManagerBookings'])->name('bookings.index');
    Route::get('/bookings/pending', [\App\Http\Controllers\BookingController::class, 'pendingHotelBookings'])->name('bookings.pending');
    Route::patch('/bookings/{booking}/approve', [\App\Http\Controllers\BookingController::class, 'approveBooking'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [\App\Http\Controllers\BookingController::class, 'rejectBooking'])->name('bookings.reject');
});
// PUBLIC ROUTES (No Authentication Required)
// ============================================================================

// Homepage
Route::get('/', function () {
    return view('welcome');
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

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Booking routes
    Route::post('/hotels/book', [HotelController::class, 'book'])->name('hotels.book');
    Route::post('/ferries/book', [FerryController::class, 'book'])->name('ferries.book');
    Route::post('/themeparks/book', [ThemeparkController::class, 'book'])->name('themeparks.book');
    Route::post('/beaches/book', [BeachController::class, 'book'])->name('beaches.book');
    
    // Index routes for authenticated users
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.customer.index');
    Route::get('/ferries', [FerryController::class, 'index'])->name('ferries.customer.index');
    Route::get('/themeparks', [ThemeparkController::class, 'index'])->name('themeparks.customer.index');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/beaches', [BeachController::class, 'index'])->name('beaches.customer.index');
    Route::get('/beaches/{id}', [BeachController::class, 'show'])->name('beaches.show');
    
    // Booking management routes
    Route::get('/my-bookings', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.my');
});

// About/Info pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

// Dashboard (role-based routing handled in dashboard.blade.php)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role-based Management Routes
Route::middleware(['auth', 'management'])->prefix('management')->name('management.')->group(function () {
    
    // General management dashboard
    Route::get('/dashboard', function () {
        return view('management.dashboard');
    })->name('dashboard');

    // Hotel Management Routes
    Route::middleware(['permission:canManageHotels'])->prefix('hotels')->name('hotels.')->group(function () {
        Route::get('/', [HotelController::class, 'index'])->name('index');
        Route::get('/create', [HotelController::class, 'create'])->name('create');
        Route::post('/', [HotelController::class, 'store'])->name('store');
        Route::get('/{hotel}', [HotelController::class, 'show'])->name('show');
        Route::get('/{hotel}/edit', [HotelController::class, 'edit'])->name('edit');
        Route::put('/{hotel}', [HotelController::class, 'update'])->name('update');
        Route::delete('/{hotel}', [HotelController::class, 'destroy'])->name('destroy');
        Route::get('/{hotel}/bookings', [HotelController::class, 'bookings'])->name('bookings');
    });

    // Ferry Management Routes
    Route::middleware(['permission:canManageFerries'])->prefix('ferries')->name('ferries.')->group(function () {
        Route::get('/', [FerryController::class, 'index'])->name('index');
        Route::get('/create', [FerryController::class, 'create'])->name('create');
        Route::post('/', [FerryController::class, 'store'])->name('store');
        Route::get('/{ferry}', [FerryController::class, 'show'])->name('show');
        Route::get('/{ferry}/edit', [FerryController::class, 'edit'])->name('edit');
        Route::put('/{ferry}', [FerryController::class, 'update'])->name('update');
        Route::delete('/{ferry}', [FerryController::class, 'destroy'])->name('destroy');
        Route::get('/{ferry}/schedules', [FerryController::class, 'schedules'])->name('schedules');
    });

    // Theme Park Management Routes
    Route::middleware(['permission:canManageThemeParks'])->prefix('themeparks')->name('themeparks.')->group(function () {
        Route::get('/', [ThemeparkController::class, 'index'])->name('index');
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

    // Booking Management (for ticketing staff and managers)
    Route::middleware(['permission:canManageTicketing'])->prefix('management/bookings')->name('management.bookings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\BookingController::class, 'index'])->name('index');
        Route::get('/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('show');
        Route::put('/{booking}/status', [\App\Http\Controllers\BookingController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{booking}', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('cancel');
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

// Administrator-only routes
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [\App\Http\Controllers\AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/roles', [\App\Http\Controllers\AdminController::class, 'roles'])->name('roles');
    Route::get('/system', [\App\Http\Controllers\AdminController::class, 'system'])->name('system');
});

// Customer-specific routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'customerBookings'])->name('bookings');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});

// Hotel Staff routes (view-only access to hotel data)
Route::middleware(['auth', 'role:hotel_staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/hotels', [HotelController::class, 'staffView'])->name('hotels');
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'staffView'])->name('bookings');
});

// Additional booking routes (accessible by customers and staff)
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/staff', [\App\Http\Controllers\BookingController::class, 'staffView'])->name('bookings.staff');
    Route::get('/bookings/my', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.my');
    // Booking CRUD routes (individually defined for better control)
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [\App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [\App\Http\Controllers\BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'destroy'])->name('bookings.destroy');

    
    
    // Specific booking type routes
    Route::post('/hotels/{hotel}/book', [\App\Http\Controllers\BookingController::class, 'hotelBooking'])->name('hotels.book');
    Route::post('/ferries/{ferry}/book', [\App\Http\Controllers\BookingController::class, 'ferryBooking'])->name('ferries.book');
    Route::post('/themeparks/{themepark}/book', [\App\Http\Controllers\BookingController::class, 'themeparkBooking'])->name('themeparks.book');
    Route::post('/events/{event}/book', [\App\Http\Controllers\BookingController::class, 'eventBooking'])->name('events.book');
    
    // Booking management routes
    Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::patch('/bookings/{booking}/cancel', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Hotel Manager routes (for managing hotel bookings)
Route::middleware(['auth', 'role:hotel_manager,administrator'])->prefix('hotel-manager')->name('hotel.manager.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'hotelManagerBookings'])->name('bookings.index');
    Route::get('/bookings/pending', [\App\Http\Controllers\BookingController::class, 'pendingHotelBookings'])->name('bookings.pending');
    Route::patch('/bookings/{booking}/approve', [\App\Http\Controllers\BookingController::class, 'approveBooking'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [\App\Http\Controllers\BookingController::class, 'rejectBooking'])->name('bookings.reject');
});

// Include authentication routes
require __DIR__.'/auth.php';
// Hotel Manager routes (for managing hotel bookings)
Route::middleware(['auth', 'role:hotel_manager,administrator'])->prefix('hotel-manager')->name('hotel.manager.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'hotelManagerBookings'])->name('bookings.index');
    Route::get('/bookings/pending', [\App\Http\Controllers\BookingController::class, 'pendingHotelBookings'])->name('bookings.pending');
    Route::patch('/bookings/{booking}/approve', [\App\Http\Controllers\BookingController::class, 'approveBooking'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [\App\Http\Controllers\BookingController::class, 'rejectBooking'])->name('bookings.reject');
});

// PUBLIC ROUTES (No Authentication Required)
// ============================================================================

// Homepage
Route::get('/', function () {
    return view('welcome');
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

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Booking routes
    Route::post('/hotels/book', [HotelController::class, 'book'])->name('hotels.book');
    Route::post('/ferries/book', [FerryController::class, 'book'])->name('ferries.book');
    Route::post('/themeparks/book', [ThemeparkController::class, 'book'])->name('themeparks.book');
    Route::post('/beaches/book', [BeachController::class, 'book'])->name('beaches.book');
    
    // Index routes for authenticated users
    Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.customer.index');
    Route::get('/ferries', [FerryController::class, 'index'])->name('ferries.customer.index');
    Route::get('/themeparks', [ThemeparkController::class, 'index'])->name('themeparks.customer.index');
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/beaches', [BeachController::class, 'index'])->name('beaches.customer.index');
    Route::get('/beaches/{id}', [BeachController::class, 'show'])->name('beaches.show');
    
    // Booking management routes
    Route::get('/my-bookings', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.my');
});

// About/Info pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

// Dashboard (role-based routing handled in dashboard.blade.php)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role-based Management Routes
Route::middleware(['auth', 'management'])->prefix('management')->name('management.')->group(function () {
    
    // General management dashboard
    Route::get('/dashboard', function () {
        return view('management.dashboard');
    })->name('dashboard');

    // Hotel Management Routes
    Route::middleware(['permission:canManageHotels'])->prefix('hotels')->name('hotels.')->group(function () {
        Route::get('/', [HotelController::class, 'index'])->name('index');
        Route::get('/create', [HotelController::class, 'create'])->name('create');
        Route::post('/', [HotelController::class, 'store'])->name('store');
        Route::get('/{hotel}', [HotelController::class, 'show'])->name('show');
        Route::get('/{hotel}/edit', [HotelController::class, 'edit'])->name('edit');
        Route::put('/{hotel}', [HotelController::class, 'update'])->name('update');
        Route::delete('/{hotel}', [HotelController::class, 'destroy'])->name('destroy');
        Route::get('/{hotel}/bookings', [HotelController::class, 'bookings'])->name('bookings');
    });

    // Ferry Management Routes
    Route::middleware(['permission:canManageFerries'])->prefix('ferries')->name('ferries.')->group(function () {
        Route::get('/', [FerryController::class, 'index'])->name('index');
        Route::get('/create', [FerryController::class, 'create'])->name('create');
        Route::post('/', [FerryController::class, 'store'])->name('store');
        Route::get('/{ferry}', [FerryController::class, 'show'])->name('show');
        Route::get('/{ferry}/edit', [FerryController::class, 'edit'])->name('edit');
        Route::put('/{ferry}', [FerryController::class, 'update'])->name('update');
        Route::delete('/{ferry}', [FerryController::class, 'destroy'])->name('destroy');
        Route::get('/{ferry}/schedules', [FerryController::class, 'schedules'])->name('schedules');
    });

    // Theme Park Management Routes
    Route::middleware(['permission:canManageThemeParks'])->prefix('themeparks')->name('themeparks.')->group(function () {
        Route::get('/', [ThemeparkController::class, 'index'])->name('index');
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

    // Booking Management (for ticketing staff and managers)
    Route::middleware(['permission:canManageTicketing'])->prefix('management/bookings')->name('management.bookings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\BookingController::class, 'index'])->name('index');
        Route::get('/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('show');
        Route::put('/{booking}/status', [\App\Http\Controllers\BookingController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{booking}', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('cancel');
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

// Administrator-only routes
Route::middleware(['auth', 'role:administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [\App\Http\Controllers\AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [\App\Http\Controllers\AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/roles', [\App\Http\Controllers\AdminController::class, 'roles'])->name('roles');
    Route::get('/system', [\App\Http\Controllers\AdminController::class, 'system'])->name('system');
});

// Customer-specific routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'customerBookings'])->name('bookings');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});

// Hotel Staff routes (view-only access to hotel data)
Route::middleware(['auth', 'role:hotel_staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/hotels', [HotelController::class, 'staffView'])->name('hotels');
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'staffView'])->name('bookings');
});

// Additional booking routes (accessible by customers and staff)
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings/staff', [\App\Http\Controllers\BookingController::class, 'staffView'])->name('bookings.staff');
    Route::get('/bookings/my', [\App\Http\Controllers\BookingController::class, 'myBookings'])->name('bookings.my');
    // Booking CRUD routes (individually defined for better control)
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [\App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [\App\Http\Controllers\BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [\App\Http\Controllers\BookingController::class, 'destroy'])->name('bookings.destroy');

    
    
    // Specific booking type routes
    Route::post('/hotels/{hotel}/book', [\App\Http\Controllers\BookingController::class, 'hotelBooking'])->name('hotels.book');
    Route::post('/ferries/{ferry}/book', [\App\Http\Controllers\BookingController::class, 'ferryBooking'])->name('ferries.book');
    Route::post('/themeparks/{themepark}/book', [\App\Http\Controllers\BookingController::class, 'themeparkBooking'])->name('themeparks.book');
    Route::post('/events/{event}/book', [\App\Http\Controllers\BookingController::class, 'eventBooking'])->name('events.book');
    
    // Booking management routes
    Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::patch('/bookings/{booking}/cancel', [\App\Http\Controllers\BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Hotel Manager routes (for managing hotel bookings)
Route::middleware(['auth', 'role:hotel_manager,administrator'])->prefix('hotel-manager')->name('hotel.manager.')->group(function () {
    Route::get('/bookings', [\App\Http\Controllers\BookingController::class, 'hotelManagerBookings'])->name('bookings.index');
    Route::get('/bookings/pending', [\App\Http\Controllers\BookingController::class, 'pendingHotelBookings'])->name('bookings.pending');
    Route::patch('/bookings/{booking}/approve', [\App\Http\Controllers\BookingController::class, 'approveBooking'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [\App\Http\Controllers\BookingController::class, 'rejectBooking'])->name('bookings.reject');
});

// Include authentication routes
require __DIR__.'/auth.php';


// Include authentication routes
require __DIR__.'/auth.php';
