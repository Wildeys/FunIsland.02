<?php

namespace App\Http\Controllers;

use App\Models\ferry as Ferry;
use App\Models\Location;
use App\Models\FerrySchedule;
use App\Models\FerryTicketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FerryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ferry::with(['location']);
        
        // For customer view, only show active ferries
        if (auth()->check() && auth()->user()->hasRole('customer')) {
            $query->where('status', 'active');
            $ferries = $query->paginate(12);
            return view('ferries.customer.index', compact('ferries'));
        }
        
        // Management view with search and filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('location', function($locationQuery) use ($search) {
                      $locationQuery->where('location_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('schedules', function($scheduleQuery) use ($search) {
                      $scheduleQuery->where('departure_location', 'like', "%{$search}%")
                                   ->orWhere('arrival_location', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $ferries = $query->orderBy('created_at', 'desc')->paginate(12);
        
        return view('ferries.management.index', compact('ferries'));
    }

    /**
     * Public browsing without authentication
     */
    public function browse()
    {
        // Get ferries with active schedules
        $ferries = Ferry::whereHas('schedules', function($query) {
                $query->where('is_available', true)
                      ->where('date', '>=', now()->format('Y-m-d'));
            })
            ->with(['schedules' => function($query) {
                $query->where('is_available', true)
                      ->where('date', '>=', now()->format('Y-m-d'))
                      ->orderBy('date')
                      ->orderBy('departure_time');
            }])
            ->paginate(12);
        
        // Get featured ferries (first 3 ferries with schedules)
        $featuredRoutes = Ferry::whereHas('schedules', function($query) {
                $query->where('is_available', true)
                      ->where('date', '>=', now()->format('Y-m-d'));
            })
            ->limit(3)
            ->get();
        
        return view('ferries.browse', compact('ferries', 'featuredRoutes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }
        
        $locations = Location::all();
        return view('ferries.management.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'capacity' => 'required|integer|min:1|max:1000',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $ferry = Ferry::create($validated);

        return redirect()->route('ferries.management.index')
            ->with('success', 'Ferry created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ferry $ferry)
    {
        $ferry->load(['location', 'schedules' => function($query) {
            $query->with(['departureLocation', 'arrivalLocation'])
                  ->where('date', '>=', now()->format('Y-m-d'))
                  ->orderBy('date')
                  ->orderBy('departure_time');
        }]);
        
        if (auth()->check() && auth()->user()->hasRole('customer')) {
            return view('ferries.customer.show', compact('ferry'));
        }
        
        return view('ferries.management.show', compact('ferry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ferry $ferry)
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }
        
        $locations = Location::all();
        return view('ferries.management.edit', compact('ferry', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ferry $ferry)
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
            'capacity' => 'required|integer|min:1|max:1000',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $ferry->update($validated);

        return redirect()->route('ferries.management.index')
            ->with('success', 'Ferry updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ferry $ferry)
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }

        $ferry->delete();
        
        return redirect()->route('ferries.management.index')
            ->with('success', 'Ferry deleted successfully!');
    }

    /**
     * Ferry management dashboard
     */
    public function dashboard()
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }

        $totalFerries = Ferry::count();
        $totalSchedules = DB::table('ferry_schedule')->count();
        $activeRoutes = Ferry::whereHas('schedules', function($query) {
                $query->where('is_available', true)
                      ->where('date', '>=', now()->format('Y-m-d'));
            })->count();
        $totalBookings = FerryTicketing::count(); // Total ticket requests
        $pendingTickets = FerryTicketing::where('status', 'pending')->count(); // Pending tickets
        
        // Get recent ticket requests
        $recentBookings = FerryTicketing::with(['user', 'ferrySchedule.ferry', 'ferrySchedule.departureLocation', 'ferrySchedule.arrivalLocation'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $stats = [
            'total_ferries' => $totalFerries,
            'total_schedules' => $totalSchedules,
            'active_routes' => $activeRoutes,
            'total_bookings' => $totalBookings,
            'pending_tickets' => $pendingTickets,
            'recent_bookings' => $recentBookings,
        ];
        
        return view('ferries.management.dashboard', compact('stats'));
    }

    /**
     * Show ferry schedules
     */
    public function schedules(Ferry $ferry)
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }

        $ferry->load(['schedules' => function($query) {
            $query->with(['departureLocation', 'arrivalLocation'])
                  ->orderBy('date')->orderBy('departure_time');
        }]);
        
        $locations = Location::all();
        
        return view('ferries.management.schedules', compact('ferry', 'locations'));
    }

    /**
     * Store a new ferry schedule
     */
    public function storeSchedule(Request $request, Ferry $ferry)
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'departure_time' => 'required|date_format:H:i',
            'departure_location_id' => 'required|exists:locations,id',
            'arrival_location_id' => 'required|exists:locations,id|different:departure_location_id',
            'remaining_seats' => 'required|integer|min:0|max:' . $ferry->capacity,
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        FerrySchedule::create([
            'ferry_id' => $ferry->id,
            'date' => $validated['date'],
            'departure_time' => $validated['departure_time'],
            'departure_location_id' => $validated['departure_location_id'],
            'arrival_location_id' => $validated['arrival_location_id'],
            'price' => $validated['price'],
            'remaining_seats' => $validated['remaining_seats'],
            'is_available' => $validated['is_available'],
        ]);

        return redirect()->route('ferries.schedules', $ferry->id)
            ->with('success', 'Schedule added successfully!');
    }

    /**
     * Delete a ferry schedule
     */
    public function destroySchedule(Ferry $ferry, FerrySchedule $schedule)
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }

        $schedule->delete();
        
        return redirect()->route('ferries.schedules', $ferry->id)
            ->with('success', 'Schedule deleted successfully!');
    }

    /**
     * Show all ferry schedules overview for management
     */
    public function allSchedules()
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }

        // Get today's schedules
        $todaySchedules = FerrySchedule::with(['ferry', 'departureLocation', 'arrivalLocation'])
            ->where('date', now()->toDateString())
            ->orderBy('departure_time')
            ->get();

        // Get upcoming schedules (next 7 days)
        $upcomingSchedules = FerrySchedule::with(['ferry', 'departureLocation', 'arrivalLocation'])
            ->where('date', '>', now()->toDateString())
            ->where('date', '<=', now()->addDays(7)->toDateString())
            ->orderBy('date')
            ->orderBy('departure_time')
            ->get();

        // Get all future schedules grouped by date
        $allFutureSchedules = FerrySchedule::with(['ferry', 'departureLocation', 'arrivalLocation'])
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('departure_time')
            ->get()
            ->groupBy('date');

        $stats = [
            'total_today' => $todaySchedules->count(),
            'total_upcoming' => $upcomingSchedules->count(),
            'available_today' => $todaySchedules->where('is_available', true)->count(),
            'total_seats_today' => $todaySchedules->sum('remaining_seats'),
        ];

        return view('ferries.management.all-schedules', compact('todaySchedules', 'upcomingSchedules', 'allFutureSchedules', 'stats'));
    }

    /**
     * Handle ferry booking requests
     */
    public function book(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to book ferry tickets.');
        }

        $validated = $request->validate([
            'ferry_id' => 'required|exists:ferries,id',
            'schedule_id' => 'required|exists:ferry_schedule,id',
            'passengers' => 'required|integer|min:1|max:10',
            'hotel_booking_id' => 'nullable|exists:bookings,id'
        ]);

        $schedule = FerrySchedule::findOrFail($validated['schedule_id']);
        
        // Check availability
        if (!$schedule->is_available || $schedule->remaining_seats < $validated['passengers']) {
            return back()->with('error', 'Sorry, this schedule is not available or doesn\'t have enough seats.');
        }

        try {
            DB::beginTransaction();

            // Create ferry ticket request
            $ticket = FerryTicketing::create([
                'hotel_booking_id' => $validated['hotel_booking_id'] ?? null,
                'ferry_schedule_id' => $schedule->id,
                'user_id' => auth()->id(),
                'date' => $schedule->date,
                'number_of_guests' => $validated['passengers'],
                'total_price' => $schedule->price * $validated['passengers'],
                'status' => 'pending',
                'ticket_reference' => 'FT-' . strtoupper(Str::random(8))
            ]);

            // Temporarily reserve the seats (will be released if cancelled)
            $schedule->decrement('remaining_seats', $validated['passengers']);

            DB::commit();

            return back()->with('success', 'Your ferry ticket request has been submitted successfully! Reference: ' . $ticket->ticket_reference . '. Please wait for confirmation from the ferry operator.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Sorry, there was an error processing your ticket request. Please try again.');
        }
    }

    /**
     * Display all ferry tickets for management
     */
    public function ticketManagement()
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }

        $tickets = FerryTicketing::with(['user', 'ferrySchedule.ferry', 'ferrySchedule.departureLocation', 'ferrySchedule.arrivalLocation'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('ferries.management.tickets.index', compact('tickets'));
    }

    /**
     * Show a specific ticket
     */
    public function showTicket(FerryTicketing $ticket)
    {
        if (!auth()->user()->canManageFerries() && auth()->id() !== $ticket->user_id) {
            abort(403, 'Unauthorized');
        }

        $ticket->load(['user', 'ferrySchedule.ferry', 'ferrySchedule.departureLocation', 'ferrySchedule.arrivalLocation']);

        if (auth()->user()->canManageFerries()) {
            return view('ferries.management.tickets.show', compact('ticket'));
        }

        return view('ferries.customer.tickets.show', compact('ticket'));
    }

    /**
     * Update ticket status
     */
    public function updateTicketStatus(Request $request, FerryTicketing $ticket)
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'status' => 'required|in:confirmed,cancelled',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            // If cancelling, return the seats
            if ($validated['status'] === 'cancelled' && $ticket->status !== 'cancelled') {
                $ticket->ferrySchedule->increment('remaining_seats', $ticket->number_of_guests);
            }
            // If un-cancelling, remove the seats again
            elseif ($validated['status'] !== 'cancelled' && $ticket->status === 'cancelled') {
                $ticket->ferrySchedule->decrement('remaining_seats', $ticket->number_of_guests);
            }

            $ticket->update([
                'status' => $validated['status'],
                'notes' => $validated['notes']
            ]);

            DB::commit();

            return back()->with('success', 'Ticket status updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating ticket status. Please try again.');
        }
    }

    /**
     * Show user's ferry tickets
     */
    public function myTickets()
    {
        $tickets = FerryTicketing::with(['ferrySchedule.ferry', 'ferrySchedule.departureLocation', 'ferrySchedule.arrivalLocation'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('ferries.customer.tickets.index', compact('tickets'));
    }
}