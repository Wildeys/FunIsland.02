<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $fillable = [
        'location_name',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    // Accessor for name (to match the relationship expectations)
    public function getNameAttribute()
    {
        return $this->location_name;
    }

    // Relationships
    public function hotels(): HasMany
    {
        return $this->hasMany(\App\Models\hotel::class);
    }

    public function ferries(): HasMany
    {
        return $this->hasMany(\App\Models\ferry::class, 'location_id');
    }

    public function themeparks(): HasMany
    {
        return $this->hasMany(\App\Models\themepark::class);
    }
}
