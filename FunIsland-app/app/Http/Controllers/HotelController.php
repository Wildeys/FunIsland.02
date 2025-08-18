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
        $this->middleware('role:hotel_manager,administrator')->except(['index', 'show', 'browse', 'book']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = hotel::with(['location', 'rooms']);
        
        // For customer view, only show active hotels
        if (auth()->user()->hasRole('customer')) {
            $query->where('status', 'active');
            $hotels = $query->paginate(12);
            return view('hotels.customer.index', compact('hotels'));
        }
        
        // Management view with search and filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('location', function($locationQuery) use ($search) {
                      $locationQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('featured')) {
            $query->where('featured', $request->featured == '1');
        }
        
        $hotels = $query->orderBy('created_at', 'desc')->paginate(12);
        
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
        return view('hotels.management.create', compact('locations'));
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
            'description' => 'required|string|max:2000',
            'location_id' => 'required|exists:locations,id',
            'price_per_night' => 'required|numeric|min:0|max:9999.99',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|max:100',
            'contact_info' => 'nullable|array',
            'contact_info.phone' => 'nullable|string|max:20',
            'contact_info.email' => 'nullable|email|max:100',
            'contact_info.website' => 'nullable|url|max:255',
            'image_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive,maintenance',
            'featured' => 'boolean'
        ]);

        $hotel = hotel::create($validated);

        return redirect()->route('hotels.management.index')
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
        
        return view('hotels.management.show', compact('hotel'));
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
        return view('hotels.management.edit', compact('hotel', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, hotel $hotel)
    {
        if (!auth()->user()->canManageHotels()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'location_id' => 'required|exists:locations,id',
            'price_per_night' => 'required|numeric|min:0|max:9999.99',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|max:100',
            'contact_info' => 'nullable|array',
            'contact_info.phone' => 'nullable|string|max:20',
            'contact_info.email' => 'nullable|email|max:100',
            'contact_info.website' => 'nullable|url|max:255',
            'image_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive,maintenance',
            'featured' => 'boolean'
        ]);

        $hotel->update($validated);

        return redirect()->route('hotels.management.index')
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

        return redirect()->route('hotels.management.index')
            ->with('success', 'Hotel deleted successfully!');
    }

    /**
     * Handle hotel room booking
     */
    public function book(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_id' => 'required|exists:hotel_rooms,id',
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
            'hotel_room_id' => $validated['room_id'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'guests' => $validated['guests'],
            'total_amount' => $totalAmount,
            'special_requests' => $validated['special_requests'],
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        return redirect()->route('bookings.my')
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

        // Get all hotel bookings
        $hotelBookingsQuery = Booking::where('booking_type', 'hotel')
            ->whereNotNull('hotel_id');
        
        // If not admin, only show bookings for hotels the user manages
        if (!auth()->user()->isAdministrator()) {
            // For now, show all hotel bookings. In a more complex system,
            // you'd filter by hotels the manager is responsible for
            // $hotelBookingsQuery->whereHas('hotel', function($q) {
            //     $q->where('manager_id', auth()->id());
            // });
        }

        $totalHotels = hotel::count();
        $totalBookings = $hotelBookingsQuery->count();
        
        // This month's bookings
        $thisMonthBookings = $hotelBookingsQuery->clone()
            ->whereMonth('booked_at', Carbon::now()->month)
            ->whereYear('booked_at', Carbon::now()->year)
            ->count();
        
        // Total revenue from paid bookings
        $totalRevenue = $hotelBookingsQuery->clone()
            ->where('payment_status', 'paid')
            ->sum('total_amount');
        
        // Recent bookings (last 10)
        $recentBookings = $hotelBookingsQuery->clone()
            ->with(['user', 'hotel', 'room'])
            ->orderBy('booked_at', 'desc')
            ->take(10)
            ->get();
        
        // Booking trends data for the last 12 months
        $bookingTrends = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = $hotelBookingsQuery->clone()
                ->whereMonth('booked_at', $date->month)
                ->whereYear('booked_at', $date->year)
                ->count();
            
            $bookingTrends[] = [
                'month' => $date->format('M Y'),
                'count' => $count,
                'short_month' => $date->format('M'),
            ];
        }
        
        return view('hotels.management.dashboard', compact(
            'totalHotels', 
            'totalBookings', 
            'thisMonthBookings',
            'totalRevenue',
            'recentBookings',
            'bookingTrends'
        ));
    }
}
