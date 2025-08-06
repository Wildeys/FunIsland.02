# FunIsland View Structure Documentation

## 📁 Directory Organization

```
resources/views/
├── layouts/                    # Layout templates
│   ├── app.blade.php          # Default authenticated layout
│   ├── guest.blade.php        # Guest layout for auth pages
│   ├── management.blade.php   # Management dashboard layout (sidebar)
│   ├── tropical.blade.php     # Customer-facing tropical theme
│   └── navigation.blade.php   # Main navigation component
│
├── components/                 # Reusable UI components
│   ├── cards/                 # Card components
│   │   ├── stat-card.blade.php
│   │   ├── hotel-card.blade.php
│   │   └── booking-card.blade.php
│   ├── forms/                 # Form components
│   │   ├── search-form.blade.php
│   │   ├── booking-form.blade.php
│   │   └── user-form.blade.php
│   ├── tables/                # Table components
│   │   ├── users-table.blade.php
│   │   ├── bookings-table.blade.php
│   │   └── data-table.blade.php
│   ├── application-logo.blade.php
│   ├── primary-button.blade.php
│   └── ... (existing components)
│
├── admin/                      # Administrator interface
│   ├── overview.blade.php     # Admin dashboard
│   ├── settings.blade.php     # System settings
│   ├── roles.blade.php        # Role assignment
│   └── users/                 # User management
│       ├── index.blade.php    # User list
│       ├── create.blade.php   # Create user
│       ├── edit.blade.php     # Edit user
│       └── show.blade.php     # User details
│
├── hotels/                     # Hotel-related views
│   ├── management/            # Hotel manager views
│   │   ├── dashboard.blade.php
│   │   ├── index.blade.php    # Manage hotels list
│   │   ├── create.blade.php   # Create hotel
│   │   ├── edit.blade.php     # Edit hotel
│   │   └── show.blade.php     # Hotel details (management)
│   └── customer/              # Customer-facing hotel views
│       ├── index.blade.php    # Browse hotels
│       ├── show.blade.php     # Hotel details & booking
│       ├── search.blade.php   # Hotel search results
│       └── booking.blade.php  # Hotel booking form
│
├── ferries/                    # Ferry-related views
│   ├── management/            # Ferry operator views
│   │   ├── dashboard.blade.php
│   │   ├── index.blade.php    # Manage ferries
│   │   ├── schedules.blade.php # Manage schedules
│   │   └── bookings.blade.php # Ferry bookings management
│   └── customer/              # Customer ferry views
│       ├── index.blade.php    # Ferry schedules
│       ├── booking.blade.php  # Ferry booking form
│       └── tickets.blade.php  # Ticket confirmation
│
├── themeparks/                 # Theme park views
│   ├── management/            # Park manager views
│   │   ├── dashboard.blade.php
│   │   ├── index.blade.php    # Manage parks
│   │   ├── activities.blade.php # Manage activities
│   │   └── bookings.blade.php # Park bookings
│   └── customer/              # Customer park views
│       ├── index.blade.php    # Browse parks
│       ├── show.blade.php     # Park details
│       ├── activities.blade.php # Browse activities
│       └── tickets.blade.php  # Buy tickets
│
├── beaches/                    # Beach events
│   ├── index.blade.php        # Browse events
│   ├── show.blade.php         # Event details
│   └── booking.blade.php      # Event booking
│
├── bookings/                   # Booking management
│   ├── my-bookings.blade.php  # Customer bookings
│   ├── confirmation.blade.php # Booking confirmation
│   └── receipt.blade.php      # Booking receipt
│
├── auth/                       # Authentication views
│   ├── login.blade.php
│   ├── register.blade.php
│   ├── forgot-password.blade.php
│   └── ... (existing auth views)
│
├── profile/                    # User profile management
│   ├── edit.blade.php
│   └── partials/
│
├── dashboard.blade.php         # Role-based main dashboard
├── welcome.blade.php          # Homepage
└── errors/                    # Error pages
    ├── 403.blade.php
    ├── 404.blade.php
    └── 500.blade.php
```

## 🎯 Naming Conventions

### Views
- **Management views**: Use descriptive names (dashboard, index, create, edit, show)
- **Customer views**: Use action-based names (browse, book, search, tickets)
- **Shared components**: Use component- prefix if needed

### Layouts
- **management.blade.php**: Professional sidebar layout for staff
- **tropical.blade.php**: Island-themed layout for customers
- **guest.blade.php**: Clean layout for authentication

### Components
- **Organized by type**: cards/, forms/, tables/
- **Reusable across modules**: stat-card, data-table, search-form
- **Consistent naming**: kebab-case for file names

## 🚀 Usage Guidelines

### Layout Selection
```php
// Management interface (staff)
<x-management-layout>
    <x-slot name="header">Dashboard</x-slot>
    <!-- content -->
</x-management-layout>

// Customer interface
<x-tropical-layout title="Hotels">
    <x-slot name="header">Find Your Perfect Stay</x-slot>
    <!-- content -->
</x-tropical-layout>
```

### Component Usage
```php
// Reusable components
<x-cards.hotel-card :hotel="$hotel" />
<x-forms.search-form :action="route('hotels.search')" />
<x-tables.bookings-table :bookings="$bookings" />
```

### Route-View Mapping
```php
// Admin routes → admin/ views
Route::get('/admin/users', [AdminController::class, 'users']);
// → resources/views/admin/users/index.blade.php

// Hotel management → hotels/management/ views
Route::get('/hotels/dashboard', [HotelController::class, 'dashboard']);
// → resources/views/hotels/management/dashboard.blade.php

// Customer hotel views → hotels/customer/ views
Route::get('/hotels', [HotelController::class, 'customerIndex']);
// → resources/views/hotels/customer/index.blade.php
```

This structure provides:
- ✅ **Clear separation** between management and customer interfaces
- ✅ **Logical grouping** by feature/module
- ✅ **Reusable components** for consistency
- ✅ **Scalable organization** for future features
- ✅ **Easy maintenance** and collaboration