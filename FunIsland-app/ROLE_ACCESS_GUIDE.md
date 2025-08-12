# Fun Island Paradise - Role-Based Access Control Guide

## Overview
This document outlines the comprehensive role-based access control system implemented for Fun Island Paradise. Each user role has specific permissions and access levels to different parts of the application.

## User Roles

### 1. Administrator
- **Full system access and control**
- Can manage all aspects of the system
- Access to admin dashboard and system settings
- Can create, edit, and delete users
- Can manage roles and permissions
- Access to all reports and analytics

**Routes Access:**
- `/admin/*` - Full admin panel access
- `/management/*` - All management functions
- All public routes

### 2. Hotel Manager
- **Manage hotels, rooms, and bookings**
- Can create, update, and delete hotels
- Can manage room inventory
- Can view and manage hotel bookings
- Access to hotel-specific reports

**Routes Access:**
- `/management/dashboard` - Management dashboard
- `/management/hotels/*` - Full hotel management
- `/management/bookings/*` - Booking management
- `/management/reports/*` - Reports access
- All public routes

### 3. Hotel Staff
- **View bookings and basic hotel operations**
- Read-only access to hotel information
- Can view current bookings
- Cannot modify hotel or booking data

**Routes Access:**
- `/staff/hotels` - View hotel information
- `/staff/bookings` - View bookings
- All public routes

### 4. Ferry Operator
- **Manage ferry schedules and tickets**
- Can manage ferry operations
- Can update schedules and routes
- Can handle ferry bookings

**Routes Access:**
- `/management/dashboard` - Management dashboard
- `/management/ferries/*` - Full ferry management
- All public routes

### 5. Theme Park Manager
- **Manage parks, activities, and bookings**
- Can manage theme park operations
- Can create and manage activities
- Can view theme park bookings and reports

**Routes Access:**
- `/management/dashboard` - Management dashboard
- `/management/themeparks/*` - Full theme park management
- `/management/reports/*` - Reports access
- All public routes

### 6. Ticketing Staff
- **Handle ticket sales and bookings**
- Can manage event tickets
- Can process bookings and cancellations
- Can view booking reports

**Routes Access:**
- `/management/dashboard` - Management dashboard
- `/management/events/*` - Event management
- `/management/bookings/*` - Booking management
- All public routes

### 7. Customer
- **Book services and view bookings**
- Can browse and book services
- Can view their own bookings
- Can manage their profile

**Routes Access:**
- `/customer/bookings` - View own bookings
- `/customer/profile` - Profile management
- All public routes
- Booking endpoints (POST requests)

## Middleware System

### 1. `role` Middleware
- Checks for specific role names
- Usage: `middleware('role:administrator')`
- Blocks access if user doesn't have the exact role

### 2. `management` Middleware
- Checks if user has any management role
- Allows access for: administrator, hotel_manager, ferry_operator, theme_park_manager, ticketing_staff
- Usage: `middleware('management')`

### 3. `permission` Middleware
- Checks for specific permission methods
- Usage: `middleware('permission:canManageHotels')`
- More flexible than role-based checking

## Permission Methods

### Hotel Permissions
- `canManageHotels()` - Administrator, Hotel Manager
- `canViewHotels()` - Administrator, Hotel Manager, Hotel Staff

### Ferry Permissions
- `canManageFerries()` - Administrator, Ferry Operator

### Theme Park Permissions
- `canManageThemeParks()` - Administrator, Theme Park Manager

### Ticketing Permissions
- `canManageTicketing()` - Administrator, Ticketing Staff

### General Permissions
- `canAccessManagement()` - Any management role
- `canViewReports()` - Administrator, Hotel Manager, Theme Park Manager

## Route Structure

### Public Routes
- `/` - Homepage
- `/browse/*` - Browse services (hotels, ferries, theme parks, events)
- `/about`, `/contact`, `/privacy`, `/terms` - Information pages

### Authenticated Routes
- `/dashboard` - Role-based dashboard redirect
- `/profile/*` - Profile management
- Booking endpoints (POST requests)

### Management Routes (`/management/*`)
- Requires `management` middleware
- Role-specific sections protected by `permission` middleware
- Includes dashboards, CRUD operations, and reports

### Admin Routes (`/admin/*`)
- Requires `role:administrator`
- User management, role management, system settings

### Customer Routes (`/customer/*`)
- Requires `role:customer`
- Personal bookings and profile

### Staff Routes (`/staff/*`)
- Requires `role:hotel_staff`
- View-only access to hotel data

## Implementation Examples

### Protecting a Route
```php
// Specific role
Route::middleware(['auth', 'role:hotel_manager'])->group(function () {
    // Hotel manager only routes
});

// Permission-based
Route::middleware(['auth', 'permission:canManageHotels'])->group(function () {
    // Anyone who can manage hotels
});

// Management access
Route::middleware(['auth', 'management'])->group(function () {
    // Any management role
});
```

### Checking Permissions in Controllers
```php
// Check if user can manage hotels
if ($user->canManageHotels()) {
    // Allow hotel management actions
}

// Check specific role
if ($user->isHotelManager()) {
    // Hotel manager specific logic
}
```

### Checking in Blade Templates
```php
@if(auth()->user()->canManageHotels())
    <a href="{{ route('management.hotels.create') }}">Add Hotel</a>
@endif

@if(auth()->user()->isAdministrator())
    <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
@endif
```

## Security Features

1. **Authentication Required**: All protected routes require user authentication
2. **Role Verification**: Middleware checks user roles before granting access
3. **Permission-Based Access**: Fine-grained control using permission methods
4. **Graceful Errors**: 403 errors with descriptive messages for unauthorized access
5. **Route Protection**: Multiple layers of protection (auth + role/permission)

## Adding New Roles

1. Add role to `RoleSeeder.php`
2. Add helper methods to `Role.php` and `User.php` models
3. Create permission methods in `User.php`
4. Add routes with appropriate middleware
5. Update this documentation

This system provides flexible, secure, and maintainable role-based access control for the Fun Island Paradise application. 