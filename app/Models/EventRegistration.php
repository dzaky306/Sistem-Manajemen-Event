<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    protected $fillable = [
        'event_id', 'participant_name', 'email', 'phone',
        'institution', 'ticket_code', 'payment_status', 'attended'
    ];

    protected $casts = [
        'attended' => 'boolean'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    // Generate ticket code otomatis
    public static function generateTicketCode(): string
    {
        do {
            $code = 'TICKET-' . strtoupper(uniqid());
        } while (self::where('ticket_code', $code)->exists());

        return $code;
    }
}