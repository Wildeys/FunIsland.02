<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventBooking;

class BeachController extends Controller
{
    /**
     * Display a listing of beach events and activities.
     */
    public function index()
    {
        // Get beach events and activities from the database
        $beachEvents = Event::where('type', 'beach_event')
            ->orWhere('type', 'activity')
            ->orWhere('type', 'entertainment')
            ->active()
            ->upcoming()
            ->available()
            ->orderBy('start_time')
            ->get();

        return view('beaches.customer.index', compact('beachEvents'));
    }

    /**
     * Display the specified beach event.
     */
    public function show($id)
    {
        $beachEvent = Event::findOrFail($id);

        // Ensure it's a beach-related event
        if (!in_array($beachEvent->type, ['beach_event', 'activity', 'entertainment'])) {
            abort(404, 'Beach event not found');
        }

        return view('beaches.show', compact('beachEvent'));
    }

    /**
     * Book a beach event.
     */
    public function book(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to book beach events.');
        }

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'participants' => 'required|integer|min:1|max:10',
            'special_requirements' => 'nullable|string|max:500',
        ]);

        $event = Event::findOrFail($validated['event_id']);

        // Check if event is beach-related
        if (!in_array($event->type, ['beach_event', 'activity', 'entertainment'])) {
            return back()->with('error', 'Invalid event type for beach booking.');
        }

        // Check availability
        if ($event->available_spots < $validated['participants']) {
            return back()->with('error', 'Not enough spots available for this event.');
        }

        // Check if event is still upcoming
        if (!$event->isUpcoming()) {
            return back()->with('error', 'This event has already started or ended.');
        }

        $totalPrice = $event->price * $validated['participants'];

        // Create booking using EventBooking model
        $booking = EventBooking::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
            'quantity' => $validated['participants'],
            'total_price' => $totalPrice,
            'special_requirements' => $validated['special_requirements'] ?? null,
        ]);

        // Update available spots
        $event->decrement('available_spots', $validated['participants']);

        return redirect()->route('beaches.customer.index')
            ->with('success', "Beach event booked successfully! Booking reference: {$booking->id}");
    }

    /**
     * Browse beach events (public access).
     */
    public function browse()
    {
        // Mock beach events data for public browsing
        $beachEvents = [
            [
                'id' => 1,
                'name' => 'Sunset Beach Volleyball Tournament',
                'description' => 'Join our exciting beach volleyball tournament with prizes for winners!',
                'location' => 'Paradise Beach',
                'date' => '2024-01-15',
                'time' => '18:00',
                'price' => 25.00,
                'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400'
            ],
            [
                'id' => 2,
                'name' => 'Beach Yoga & Meditation',
                'description' => 'Start your day with peaceful yoga and meditation by the ocean.',
                'location' => 'Serenity Cove',
                'date' => '2024-01-16',
                'time' => '07:00',
                'price' => 15.00,
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400'
            ]
        ];

        return view('beaches.browse', compact('beachEvents'));
    }
} 