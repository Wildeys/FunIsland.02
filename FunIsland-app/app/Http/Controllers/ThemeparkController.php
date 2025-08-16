<?php

namespace App\Http\Controllers;

use App\Models\themepark;
use Illuminate\Http\Request;

class ThemeparkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $themeparks = themepark::all();
        
        if (auth()->check() && auth()->user()->hasRole('customer')) {
            return view('themeparks.customer.index', compact('themeparks'));
        }
        
        return view('themeparks.management.index', compact('themeparks'));
    }

    /**
     * Public browsing without authentication
     */
    public function browse()
    {
        $themeparks = themepark::where('status', 'active')
            ->with(['location'])
            ->orderBy('name')
            ->paginate(12);
        
        $featuredParks = themepark::where('status', 'active')
            ->where('featured', true)
            ->limit(3)
            ->get();
        
        return view('themeparks.browse', compact('themeparks', 'featuredParks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->canManageThemeParks()) {
            abort(403, 'Unauthorized');
        }
        
        $locations = \App\Models\Location::all();
        return view('themeparks.management.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $themepark = themepark::create($request->all());
        return redirect()->route('themeparks.management.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(themepark $themepark)
    {
        if (auth()->user()->hasRole('customer')) {
            return view('themeparks.customer.show', compact('themepark'));
        }
        
        return view('themeparks.management.show', compact('themepark'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(themepark $themepark)
    {
        if (!auth()->user()->canManageThemeParks()) {
            abort(403, 'Unauthorized');
        }
        
        $locations = \App\Models\Location::all();
        return view('themeparks.management.edit', compact('themepark', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, themepark $themepark)
    {
        $themepark->update($request->all());
        return redirect()->route('themeparks.management.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(themepark $themepark)
    {
        $themepark->delete();
        return redirect()->route('themeparks.management.index');
    }

    /**
     * Display the theme park management dashboard.
     */
    public function dashboard()
    {
        if (!auth()->user()->canManageThemeParks()) {
            abort(403, 'Unauthorized');
        }

        $totalParks = themepark::count();
        $activeParks = themepark::where('status', 'active')->count();
        $featuredParks = themepark::where('featured', true)->count();
        $totalBookings = 0; // TODO: Add when booking model is ready
        $recentBookings = []; // TODO: Add when booking model is ready
        
        $stats = [
            'total_parks' => $totalParks,
            'active_parks' => $activeParks,
            'featured_parks' => $featuredParks,
            'total_bookings' => $totalBookings,
            'recent_bookings' => $recentBookings,
        ];
        
        return view('themeparks.management.dashboard', compact('stats'));
    }
}
