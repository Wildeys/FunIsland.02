<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'hotel_id',
        'room_number',
        'room_type',
        'description',
        'price_per_night',
        'capacity',
        'amenities',
        'status',
        'maintenance_notes',
    ];

    protected $casts = [
        'amenities' => 'array',
        'price_per_night' => 'decimal:2',
    ];

    // Relationships
    public function hotel(): BelongsTo
    {
        return $this->belongsTo(hotel::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('room_type', $type);
    }

    // Helper Methods
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isOccupied(): bool
    {
        return $this->status === 'occupied';
    }

    public function isUnderMaintenance(): bool
    {
        return $this->status === 'maintenance';
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price_per_night, 2);
    }

    public function getRoomTypeDisplayAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->room_type));
    }
}
