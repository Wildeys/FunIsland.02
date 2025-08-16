<?php

namespace App\Http\Controllers;

use App\Models\ferry;
use Illuminate\Http\Request;

class FerryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ferries = ferry::all();
        
        if (auth()->check() && auth()->user()->hasRole('customer')) {
            return view('ferries.customer.index', compact('ferries'));
        }
        
        return view('ferries.management.index', compact('ferries'));
    }

    /**
     * Public browsing without authentication
     */
        public function browse()
    {
        // Get ferries with active schedules
        $ferries = ferry::whereHas('schedules', function($query) {
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
        $featuredRoutes = ferry::whereHas('schedules', function($query) {
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
        return view('ferries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ferry = ferry::create($request->all());
        return redirect()->route('ferries.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ferry $ferry)
    {
        return view('ferries.show', compact('ferry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ferry $ferry)
    {
        return view('ferries.edit', compact('ferry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ferry $ferry)
    {
        $ferry->update($request->all());
        return redirect()->route('ferries.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ferry $ferry)
    {
        $ferry->delete();
        return redirect()->route('ferries.index');
    }

    /**
     * Ferry management dashboard
     */
    public function dashboard()
    {
        if (!auth()->user()->canManageFerries()) {
            abort(403, 'Unauthorized');
        }

        $totalFerries = ferry::count();
        $totalSchedules = \DB::table('ferry_schedule')->count();
        $activeRoutes = ferry::whereHas('schedules', function($query) {
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
}
