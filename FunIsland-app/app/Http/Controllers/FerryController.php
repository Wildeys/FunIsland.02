<?php

namespace App\Http\Controllers;

use App\Models\Ferry;
use App\Models\Location;
use App\Models\FerrySchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                  ->orWhere('departure_location', 'like', "%{$search}%")
                  ->orWhere('arrival_location', 'like', "%{$search}%")
                  ->orWhereHas('location', function($locationQuery) use ($search) {
                      $locationQuery->where('location_name', 'like', "%{$search}%");
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
            'departure_location' => 'required|string|max:255',
            'arrival_location' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,maintenance',
            'description' => 'nullable|string|max:2000',
            'price_per_trip' => 'nullable|numeric|min:0|max:9999.99',
            'image_url' => 'nullable|url|max:255',
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
            $query->where('date', '>=', now()->format('Y-m-d'))
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
            'departure_location' => 'required|string|max:255',
            'arrival_location' => 'required|string|max:255',
            'status' => 'required|in:active,inactive,maintenance',
            'description' => 'nullable|string|max:2000',
            'price_per_trip' => 'nullable|numeric|min:0|max:9999.99',
            'image_url' => 'nullable|url|max:255',
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
        $totalBookings = 0; // TODO: Add when booking model is ready
        $recentBookings = []; // TODO: Add when booking model is ready
        
        $stats = [
            'total_ferries' => $totalFerries,
            'total_schedules' => $totalSchedules,
            'active_routes' => $activeRoutes,
            'total_bookings' => $totalBookings,
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
            $query->orderBy('date')->orderBy('departure_time');
        }]);
        
        return view('ferries.management.schedules', compact('ferry'));
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
            'remaining_seats' => 'required|integer|min:0|max:' . $ferry->capacity,
            'price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
        ]);

        FerrySchedule::create([
            'ferry_id' => $ferry->id,
            'date' => $validated['date'],
            'departure_time' => $validated['departure_time'],
            'departure_location' => $ferry->departure_location,
            'arrival_location' => $ferry->arrival_location,
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
}