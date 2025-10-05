<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\TicketType;
use App\Notifications\BookingRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{

    public function index()
    {
        // Include cancelled bookings in history, load all necessary relationships
        $bookings = Auth::user()->bookings()
            ->with(['event', 'ticketType', 'cancellation.cancelledBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request, Event $event)
    {
        // Check if event date is in the past
        if ($event->date < now()) {
            return back()->withErrors(['event' => 'This event has already passed. Booking is no longer available.']);
        }

        $validated = $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $ticketType = TicketType::findOrFail($validated['ticket_type_id']);
        if ($ticketType->quantity < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Not enough tickets available.']);
        }
        // Check for existing active booking (not cancelled)
        $activeBooking = Booking::where('user_id', Auth::user()->id)
            ->where('event_id', $event->id)
            ->where('ticket_type_id', $validated['ticket_type_id'])
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($activeBooking) {
            // If there's an active booking, add quantity to it
            $totalQuantity = (int) $activeBooking->quantity + (int) $validated['quantity'];
            $activeBooking->update([
                'quantity' => $totalQuantity,
                'total_price' => $ticketType->price * $totalQuantity,
            ]);
            $booking = $activeBooking;
        } else {
            // If no active booking exists, create new booking
            $booking = Booking::create([
                'user_id' => Auth::user()->id,
                'event_id' => $event->id,
                'ticket_type_id' => $ticketType->id,
                'quantity' => $validated['quantity'],
                'total_price' => $ticketType->price * $validated['quantity'],
            ]);
        }

        $ticketType->decrement('quantity', $validated['quantity']);

        // Send confirmation email
        Auth::user()->notify(new BookingRegister($booking));



        return redirect()->route('bookings.index')->with('success', 'Booking confirmed.');
    }
}
