<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class hotel extends Model
{
    protected $fillable = [
        'name',
        'description',
        'location_id',
        'price_per_night',
        'amenities',
        'contact_info',
        'image_url',
        'status',
        'featured'
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'amenities' => 'array',
        'contact_info' => 'array',
        'featured' => 'boolean'
    ];

    // Relationships
    public function location(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Location::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(\App\Models\Room::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(\App\Models\Booking::class);
    }

    public function hotelBookings(): HasMany
    {
        return $this->hasMany(\App\Models\HotelBooking::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isFeatured(): bool
    {
        return $this->featured === true;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price_per_night, 0);
    }
}
