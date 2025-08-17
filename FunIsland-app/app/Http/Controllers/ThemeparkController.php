<?php

namespace App\Http\Controllers;

use App\Models\themepark;
use Illuminate\Http\Request;

class ThemeparkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = themepark::with(['location']);
        
        if (auth()->check() && auth()->user()->hasRole('customer')) {
            $query->where('status', 'active');
            $themeparks = $query->paginate(12);
            return view('themeparks.customer.index', compact('themeparks'));
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
        
        $themeparks = $query->orderBy('created_at', 'desc')->paginate(12);
        
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
        if (!auth()->user()->canManageThemeParks()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'location_id' => 'required|exists:locations,id',
            'admission_price' => 'required|numeric|min:0|max:999.99',
            'capacity' => 'required|integer|min:1|max:50000',
            'rating' => 'nullable|numeric|between:0,5',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
            'image_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive,maintenance',
            'features' => 'nullable|string|max:1000',
            'featured' => 'boolean'
        ]);

        $themepark = themepark::create($validated);

        return redirect()->route('management.themeparks.index')
            ->with('success', 'Theme park created successfully!');
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
        if (!auth()->user()->canManageThemeParks()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'location_id' => 'required|exists:locations,id',
            'admission_price' => 'required|numeric|min:0|max:999.99',
            'capacity' => 'required|integer|min:1|max:50000',
            'rating' => 'nullable|numeric|between:0,5',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
            'image_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive,maintenance',
            'features' => 'nullable|string|max:1000',
            'featured' => 'boolean'
        ]);

        $themepark->update($validated);

        return redirect()->route('management.themeparks.index')
            ->with('success', 'Theme park updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(themepark $themepark)
    {
        if (!auth()->user()->canManageThemeParks()) {
            abort(403, 'Unauthorized');
        }

        $themepark->delete();

        return redirect()->route('management.themeparks.index')
            ->with('success', 'Theme park deleted successfully!');
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
