<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FerryTicketing extends Model
{
    protected $table = 'ferry_ticketing';

    protected $fillable = [
        'hotel_booking_id',
        'ferry_schedule_id',
        'user_id',
        'date',
        'number_of_guests',
        'total_price',
        'status',
        'ticket_reference',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'number_of_guests' => 'integer',
        'total_price' => 'decimal:2'
    ];

    // Relationships
    public function hotelBooking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'hotel_booking_id');
    }

    public function ferrySchedule(): BelongsTo
    {
        return $this->belongsTo(FerrySchedule::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
} 