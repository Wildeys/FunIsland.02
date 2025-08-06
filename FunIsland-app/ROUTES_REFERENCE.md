# FunIsland Routes Reference

## 🌴 Overview
This document provides a comprehensive reference for all routes in the FunIsland application, organized by functionality and access level.

## 🔐 Authentication Routes

### Public Authentication
- `GET /register` - Registration form
- `POST /register` - Process registration with role selection
- `GET /login` - Login form  
- `POST /login` - Process login
- `GET /forgot-password` - Password reset request
- `POST /forgot-password` - Send reset email
- `GET /reset-password/{token}` - Password reset form
- `POST /reset-password` - Process password reset
- `POST /logout` - Logout user

### Email Verification
- `GET /verify-email` - Email verification notice
- `GET /verify-email/{id}/{hash}` - Verify email
- `POST /email/verification-notification` - Resend verification

## 🏠 Public Routes

### Homepage & Information
- `GET /` → `home` - Homepage
- `GET /about` → `about` - About page
- `GET /contact` → `contact` - Contact page
- `GET /privacy` → `privacy` - Privacy policy
- `GET /terms` → `terms` - Terms of service

### Public Browsing (No Login Required)
- `GET /browse/hotels` → `browse.hotels` - Browse hotels publicly
- `GET /browse/ferries` → `browse.ferries` - Browse ferries publicly
- `GET /browse/themeparks` → `browse.themeparks` - Browse theme parks publicly

## 👤 User Dashboard & Profile

### Dashboard
- `GET /dashboard` → `dashboard` - Role-based dashboard (redirects based on user role)

### Profile Management
- `GET /profile` → `profile.edit` - Edit profile
- `PATCH /profile` → `profile.update` - Update profile
- `DELETE /profile` → `profile.destroy` - Delete account

## 🏨 Hotel Routes

### Hotel Management (Hotel Managers + Admins)
- `GET /hotels/dashboard` → `hotels.dashboard` - Hotel manager dashboard
- `GET /hotels` → `hotels.index` - List hotels (management view)
- `GET /hotels/create` → `hotels.create` - Create hotel form
- `POST /hotels` → `hotels.store` - Store new hotel
- `GET /hotels/{hotel}` → `hotels.show` - Hotel details (management view)
- `GET /hotels/{hotel}/edit` → `hotels.edit` - Edit hotel form
- `PUT /hotels/{hotel}` → `hotels.update` - Update hotel
- `DELETE /hotels/{hotel}` → `hotels.destroy` - Delete hotel

### Customer Hotel Routes
- `GET /hotels` → `hotels.index` - Browse hotels (customer view)
- `GET /hotels/{hotel}` → `hotels.show` - Hotel details (customer view)
- `POST /hotels/{hotel}/book` → `bookings.hotel.store` - Book hotel room

## 🚤 Ferry Routes

### Ferry Management (Ferry Operators + Admins)
- `GET /ferries/dashboard` → `ferries.dashboard` - Ferry operator dashboard
- `GET /ferries` → `ferries.index` - List ferries (management view)
- `GET /ferries/create` → `ferries.create` - Create ferry form
- `POST /ferries` → `ferries.store` - Store new ferry
- `GET /ferries/{ferry}` → `ferries.show` - Ferry details (management view)
- `GET /ferries/{ferry}/edit` → `ferries.edit` - Edit ferry form
- `PUT /ferries/{ferry}` → `ferries.update` - Update ferry
- `DELETE /ferries/{ferry}` → `ferries.destroy` - Delete ferry

### Customer Ferry Routes
- `GET /ferries` → `ferries.index` - Browse ferries (customer view)
- `GET /ferries/{ferry}` → `ferries.show` - Ferry details (customer view)
- `POST /ferries/{ferry}/book` → `bookings.ferry.store` - Book ferry ticket

## 🎢 Theme Park Routes

### Theme Park Management (Theme Park Managers + Admins)
- `GET /themeparks/dashboard` → `themeparks.dashboard` - Theme park manager dashboard
- `GET /themeparks` → `themeparks.index` - List theme parks (management view)
- `GET /themeparks/create` → `themeparks.create` - Create theme park form
- `POST /themeparks` → `themeparks.store` - Store new theme park
- `GET /themeparks/{themepark}` → `themeparks.show` - Theme park details (management view)
- `GET /themeparks/{themepark}/edit` → `themeparks.edit` - Edit theme park form
- `PUT /themeparks/{themepark}` → `themeparks.update` - Update theme park
- `DELETE /themeparks/{themepark}` → `themeparks.destroy` - Delete theme park

### Customer Theme Park Routes
- `GET /themeparks` → `themeparks.index` - Browse theme parks (customer view)
- `GET /themeparks/{themepark}` → `themeparks.show` - Theme park details (customer view)
- `POST /themeparks/{themepark}/book` → `bookings.themepark.store` - Book theme park tickets

## 📋 Booking Routes

### Customer Booking Management
- `GET /my-bookings` → `bookings.my` - Customer's bookings list

### Staff Booking Management (All Staff + Admins)
- `GET /manage/bookings` → `manage.bookings` - Manage all bookings
- `GET /manage/bookings/{booking}` → `manage.bookings.show` - View booking details
- `PUT /manage/bookings/{booking}` → `manage.bookings.update` - Update booking
- `DELETE /manage/bookings/{booking}` → `manage.bookings.cancel` - Cancel booking

## 👑 Administrator Routes

### System Overview
- `GET /admin/overview` → `admin.overview` - Admin dashboard
- `GET /admin/settings` → `admin.settings` - System settings
- `GET /admin/reports` → `admin.reports` - System reports
- `GET /admin/analytics` → `admin.analytics` - System analytics

### User Management
- `GET /admin/users` → `admin.users` - List all users
- `GET /admin/users/create` → `admin.users.create` - Create user form
- `POST /admin/users` → `admin.users.store` - Store new user
- `GET /admin/users/{user}` → `admin.users.show` - User details
- `GET /admin/users/{user}/edit` → `admin.users.edit` - Edit user form
- `PUT /admin/users/{user}` → `admin.users.update` - Update user
- `DELETE /admin/users/{user}` → `admin.users.destroy` - Delete user

### Role Management
- `GET /admin/roles` → `admin.roles` - Role assignment interface
- `POST /admin/roles/assign` → `admin.roles.assign` - Assign roles to users

## 🔒 Role-Based Access Control

### Customer (`customer`)
- ✅ Browse and book hotels, ferries, theme parks
- ✅ View own bookings
- ✅ Access customer dashboard

### Hotel Manager (`hotel_manager`)
- ✅ Manage hotels (CRUD operations)
- ✅ Access hotel management dashboard
- ✅ View/manage bookings (shared with other staff)

### Ferry Operator (`ferry_operator`)
- ✅ Manage ferries (CRUD operations)
- ✅ Access ferry management dashboard
- ✅ View/manage bookings (shared with other staff)

### Theme Park Manager (`theme_park_manager`)
- ✅ Manage theme parks (CRUD operations)
- ✅ Access theme park management dashboard
- ✅ View/manage bookings (shared with other staff)

### Ticketing Staff (`ticketing_staff`)
- ✅ View/manage bookings (shared with other staff)
- ✅ Customer service functions

### Administrator (`administrator`)
- ✅ Full system access
- ✅ User and role management
- ✅ System reports and analytics
- ✅ All management functions

## 🔌 API Routes (Future Development)

### Authentication Required
- `GET /api/user` - Get current user info
- `GET /api/hotels` - Hotels API
- `GET /api/ferries` - Ferries API
- `GET /api/themeparks` - Theme parks API
- `GET /api/bookings` - Bookings API
- `GET /api/search/*` - Search endpoints

### Public API
- `GET /api/locations` - Get all locations
- `GET /api/public/*` - Public data endpoints
- `GET /api/health` - Health check

## 🛡️ Middleware Protection

### `guest` - Only for non-authenticated users
- Registration and login forms
- Password reset forms

### `auth` - Requires authentication
- All user dashboards and management interfaces
- Profile management
- Booking operations

### `role:*` - Requires specific role(s)
- Management dashboards
- Administrative functions
- Role-specific CRUD operations

### `verified` - Requires email verification
- Dashboard access (configurable)

## 📱 Route Naming Convention

All routes follow a consistent naming pattern:
- Resource routes: `{resource}.{action}` (e.g., `hotels.index`, `ferries.show`)
- Nested routes: `{parent}.{child}.{action}` (e.g., `bookings.hotel.store`)
- Admin routes: `admin.{section}` (e.g., `admin.users`, `admin.overview`)
- Management routes: `manage.{resource}` (e.g., `manage.bookings`)

This structure provides clear, predictable URLs and makes route resolution efficient throughout the application.