<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index()
    {
        $events = auth()->user()->events()
            ->withCount('bookings')
            ->with('ticketTypes')
            ->get();
        return view('organizer.dashboard', compact('events'));
    }
}
