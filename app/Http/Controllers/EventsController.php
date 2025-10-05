<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;

    // Admin index - shows all events for admin management
    public function adminIndex()
    {
        $events = Event::with(['category', 'organizer', 'ticketTypes', 'bookings'])->orderBy('created_at', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    // Admin create form
    public function adminCreate()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    // Admin store
    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->input('is_published', false);
        $validated['organizer_id'] = $request->user()->id; // Use the authenticated user's ID

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }

        $event = Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    // Admin edit form
    public function adminEdit(Event $event)
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    // Admin update
    public function adminUpdate(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->input('is_published', false);

        if ($request->hasFile('banner_image')) {
            // Delete the old banner image from storage
            if ($event->banner_image) {
                Storage::delete('public/' . $event->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    // Admin delete
    public function adminDestroy(Event $event)
    {
        // Check if event has any bookings
        $bookingsCount = $event->bookings()->count();

        if ($bookingsCount > 0) {
            return redirect()->route('admin.events.index')
                ->with('error', "Cannot delete event '{$event->title}'. It has {$bookingsCount} booking. Please cancel all bookings of this event.");
        }

        // Delete banner image if exists
        if ($event->banner_image) {
            Storage::delete('public/' . $event->banner_image);
        }

        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    // Public index - shows only published events
    public function index()
    {
        $events = Event::where('is_published', true)->with(['category', 'ticketTypes'])->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Event::class);
        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Event::class);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->input('is_published', false);

        $validated['organizer_id'] = $request->user()->id; // Use the authenticated user's ID
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }
        $event = Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load(['category', 'organizer', 'ticketTypes']);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorize('update', $event);
        $categories = Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->input('is_published', false);

        $validated['organizer_id'] = $request->user()->id; // Use the authenticated user's ID
        if ($request->hasFile('banner_image')) {

            // Delete the old banner image from storage
            if ($event->banner_image) {
                Storage::delete('public/banners/' . basename($event->banner_image));
            }

            $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }
        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = Event::where('is_published', true);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Handle date range filtering
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Legacy support for single date filter (if still used elsewhere)
        if ($request->filled('date') && !$request->filled('date_from') && !$request->filled('date_to')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->filled('price')) {
            if ($request->price === 'free') {
                $query->whereHas('ticketTypes', function ($q) {
                    $q->where('price', 0);
                });
            } else {
                $query->whereHas('ticketTypes', function ($q) {
                    $q->where('price', '>', 0);
                });
            }
        }

        $events = $query->with(['category', 'ticketTypes'])->orderBy('date', 'asc')->get();
        $categories = Category::all();

        return view('events.index', compact('events', 'categories'));
    }
}
