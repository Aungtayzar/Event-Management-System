<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_type_id',
        'quantity',
        'total_price',
        'status',
        'cancelled_at',
        'cancellation_reason',
        'refund_amount'
    ];

    protected $casts = [
        'cancelled_at' => 'datetime',
        'total_price' => 'decimal:2',
        'refund_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }

    public function cancellation(): HasOne
    {
        return $this->hasOne(BookingCancellation::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'cancelled');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Helper methods
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function canBeEdited(): bool
    {
        return !$this->isCancelled() && $this->event->date > now();
    }

    public function canBeCancelled(): bool
    {
        return !$this->isCancelled();
    }

    public function getStatusDisplayAttribute(): string
    {
        if ($this->isCancelled()) {
            $cancelledBy = $this->cancellation?->cancelledBy;
            if ($cancelledBy && $cancelledBy->role === 'admin') {
                return 'Cancelled by Admin';
            }
            return 'Cancelled';
        }
        return ucfirst($this->status);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function getCancellationDisplayAttribute(): ?string
    {
        if (!$this->isCancelled() || !$this->cancellation) {
            return null;
        }

        $reason = $this->cancellation->reason;
        if ($this->cancellation->notes) {
            return "Cancelled by Admin – {$this->cancellation->notes}";
        }
        return "Cancelled by Admin – {$reason}";
    }

    public function getRefundDisplayAttribute(): ?string
    {
        if (!$this->isCancelled() || !$this->refund_amount || $this->refund_amount <= 0) {
            return null;
        }

        $refundStatus = $this->cancellation?->refund_status ?? 'pending';
        $amount = number_format($this->refund_amount, 2);

        return match ($refundStatus) {
            'completed' => "Refund of \${$amount} has been processed.",
            'pending' => "Refund of \${$amount} has been initiated. It may take 5–7 days to reflect.",
            'failed' => "Refund of \${$amount} failed. Please contact support.",
            default => "Refund of \${$amount} is being processed."
        };
    }
}
