<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'location',
        'price',
        'capacity',
        'available_spots',
        'start_time',
        'end_time',
        'duration',
        'requirements',
        'features',
        'difficulty_level',
        'status',
        'image_url'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'features' => 'array',
        'price' => 'decimal:2'
    ];

    // Relationships
    public function bookings(): HasMany
    {
        return $this->hasMany(EventBooking::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAvailable($query)
    {
        return $query->where('available_spots', '>', 0);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now());
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helper methods
    public function isAvailable(): bool
    {
        return $this->available_spots > 0 && $this->status === 'active';
    }

    public function isFull(): bool
    {
        return $this->available_spots <= 0;
    }

    public function isUpcoming(): bool
    {
        return $this->start_time > now();
    }

    public function isOngoing(): bool
    {
        return now()->between($this->start_time, $this->end_time);
    }

    public function isCompleted(): bool
    {
        return $this->end_time < now();
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    public function getFormattedDurationAttribute(): string
    {
        return $this->duration;
    }

    public function getAvailabilityStatusAttribute(): string
    {
        if ($this->isFull()) {
            return 'Sold Out';
        }
        
        if ($this->available_spots <= 5) {
            return 'Almost Full';
        }
        
        return 'Available';
    }

    public function getTypeDisplayAttribute(): string
    {
        return match($this->type) {
            'beach_event' => 'Beach Event',
            'activity' => 'Activity',
            'entertainment' => 'Entertainment',
            default => ucfirst($this->type)
        };
    }
}
