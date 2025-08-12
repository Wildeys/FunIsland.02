<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventBooking;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    /**
     * Display a listing of the resource (for authenticated users).
     */
    public function index(): View
    {
        $events = Event::active()
            ->upcoming()
            ->available()
            ->orderBy('start_time')
            ->paginate(12);

        return view('events.customer.index', compact('events'));
    }

    /**
     * Public browsing without authentication
     */
    public function browse(): View
    {
        $events = Event::active()
            ->upcoming()
            ->available()
            ->orderBy('start_time')
            ->paginate(12);

        $featuredEvents = Event::active()
            ->upcoming()
            ->available()
            ->limit(3)
            ->get();

        return view('events.browse', compact('events', 'featuredEvents'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): View
    {
        return view('events.customer.show', compact('event'));
    }

    /**
     * Store a newly created booking.
     */
    public function book(Request $request, Event $event): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
            'special_requirements' => 'nullable|string|max:500'
        ]);

        // Check availability
        if ($event->available_spots < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough spots available for this event.');
        }

        // Check if event is still upcoming
        if (!$event->isUpcoming()) {
            return redirect()->back()->with('error', 'This event has already started or ended.');
        }

        $totalPrice = $event->price * $request->quantity;

        // Create booking
        $booking = EventBooking::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'special_requirements' => $request->special_requirements,
        ]);

        // Update available spots
        $event->decrement('available_spots', $request->quantity);

        return redirect()->route('events.booking.confirmation', $booking)
            ->with('success', 'Event booking confirmed! Check your email for details.');
    }

    /**
     * Show booking confirmation
     */
    public function bookingConfirmation(EventBooking $booking): View
    {
        // Make sure user can only see their own booking
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('events.customer.confirmation', compact('booking'));
    }

    /**
     * Display a listing for management (admin/staff)
     */
    public function manage(): View
    {
        $events = Event::orderBy('start_time', 'desc')->paginate(20);
        return view('events.management.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('events.management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:beach_event,activity,entertainment',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'duration' => 'required|string|max:50',
            'requirements' => 'nullable|string',
            'difficulty_level' => 'nullable|in:Easy,Moderate,Challenging',
            'image_url' => 'nullable|url'
        ]);

        $validated['available_spots'] = $validated['capacity'];
        $validated['features'] = $request->features ? explode(',', $request->features) : null;

        Event::create($validated);

        return redirect()->route('events.manage')
            ->with('success', 'Event created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event): View
    {
        return view('events.management.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:beach_event,activity,entertainment',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration' => 'required|string|max:50',
            'requirements' => 'nullable|string',
            'difficulty_level' => 'nullable|in:Easy,Moderate,Challenging',
            'status' => 'required|in:active,inactive,cancelled',
            'image_url' => 'nullable|url'
        ]);

        $validated['features'] = $request->features ? explode(',', $request->features) : null;

        $event->update($validated);

        return redirect()->route('events.manage')
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        // Cancel all bookings if there are any
        $event->bookings()->update(['status' => 'cancelled']);
        
        $event->delete();

        return redirect()->route('events.manage')
            ->with('success', 'Event deleted successfully!');
    }

    /**
     * Search events
     */
    public function search(Request $request): View
    {
        $query = Event::active()->upcoming()->available();

        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->difficulty);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $events = $query->orderBy('start_time')->paginate(12);

        return view('events.search', compact('events'));
    }
}
