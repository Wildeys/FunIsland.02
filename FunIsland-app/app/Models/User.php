<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    public function canManageHotels(): bool
    {
        return $this->hasRole('administrator') || 
               $this->hasRole('hotel_manager');
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
