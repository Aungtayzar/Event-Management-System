<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingCancellation;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use App\Notifications\BookingCancelled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of all bookings
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'event', 'ticketType', 'cancellation.cancelledBy']);

        // Search and filter functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('event', function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%");
            })->orWhere('id', 'LIKE', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->get('event_id'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get data for filters
        $events = Event::orderBy('title')->get();
        $statuses = ['confirmed', 'cancelled', 'pending', 'refunded'];

        return view('admin.bookings.index', compact('bookings', 'events', 'statuses'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create()
    {
        $users = User::where('role', '!=', 'admin')->orderBy('name')->get();
        $events = Event::where('date', '>=', now())->orderBy('date')->get();

        return view('admin.bookings.create', compact('users', 'events'));
    }

    /**
     * Store a newly created booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:confirmed,pending',
            'notes' => 'nullable|string|max:1000'
        ]);

        $ticketType = TicketType::findOrFail($validated['ticket_type_id']);

        // Check availability
        if ($ticketType->quantity < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Not enough tickets available.']);
        }

        $booking = Booking::create([
            'user_id' => $validated['user_id'],
            'event_id' => $validated['event_id'],
            'ticket_type_id' => $validated['ticket_type_id'],
            'quantity' => $validated['quantity'],
            'total_price' => $ticketType->price * $validated['quantity'],
            'status' => $validated['status'],
        ]);

        $ticketType->decrement('quantity', $validated['quantity']);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'event', 'ticketType', 'cancellation.cancelledBy']);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking
     */
    public function edit(Booking $booking)
    {
        if ($booking->isCancelled()) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'Cannot edit a cancelled booking.');
        }

        $users = User::where('role', '!=', 'admin')->orderBy('name')->get();
        $ticketTypes = TicketType::where('event_id', $booking->event_id)->get();

        return view('admin.bookings.edit', compact('booking', 'users', 'ticketTypes'));
    }

    /**
     * Update the specified booking
     */
    public function update(Request $request, Booking $booking)
    {
        if ($booking->isCancelled()) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'Cannot edit a cancelled booking.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:confirmed,pending',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Handle quantity changes
        $oldQuantity = $booking->quantity;
        $newQuantity = $validated['quantity'];
        $quantityDiff = $newQuantity - $oldQuantity;

        if ($quantityDiff > 0) {
            // Adding tickets - check availability
            if ($booking->ticketType->quantity < $quantityDiff) {
                return back()->withErrors(['quantity' => 'Not enough tickets available.']);
            }
            $booking->ticketType->decrement('quantity', $quantityDiff);
        } elseif ($quantityDiff < 0) {
            // Reducing tickets - return to pool
            $booking->ticketType->increment('quantity', abs($quantityDiff));
        }

        $booking->update([
            'user_id' => $validated['user_id'],
            'quantity' => $validated['quantity'],
            'total_price' => $booking->ticketType->price * $validated['quantity'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Show cancellation form
     */
    public function showCancelForm(Booking $booking)
    {
        if ($booking->isCancelled()) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'This booking is already cancelled.');
        }

        $cancellationReasons = [
            'fraud' => 'Fraudulent Activity',
            'payment_failed' => 'Payment Failed',
            'customer_request' => 'Customer Request',
            'event_cancelled' => 'Event Cancelled',
            'duplicate_booking' => 'Duplicate Booking',
            'system_error' => 'System Error',
            'other' => 'Other'
        ];

        return view('admin.bookings.cancel', compact('booking', 'cancellationReasons'));
    }

    /**
     * Cancel the specified booking
     */
    public function cancel(Request $request, Booking $booking)
    {
        if ($booking->isCancelled()) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'This booking is already cancelled.');
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
            'refund_amount' => 'required|numeric|min:0|max:' . $booking->total_price,
            'refund_status' => 'required|in:pending,completed,failed',
        ]);

        DB::transaction(function () use ($booking, $validated) {
            // Update booking status
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $validated['reason'],
                'refund_amount' => $validated['refund_amount'],
            ]);

            // Create cancellation record
            BookingCancellation::create([
                'booking_id' => $booking->id,
                'cancelled_by_user_id' => Auth::id(),
                'reason' => $validated['reason'],
                'notes' => $validated['notes'],
                'refund_amount' => $validated['refund_amount'],
                'refund_status' => $validated['refund_status'],
            ]);

            // Return tickets to pool
            $booking->ticketType->increment('quantity', $booking->quantity);

            // Send cancellation notification to customer
            $booking->user->notify(new BookingCancelled($booking, $validated['reason']));
        });

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Get ticket types for an event (AJAX endpoint)
     */
    public function getTicketTypes(Event $event)
    {
        $ticketTypes = $event->ticketTypes()->where('quantity', '>', 0)->get();

        return response()->json($ticketTypes);
    }

    /**
     * Export bookings to CSV
     */
    public function export(Request $request)
    {
        $query = Booking::with(['user', 'event', 'ticketType', 'cancellation.cancelledBy']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })->orWhereHas('event', function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->get('event_id'));
        }

        $bookings = $query->orderBy('created_at', 'desc')->get();

        $filename = 'bookings_export_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($file, [
                'Booking ID',
                'Customer Name',
                'Customer Email',
                'Event Title',
                'Event Date',
                'Ticket Type',
                'Quantity',
                'Total Price',
                'Status',
                'Booking Date',
                'Cancelled At',
                'Cancellation Reason',
                'Refund Amount',
                'Cancelled By'
            ]);

            // CSV Data
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->user->name,
                    $booking->user->email,
                    $booking->event->title,
                    $booking->event->date,
                    $booking->ticketType->name,
                    $booking->quantity,
                    $booking->total_price,
                    $booking->status,
                    $booking->created_at->format('Y-m-d H:i:s'),
                    $booking->cancelled_at ? $booking->cancelled_at->format('Y-m-d H:i:s') : '',
                    $booking->cancellation_reason ?? '',
                    $booking->refund_amount ?? '',
                    $booking->cancellation ? $booking->cancellation->cancelledBy->name : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
