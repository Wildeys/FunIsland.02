<?php

namespace App\Http\Controllers;

use App\Models\hotel;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['browse']);
        $this->middleware('role:hotel_manager,administrator')->except(['index', 'show', 'browse']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::with(['location'])->paginate(12);
        
        if (auth()->user()->hasRole('customer')) {
            return view('hotels.customer.index', compact('hotels'));
        }
        
        return view('hotels.management.index', compact('hotels'));
    }

    /**
     * Public browsing without authentication
     */
    public function browse()
    {
        $hotels = hotel::with(['location'])
            ->where('status', 'active')
            ->paginate(12);
        
        $featuredHotels = hotel::with(['location'])
            ->where('status', 'active')
            ->where('featured', true)
            ->limit(3)
            ->get();
        
        return view('hotels.browse', compact('hotels', 'featuredHotels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->canManageHotels()) {
            abort(403, 'Unauthorized');
        }
        
        $locations = Location::all();
        return view('hotels.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->canManageHotels()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'rating' => 'nullable|numeric|between:0,5'
        ]);

        $hotel = Hotel::create($validated);

        return redirect()->route('hotels.index')
            ->with('success', 'Hotel created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(hotel $hotel)
    {
        $hotel->load(['location', 'rooms' => function($query) {
            $query->available()->orderBy('room_type')->orderBy('room_number');
        }]);
        
        if (auth()->user()->hasRole('customer')) {
            return view('hotels.customer.show', compact('hotel'));
        }
        
        return view('hotels.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        if (!auth()->user()->canManageHotels()) {
            abort(403, 'Unauthorized');
        }
        
        $locations = Location::all();
        return view('hotels.edit', compact('hotel', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotel $hotel)
    {
        if (!auth()->user()->canManageHotels()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location_id' => 'required|exists:locations,id',
            'rating' => 'nullable|numeric|between:0,5'
        ]);

        $hotel->update($validated);

        return redirect()->route('hotels.index')
            ->with('success', 'Hotel updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        if (!auth()->user()->canManageHotels()) {
            abort(403, 'Unauthorized');
        }

        $hotel->delete();

        return redirect()->route('hotels.index')
            ->with('success', 'Hotel deleted successfully!');
    }

    /**
     * Handle hotel room booking
     */
    public function book(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1|max:10',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $room = Room::findOrFail($validated['room_id']);
        $hotel = hotel::findOrFail($validated['hotel_id']);

        // Check if room is available
        if (!$room->isAvailable()) {
            return back()->with('error', 'Sorry, this room is not available for booking.');
        }

        // Check if room capacity matches guests
        if ($validated['guests'] > $room->capacity) {
            return back()->with('error', 'The selected room can only accommodate up to ' . $room->capacity . ' guests.');
        }

        // Calculate total amount
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);
        $totalAmount = $nights * $room->price_per_night;

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'booking_type' => 'hotel',
            'hotel_id' => $validated['hotel_id'],
            'room_id' => $validated['room_id'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'guests' => $validated['guests'],
            'total_amount' => $totalAmount,
            'special_requests' => $validated['special_requests'],
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Your booking has been created successfully! Booking reference: ' . $booking->booking_reference);
    }

    /**
     * Hotel manager dashboard
     */
    public function dashboard()
    {
        if (!auth()->user()->canManageHotels()) {
            abort(403, 'Unauthorized');
        }

        $totalHotels = Hotel::count();
        $totalBookings = 0; // TODO: Add when booking model is ready
        $recentBookings = []; // TODO: Add when booking model is ready
        
        return view('hotels.management.dashboard', compact('totalHotels', 'totalBookings', 'recentBookings'));
    }
}
