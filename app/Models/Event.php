<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title', 'description', 'category_id', 'event_date', 
        'event_time', 'venue', 'capacity', 'price', 
        'organizer', 'contact', 'poster', 'status'
    ];

    protected $casts = [
        'event_date' => 'date',
        'price' => 'decimal:2',
    ];

    // ============ RELATIONS ============
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    // ============ SCOPES ============
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->format('Y-m-d'));
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->format('Y-m-d'));
    }

    // ============ ACCESSORS ============
    public function getAvailableSlotsAttribute(): int
    {
        return $this->capacity - $this->registrations()->count();
    }

    // ============ METHODS ============
    public function isFull(): bool
    {
        return $this->available_slots <= 0;
    }

    public function isPast(): bool
    {
        return $this->event_date && $this->event_date->isPast();
    }

    public function isUpcoming(): bool
    {
        return $this->event_date && $this->event_date->isFuture();
    }

    // ============ UPDATE STATUS OTOMATIS (AMAN DARI NULL) ============
    public function updateStatus(): void
    {
        // Cek dulu apakah event_date ada (ga null)
        if ($this->event_date) {
            if ($this->event_date->isPast() && $this->status !== 'done') {
                $this->update(['status' => 'done']);
            } elseif ($this->event_date->isFuture() && $this->status === 'done') {
                // Kalo mau balikin ke published kalo sengaja keubah
                $this->update(['status' => 'published']);
            }
        }
    }

    // ============ BOOT ============
    protected static function boot()
    {
        parent::boot();

        // Auto update status setiap kali event di-load
        static::retrieved(function ($event) {
            $event->updateStatus();
        });
    }
}