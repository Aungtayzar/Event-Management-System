<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingRegister extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
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
        return (new MailMessage)
            ->subject('Booking Confirmation - ' . $this->booking->event->title)
            ->greeting('Dear ' . $notifiable->name . ',')
            ->line('Thank you for your booking! We are pleased to confirm your registration for the following event:')
            ->line('**Event:** ' . $this->booking->event->title)
            ->line('**Date:** ' . date('F j, Y', strtotime($this->booking->event->date)))
            ->line('**Venue:** ' . $this->booking->event->location)
            ->line('**Ticket Type:** ' . $this->booking->ticketType->name)
            ->line('**Quantity:** ' . $this->booking->quantity)
            ->line('**Total Amount:** $' . number_format($this->booking->total_price, 2))
            ->line('**Booking Reference:** #' . $this->booking->id)
            ->action('View Event Details', url('/events/' . $this->booking->event->id))
            ->line('Please keep this confirmation email for your records. If you have any questions or need to make changes to your booking, please contact us.')
            ->line('We look forward to seeing you at the event!')
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
            //
        ];
    }
}
