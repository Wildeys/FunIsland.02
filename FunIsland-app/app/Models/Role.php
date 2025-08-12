<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = ['name', 'display_name', 'description'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Helper methods to check roles
    public function isAdministrator(): bool
    {
        return $this->name === 'administrator';
    }

    public function isHotelManager(): bool
    {
        return $this->name === 'hotel_manager';
    }

    public function isHotelStaff(): bool
    {
        return $this->name === 'hotel_staff';
    }

    public function isFerryOperator(): bool
    {
        return $this->name === 'ferry_operator';
    }

    public function isThemeParkManager(): bool
    {
        return $this->name === 'theme_park_manager';
    }

    public function isTicketingStaff(): bool
    {
        return $this->name === 'ticketing_staff';
    }

    public function isCustomer(): bool
    {
        return $this->name === 'customer';
    }
}
