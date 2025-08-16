<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeachController extends Controller
{
    /**
     * Display a listing of beach events and activities.
     */
    public function index()
    {
        // Mock beach events data - you can replace this with actual database queries
        $beachEvents = [
            [
                'id' => 1,
                'name' => 'Sunset Beach Volleyball Tournament',
                'description' => 'Join our exciting beach volleyball tournament with prizes for winners!',
                'location' => 'Paradise Beach',
                'date' => '2024-01-15',
                'time' => '18:00',
                'price' => 25.00,
                'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400'
            ],
            [
                'id' => 2,
                'name' => 'Beach Yoga & Meditation',
                'description' => 'Start your day with peaceful yoga and meditation by the ocean.',
                'location' => 'Serenity Cove',
                'date' => '2024-01-16',
                'time' => '07:00',
                'price' => 15.00,
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400'
            ],
            [
                'id' => 3,
                'name' => 'Bonfire & BBQ Night',
                'description' => 'Enjoy a cozy bonfire with delicious BBQ and live music under the stars.',
                'location' => 'Moonlight Bay',
                'date' => '2024-01-17',
                'time' => '19:30',
                'price' => 35.00,
                'image' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400'
            ],
            [
                'id' => 4,
                'name' => 'Snorkeling Adventure',
                'description' => 'Discover the colorful underwater world with our guided snorkeling tour.',
                'location' => 'Crystal Waters Beach',
                'date' => '2024-01-18',
                'time' => '10:00',
                'price' => 45.00,
                'image' => 'https://images.unsplash.com/photo-1544551763-77ef2d0cfc6c?w=400'
            ]
        ];

        return view('beaches.customer.index', compact('beachEvents'));
    }

    /**
     * Display the specified beach event.
     */
    public function show($id)
    {
        // Mock data - replace with actual database query
        $beachEvent = [
            'id' => $id,
            'name' => 'Sunset Beach Volleyball Tournament',
            'description' => 'Join our exciting beach volleyball tournament with prizes for winners!',
            'location' => 'Paradise Beach',
            'date' => '2024-01-15',
            'time' => '18:00',
            'price' => 25.00,
            'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800'
        ];

        return view('beaches.show', compact('beachEvent'));
    }

    /**
     * Book a beach event.
     */
    public function book(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer',
            'participants' => 'required|integer|min:1|max:10',
        ]);

        // Here you would typically create a booking record
        // For now, just redirect with success message
        
        return redirect()->route('beaches.customer.index')
            ->with('success', 'Beach event booked successfully!');
    }

    /**
     * Browse beach events (public access).
     */
    public function browse()
    {
        // Mock beach events data for public browsing
        $beachEvents = [
            [
                'id' => 1,
                'name' => 'Sunset Beach Volleyball Tournament',
                'description' => 'Join our exciting beach volleyball tournament with prizes for winners!',
                'location' => 'Paradise Beach',
                'date' => '2024-01-15',
                'time' => '18:00',
                'price' => 25.00,
                'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400'
            ],
            [
                'id' => 2,
                'name' => 'Beach Yoga & Meditation',
                'description' => 'Start your day with peaceful yoga and meditation by the ocean.',
                'location' => 'Serenity Cove',
                'date' => '2024-01-16',
                'time' => '07:00',
                'price' => 15.00,
                'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400'
            ]
        ];

        return view('beaches.browse', compact('beachEvents'));
    }
} 