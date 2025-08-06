<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:hotel_manager,administrator')->except(['index', 'show']);
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
    public function show(Hotel $hotel)
    {
        $hotel->load(['location', 'rooms']);
        
        if (auth()->user()->hasRole('customer')) {
            return view('hotels.customer-show', compact('hotel'));
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
