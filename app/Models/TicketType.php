<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketType extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'event_id',
        'name',
        'price',
        'quantity'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
