<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title', 'description', 'category', 'event_date', 
        'event_time', 'venue', 'capacity', 'price', 
        'organizer', 'contact', 'poster', 'status'
    ];

    protected $casts = [
        'event_date' => 'date',
        'price' => 'decimal:2',
        'event_time' => 'datetime:H:i'
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    // Accessor buat cek sisa kuota
    public function getAvailableSlotsAttribute(): int
    {
        return $this->capacity - $this->registrations()->count();
    }

    // Cek apakah event penuh
    public function isFull(): bool
    {
        return $this->available_slots <= 0;
    }

    // Scope buat filter status
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}