<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    /**
     * Display the interactive map view
     */
    public function map()
    {
        // Get all locations with their related services
        $locations = Location::with(['hotels', 'ferries', 'themeparks'])->get();
        
        // Determine layout based on user authentication and role
        $layout = 'guest';
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->hasRole('administrator') || $user->hasRole('hotel_manager') || 
                $user->hasRole('ferry_operator') || $user->hasRole('theme_park_manager')) {
                $layout = 'management';
            } else {
                $layout = 'app';
            }
        }
        
        return view('locations.map', compact('locations', 'layout'));
    }

    /**
     * Get location data for AJAX requests
     */
    public function getLocationData(Request $request): JsonResponse
    {
        $locations = Location::with(['hotels', 'ferries', 'themeparks'])->get();
        
        $locationData = $locations->map(function ($location) {
            return [
                'id' => $location->id,
                'name' => $location->location_name,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'hotels' => $location->hotels->map(function ($hotel) {
                    return [
                        'id' => $hotel->id,
                        'name' => $hotel->name,
                        'description' => $hotel->description ?? '',
                        'price_per_night' => $hotel->price_per_night ?? 0,
                        'status' => $hotel->status ?? 'active',
                    ];
                }),
                'ferries' => $location->ferries->map(function ($ferry) {
                    return [
                        'id' => $ferry->id,
                        'name' => $ferry->name,
                        'capacity' => $ferry->capacity,
                    ];
                }),
                'themeparks' => $location->themeparks->map(function ($themepark) {
                    return [
                        'id' => $themepark->id,
                        'name' => $themepark->name,
                        'description' => $themepark->description ?? '',
                        'status' => $themepark->status ?? 'active',
                    ];
                })
            ];
        });

        return response()->json($locationData);
    }

    /**
     * Get detailed information for a specific location
     */
    public function getLocationDetails($id): JsonResponse
    {
        $location = Location::with(['hotels', 'ferries', 'themeparks'])->findOrFail($id);
        
        return response()->json([
            'id' => $location->id,
            'name' => $location->location_name,
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'services' => [
                'hotels' => $location->hotels->count(),
                'ferries' => $location->ferries->count(),
                'themeparks' => $location->themeparks->count(),
            ],
            'hotels' => $location->hotels,
            'ferries' => $location->ferries,
            'themeparks' => $location->themeparks,
        ]);
    }
}
