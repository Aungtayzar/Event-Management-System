<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TicketTypeController extends Controller
{
    use AuthorizesRequests;

    public function create(Event $event)
    {
        $this->authorize('update', $event);
        return view('ticket-types.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        $event->ticketTypes()->create($validated);

        return redirect()->route('organizer.dashboard')->with('success', 'Ticket type created successfully!');
    }

    public function edit(TicketType $ticketType)
    {
        $this->authorize('update', $ticketType->event);
        return view('ticket-types.edit', compact('ticketType'));
    }

    public function update(Request $request, TicketType $ticketType)
    {
        $this->authorize('update', $ticketType->event);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
        ]);

        $ticketType->update($validated);

        return redirect()->route('organizer.dashboard')->with('success', 'Ticket type updated successfully!');
    }

    public function destroy(TicketType $ticketType)
    {
        $this->authorize('update', $ticketType->event);

        $ticketType->delete();

        return redirect()->route('organizer.dashboard')->with('success', 'Ticket type deleted successfully!');
    }
}
