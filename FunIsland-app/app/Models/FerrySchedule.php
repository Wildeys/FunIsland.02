<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FerrySchedule extends Model
{
    protected $table = 'ferry_schedule';

    protected $fillable = [
        'ferry_id',
        'date',
        'departure_time',
        'departure_location_id',
        'arrival_location_id',
        'price',
        'remaining_seats',
        'is_available'
    ];

    protected $casts = [
        'date' => 'date',
        'departure_time' => 'datetime:H:i',
        'price' => 'decimal:2',
        'remaining_seats' => 'integer',
        'is_available' => 'boolean'
    ];

    // Relationships
    public function ferry(): BelongsTo
    {
        return $this->belongsTo(ferry::class);
    }

    public function departureLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'departure_location_id');
    }

    public function arrivalLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'arrival_location_id');
    }

    public function ticketing(): HasMany
    {
        return $this->hasMany(FerryTicketing::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('remaining_seats', '>', 0);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString());
    }
} 