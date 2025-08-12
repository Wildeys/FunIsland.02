<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'booking_reference',
        'user_id',
        'booking_type',
        'hotel_id',
        'room_id',
        'ferry_id',
        'event_id',
        'check_in_date',
        'check_out_date',
        'guests',
        'total_amount',
        'status',
        'payment_status',
        'special_requests',
        'booked_at',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_amount' => 'decimal:2',
        'booked_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            if (!$booking->booking_reference) {
                $booking->booking_reference = 'BK-' . strtoupper(uniqid());
            }
            if (!$booking->booked_at) {
                $booking->booked_at = now();
            }
        });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(hotel::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function ferry(): BelongsTo
    {
        return $this->belongsTo(ferry::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    // Scopes
    public function scopeHotelBookings($query)
    {
        return $query->where('booking_type', 'hotel');
    }

    public function scopeFerryBookings($query)
    {
        return $query->where('booking_type', 'ferry');
    }

    public function scopeEventBookings($query)
    {
        return $query->where('booking_type', 'event');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    // Helper Methods
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function getFormattedTotalAmountAttribute(): string
    {
        return '$' . number_format($this->total_amount, 2);
    }

    public function getStatusDisplayAttribute(): string
    {
        return ucfirst($this->status);
    }

    public function getPaymentStatusDisplayAttribute(): string
    {
        return ucfirst($this->payment_status);
    }

    public function getBookingTypeDisplayAttribute(): string
    {
        return ucfirst($this->booking_type);
    }

    public function getNightsAttribute(): int
    {
        if ($this->check_in_date && $this->check_out_date) {
            return $this->check_in_date->diffInDays($this->check_out_date);
        }
        return 0;
    }
}
