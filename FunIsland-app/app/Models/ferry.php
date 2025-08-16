<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ferry extends Model
{
    protected $table = 'ferries';
    protected $fillable = [
        'location_id',
        'name',
        'capacity',
        'price',
        'departure_location',
        'arrival_location',
        'status',
        'description'
    ];

    protected $casts = [
        'capacity' => 'integer',
        'price' => 'decimal:2'
    ];

    protected $attributes = [
        'status' => 'active'
    ];

    // Relationships
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(FerrySchedule::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
