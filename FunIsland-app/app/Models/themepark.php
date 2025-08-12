<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class themepark extends Model
{
    protected $table = 'themeparks';
    
    protected $fillable = [
        'location_id',
        'name',
        'description',
        'rating',
        'status',
        'featured',
        'image_url',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'featured' => 'boolean',
    ];

    // Relationships
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ThemeparkActivity::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ThemeparkImage::class);
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

    // Helper Methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isFeatured(): bool
    {
        return $this->featured;
    }

    public function getFormattedRatingAttribute(): string
    {
        return number_format($this->rating, 1);
    }
}
