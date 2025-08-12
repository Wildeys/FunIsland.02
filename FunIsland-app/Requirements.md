# Booking System Assignment

## Project Overview
A Laravel-based **Booking System** that integrates:
- Hotel/Room bookings
- Ferry ticket booking with hotel validation
- Theme park/event ticketing

The project implements **role-based authentication**, complete CRUD operations, and follows Laravel conventions and best practices.

---

## Table of Contents
1. [System Features](#system-features)
2. [Database Design](#database-design)
3. [Laravel Models & Relationships](#laravel-models--relationships)
4. [Authentication & Authorization](#authentication--authorization)
5. [Core Functionality Implementation](#core-functionality-implementation)
6. [Code Quality & Best Practices](#code-quality--best-practices)
7. [Documentation](#documentation)
8. [Presentation](#presentation)
9. [Installation & Setup](#installation--setup)
10. [Marking Scheme Reference](#marking-scheme-reference)

---

## System Features

### Hotel/Room Booking System (6 marks)
- Availability search and booking
- Room categorization and pricing
- Booking confirmation and payment simulation

### Ferry Ticket System with Hotel Validation (6 marks)
- Ferry schedules and seat management
- Ticket purchase validation with existing hotel booking

### Theme Park/Event Booking (6 marks)
- Event listing and details
- Capacity tracking and booking

### Room Management CRUD (6 marks)
- Create, Read, Update, Delete rooms
- Maintenance status updates

### Booking Management (6 marks)
- Dashboard for all bookings
- Status updates, cancellations, and payment tracking

### Ferry Operations (5 marks)
- Route and schedule management
- Operational status updates

---

## Database Design (8 marks)
- Well-normalized schema (3NF)
- Proper relationships, foreign keys, and indexes
- Appropriate data types
- Includes:
  - `users`
  - `hotels`
  - `rooms`
  - `bookings`
  - `ferries`
  - `ferry_schedules`
  - `events`
  - `event_bookings`

**Deliverables:**
- ER Diagram
- SQL schema

---

## Laravel Models & Relationships (7 marks)
- Eloquent relationships:
  - `belongsTo`, `hasMany`, `belongsToMany`
- Proper `$fillable` and `$guarded` usage
- Examples:
```php
class User extends Model {
    public function bookings() { return $this->hasMany(Booking::class); }
}
```

---

## Authentication & Authorization (8 marks)
- Laravel's built-in authentication or custom
- Role-based access (`admin`, `staff`, `customer`)
- Middleware for role checking
- Policies for feature access control

---

## Core Functionality Implementation (35 marks)
- Fully working features for hotels, ferries, and events
- Cross-feature integration (hotel booking validation for ferries)
- Booking modifications and payment status management
- Search, filter, pagination

---

## Code Quality & Best Practices (10 marks)
- Clean controller methods
- Follows Laravel conventions
- Service/Repository pattern
- Route model binding
- Form request validation

---

## Documentation (15 marks)
- Database diagram (7 marks)
- High-level data flow diagram (8 marks)
- API endpoint documentation
- User manual with feature explanations

---

## Presentation (17 marks)
- System walkthrough clarity (2 marks)
- Q&A handling during demo (3 marks)
- Understanding of implemented features (4 marks)
- Professional presentation/dress code (3 marks)

---

## Installation & Setup
```bash
git clone <repo-url>
cd booking-system
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

---

## Marking Scheme Reference
| Criteria | Marks |
|----------|-------|
| Database Design & Models | 8 |
| Laravel Models & Relationships | 7 |
| Authentication & Authorization | 8 |
| Core Functionality Implementation | 35 |
| Code Quality & Laravel Best Practices | 10 |
| Documentation | 15 |
| Presentation | 17 |
| **Total** | **100** |
