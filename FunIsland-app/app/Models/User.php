<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Helper methods to check user roles
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function isAdministrator(): bool
    {
        return $this->hasRole('administrator');
    }

    public function isHotelManager(): bool
    {
        return $this->hasRole('hotel_manager');
    }

    public function isHotelStaff(): bool
    {
        return $this->hasRole('hotel_staff');
    }

    public function isFerryOperator(): bool
    {
        return $this->hasRole('ferry_operator');
    }

    public function isThemeParkManager(): bool
    {
        return $this->hasRole('theme_park_manager');
    }

    public function isTicketingStaff(): bool
    {
        return $this->hasRole('ticketing_staff');
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    // Permission-based methods
    public function canManageHotels(): bool
    {
        return $this->hasRole('administrator') || 
               $this->hasRole('hotel_manager');
    }

    public function canViewHotels(): bool
    {
        return $this->hasRole('administrator') || 
               $this->hasRole('hotel_manager') ||
               $this->hasRole('hotel_staff');
    }

    public function canManageFerries(): bool
    {
        return $this->hasRole('administrator') || 
               $this->hasRole('ferry_operator');
    }

    public function canManageThemeParks(): bool
    {
        return $this->hasRole('administrator') || 
               $this->hasRole('theme_park_manager');
    }

    public function canManageTicketing(): bool
    {
        return $this->hasRole('administrator') || 
               $this->hasRole('ticketing_staff');
    }

    public function canAccessManagement(): bool
    {
        return $this->hasRole('administrator') || 
               $this->hasRole('hotel_manager') ||
               $this->hasRole('ferry_operator') ||
               $this->hasRole('theme_park_manager') ||
               $this->hasRole('ticketing_staff');
    }

    public function canViewReports(): bool
    {
        return $this->hasRole('administrator') || 
               $this->hasRole('hotel_manager') ||
               $this->hasRole('theme_park_manager');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function eventBookings(): HasMany
    {
        return $this->hasMany(EventBooking::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
