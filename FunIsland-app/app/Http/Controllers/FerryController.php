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
        $ferries = ferry::where('status', 'active')
            ->with(['departureLocation', 'arrivalLocation'])
            ->orderBy('departure_time')
            ->paginate(12);
        
        $featuredRoutes = ferry::where('status', 'active')
            ->where('featured', true)
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
}
