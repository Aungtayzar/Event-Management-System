<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelled extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking, string $reason = null)
    {
        $this->booking = $booking;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject('Booking Cancelled - ' . $this->booking->event->title)
            ->greeting('Dear ' . $notifiable->name . ',')
            ->line('We regret to inform you that your booking has been cancelled.')
            ->line('**Event:** ' . $this->booking->event->title)
            ->line('**Date:** ' . date('F j, Y', strtotime($this->booking->event->date)))
            ->line('**Venue:** ' . $this->booking->event->location)
            ->line('**Ticket Type:** ' . $this->booking->ticketType->name)
            ->line('**Quantity:** ' . $this->booking->quantity)
            ->line('**Booking Reference:** #' . $this->booking->id);

        if ($this->reason) {
            $mailMessage->line('**Reason:** ' . $this->getReasonText($this->reason));
        }

        if ($this->booking->refund_amount > 0) {
            $mailMessage->line('**Refund Amount:** $' . number_format($this->booking->refund_amount, 2))
                ->line('Your refund will be processed and credited back to your original payment method within 5-7 business days.');
        }

        return $mailMessage->line('If you have any questions about this cancellation or need assistance with rebooking, please don\'t hesitate to contact our support team.')
            ->action('Browse Other Events', url('/events'))
            ->line('We apologize for any inconvenience caused and appreciate your understanding.')
            ->salutation('Best regards, The Event Management Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'event_title' => $this->booking->event->title,
            'reason' => $this->reason,
            'refund_amount' => $this->booking->refund_amount,
        ];
    }

    /**
     * Get human-readable reason text
     */
    private function getReasonText(string $reason): string
    {
        $reasons = [
            'fraud' => 'Fraudulent Activity Detected',
            'payment_failed' => 'Payment Processing Failed',
            'customer_request' => 'Requested by Customer',
            'event_cancelled' => 'Event Has Been Cancelled',
            'duplicate_booking' => 'Duplicate Booking Found',
            'system_error' => 'System Error Correction',
            'other' => 'Administrative Decision'
        ];

        return $reasons[$reason] ?? ucfirst(str_replace('_', ' ', $reason));
    }
}
