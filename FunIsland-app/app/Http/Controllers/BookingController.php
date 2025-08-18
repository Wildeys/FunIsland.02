<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'hotel', 'room', 'ferry', 'event'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_type' => 'required|in:hotel,ferry,event,themepark',
            'hotel_id' => 'nullable|exists:hotels,id',
            'room_id' => 'nullable|exists:hotel_room,id',
            'ferry_id' => 'nullable|exists:ferries,id',
            'event_id' => 'nullable|exists:events,id',
            'check_in_date' => 'nullable|date|after_or_equal:today',
            'check_out_date' => 'nullable|date|after:check_in_date',
            'guests' => 'required|integer|min:1|max:20',
            'total_amount' => 'required|numeric|min:0',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';
        $validated['payment_status'] = 'pending';

        $booking = Booking::create($validated);
        
        return redirect()->route('bookings.show', $booking)->with('success', 'Booking created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        // Ensure the user can only view their own booking or is authorized management
        if ($booking->user_id !== auth()->id() && !auth()->user()->canManageTicketing() && !auth()->user()->isAdministrator()) {
            abort(403, 'Unauthorized access to booking details.');
        }

        $booking->load(['user', 'hotel', 'room', 'ferry', 'event']);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        // Check if user can edit this booking
        if ($booking->user_id !== auth()->id() && !auth()->user()->canManageTicketing() && !auth()->user()->isAdministrator()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow editing of pending bookings
        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Only pending bookings can be edited.');
        }

        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        // Check if user can update this booking
        if ($booking->user_id !== auth()->id() && !auth()->user()->canManageTicketing() && !auth()->user()->isAdministrator()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow updating of pending bookings
        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Only pending bookings can be updated.');
        }

        $validated = $request->validate([
            'check_in_date' => 'nullable|date|after_or_equal:today',
            'check_out_date' => 'nullable|date|after:check_in_date',
            'guests' => 'required|integer|min:1|max:20',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $booking->update($validated);
        
        return redirect()->route('bookings.show', $booking)->with('success', 'Booking updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // Check if user can delete this booking
        if ($booking->user_id !== auth()->id() && !auth()->user()->canManageTicketing() && !auth()->user()->isAdministrator()) {
            abort(403, 'Unauthorized access.');
        }

        // Only allow deletion of pending or cancelled bookings
        if (!in_array($booking->status, ['pending', 'cancelled'])) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Only pending or cancelled bookings can be deleted.');
        }

        $booking->delete();
        
        return redirect()->route('bookings.my')->with('success', 'Booking deleted successfully!');
    }

    /**
     * Display the current user's bookings.
     */
    public function myBookings()
    {
        $user = auth()->user();
        $bookings = Booking::where('user_id', $user->id)
            ->with(['hotel', 'room', 'ferry', 'event'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.my', compact('bookings'));
    }

    /**
     * Display bookings for customer users.
     */
    public function customerBookings()
    {
        return $this->myBookings();
    }

    /**
     * Update booking status (for staff/managers).
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Booking $booking)
    {
        // Check if user can cancel this booking
        if ($booking->user_id !== auth()->id() && !auth()->user()->canManageTicketing()) {
            abort(403, 'Unauthorized access.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Staff view of bookings (view-only for hotel staff).
     */
    public function staffView()
    {
        $bookings = Booking::with(['hotel', 'room', 'user'])
            ->whereHas('hotel') // Only hotel bookings for hotel staff
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('bookings.staff', compact('bookings'));
    }

    /**
     * Create hotel booking
     */
    public function hotelBooking(Request $request, $hotel_id)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:hotel_room,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'guests' => 'required|integer|min:1|max:10',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        // Calculate total amount (basic calculation)
        $room = \App\Models\Room::findOrFail($validated['room_id']);
        $nights = \Carbon\Carbon::parse($validated['check_in_date'])->diffInDays($validated['check_out_date']);
        $total_amount = $room->price_per_night * $nights;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'booking_type' => 'hotel',
            'hotel_id' => $hotel_id,
            'room_id' => $validated['room_id'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'guests' => $validated['guests'],
            'total_amount' => $total_amount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Hotel booking created successfully!');
    }

    /**
     * Create ferry booking
     */
    public function ferryBooking(Request $request, $ferry_id)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:ferry_schedule,id',
            'passengers' => 'required|integer|min:1|max:20',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        // Get ferry schedule for pricing
        $schedule = \App\Models\FerrySchedule::findOrFail($validated['schedule_id']);
        $total_amount = $schedule->price * $validated['passengers'];

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'booking_type' => 'ferry',
            'ferry_id' => $ferry_id,
            'guests' => $validated['passengers'],
            'total_amount' => $total_amount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
            'check_in_date' => $schedule->date, // Use ferry date as check-in date
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Ferry booking created successfully!');
    }

    /**
     * Create themepark booking
     */
    public function themeparkBooking(Request $request, $themepark_id)
    {
        $validated = $request->validate([
            'visit_date' => 'required|date|after_or_equal:today',
            'visitors' => 'required|integer|min:1|max:20',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        // Basic themepark pricing (you can make this more sophisticated)
        $base_price = 50.00; // Base price per person
        $total_amount = $base_price * $validated['visitors'];

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'booking_type' => 'themepark',
            'guests' => $validated['visitors'],
            'total_amount' => $total_amount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
            'check_in_date' => $validated['visit_date'],
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Theme park booking created successfully!');
    }

    /**
     * Create event booking
     */
    public function eventBooking(Request $request, $event_id)
    {
        $validated = $request->validate([
            'attendees' => 'required|integer|min:1|max:20',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        // Get event for pricing
        $event = \App\Models\Event::findOrFail($event_id);
        $total_amount = $event->price * $validated['attendees'];

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'booking_type' => 'event',
            'event_id' => $event_id,
            'guests' => $validated['attendees'],
            'total_amount' => $total_amount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
            'check_in_date' => $event->event_date,
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Event booking created successfully!');
    }

    /**
     * Hotel manager view of all hotel bookings
     */
    public function hotelManagerBookings(Request $request)
    {
        if (!auth()->user()->canManageHotels()) {
            abort(403, 'Unauthorized access.');
        }

        $query = Booking::where('booking_type', 'hotel')
            ->with(['user', 'hotel', 'room'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('hotel', function($hotelQuery) use ($search) {
                      $hotelQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $bookings = $query->paginate(15);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Hotel manager view of pending bookings only
     */
    public function pendingHotelBookings()
    {
        if (!auth()->user()->canManageHotels()) {
            abort(403, 'Unauthorized access.');
        }

        $bookings = Booking::where('booking_type', 'hotel')
            ->where('status', 'pending')
            ->with(['user', 'hotel', 'room'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Approve a hotel booking
     */
    public function approveBooking(Booking $booking)
    {
        if (!auth()->user()->canManageHotels()) {
            abort(403, 'Unauthorized access.');
        }

        // Ensure it's a hotel booking
        if ($booking->booking_type !== 'hotel') {
            abort(403, 'Can only approve hotel bookings.');
        }

        // Can only approve pending bookings
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending bookings can be approved.');
        }

        $booking->update([
            'status' => 'confirmed'
        ]);

        // TODO: Send confirmation email to customer
        // TODO: Update room availability if needed

        return redirect()->back()->with('success', 'Booking approved successfully! Customer will be notified.');
    }

    /**
     * Reject a hotel booking
     */
    public function rejectBooking(Request $request, Booking $booking)
    {
        if (!auth()->user()->canManageHotels()) {
            abort(403, 'Unauthorized access.');
        }

        // Ensure it's a hotel booking
        if ($booking->booking_type !== 'hotel') {
            abort(403, 'Can only reject hotel bookings.');
        }

        // Can only reject pending bookings
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending bookings can be rejected.');
        }

        // Optional: Get rejection reason from request
        $rejectionReason = $request->input('rejection_reason', 'Booking rejected by hotel manager');

        $booking->update([
            'status' => 'cancelled',
            'special_requests' => $booking->special_requests . "\n\nRejection Reason: " . $rejectionReason
        ]);

        // TODO: Send rejection email to customer with reason
        // TODO: Release room availability if needed

        return redirect()->back()->with('success', 'Booking rejected. Customer will be notified.');
    }
}
