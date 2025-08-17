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
        $bookings = booking::all();
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
        $booking = booking::create($request->all());
        return redirect()->route('bookings.index');
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
    public function edit(string $id)
    {
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking->update($request->all());
        return redirect()->route('bookings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking->delete();
        return redirect()->route('bookings.index');
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
}
