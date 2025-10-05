<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'banner_image',
        'category_id',
        'organizer_id',
        'is_published'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if the event date is in the past
     */
    public function isPast(): bool
    {
        return $this->date < now();
    }
}
