<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            // Beach Events
            [
                'name' => 'Sunset Beach Yoga',
                'description' => 'Join us for a relaxing yoga session on the beach as the sun sets over the horizon. Perfect for all skill levels.',
                'type' => 'beach_event',
                'location' => 'Golden Sands Beach',
                'price' => 25.00,
                'capacity' => 30,
                'available_spots' => 30,
                'start_time' => Carbon::now()->addDays(1)->setTime(18, 0),
                'end_time' => Carbon::now()->addDays(1)->setTime(19, 30),
                'duration' => '1.5 hours',
                'requirements' => 'Bring your own mat. All levels welcome.',
                'features' => ['Yoga mat rental available', 'Professional instructor', 'Sunset views'],
                'difficulty_level' => 'Easy',
                'status' => 'active',
                'image_url' => '/images/events/beach-yoga.jpg'
            ],
            [
                'name' => 'Beach Volleyball Tournament',
                'description' => 'Compete in our weekly beach volleyball tournament! Teams of 4 players. Prizes for winners!',
                'type' => 'beach_event',
                'location' => 'Sports Beach',
                'price' => 15.00,
                'capacity' => 32,
                'available_spots' => 28,
                'start_time' => Carbon::now()->addDays(2)->setTime(15, 0),
                'end_time' => Carbon::now()->addDays(2)->setTime(18, 0),
                'duration' => '3 hours',
                'requirements' => 'Form teams of 4. All skill levels welcome.',
                'features' => ['Equipment provided', 'Professional referee', 'Prizes for winners', 'Refreshments'],
                'difficulty_level' => 'Moderate',
                'status' => 'active',
                'image_url' => '/images/events/beach-volleyball.jpg'
            ],
            [
                'name' => 'Moonlight Beach Party',
                'description' => 'Dance the night away under the stars! Live DJ, cocktails, and beach games.',
                'type' => 'entertainment',
                'location' => 'Paradise Cove',
                'price' => 35.00,
                'capacity' => 100,
                'available_spots' => 85,
                'start_time' => Carbon::now()->addDays(3)->setTime(20, 0),
                'end_time' => Carbon::now()->addDays(4)->setTime(1, 0),
                'duration' => '5 hours',
                'requirements' => 'Ages 18+. Valid ID required.',
                'features' => ['Live DJ', 'Open bar', 'Beach games', 'Fire shows', 'Late night snacks'],
                'difficulty_level' => null,
                'status' => 'active',
                'image_url' => '/images/events/beach-party.jpg'
            ],

            // Water Activities
            [
                'name' => 'Snorkeling Adventure',
                'description' => 'Explore the colorful underwater world of FunIsland. Equipment and guide included.',
                'type' => 'activity',
                'location' => 'Coral Bay',
                'price' => 45.00,
                'capacity' => 20,
                'available_spots' => 18,
                'start_time' => Carbon::now()->addDays(1)->setTime(9, 0),
                'end_time' => Carbon::now()->addDays(1)->setTime(12, 0),
                'duration' => '3 hours',
                'requirements' => 'Basic swimming skills required. Ages 8+.',
                'features' => ['Professional guide', 'All equipment included', 'Underwater photos', 'Marine life briefing'],
                'difficulty_level' => 'Easy',
                'status' => 'active',
                'image_url' => '/images/events/snorkeling.jpg'
            ],
            [
                'name' => 'Jet Ski Island Tour',
                'description' => 'Speed around the island on our guided jet ski tour. See hidden coves and beaches!',
                'type' => 'activity',
                'location' => 'Marina Bay',
                'price' => 85.00,
                'capacity' => 12,
                'available_spots' => 8,
                'start_time' => Carbon::now()->addDays(2)->setTime(10, 0),
                'end_time' => Carbon::now()->addDays(2)->setTime(12, 30),
                'duration' => '2.5 hours',
                'requirements' => 'Valid driver\'s license required. Ages 16+.',
                'features' => ['Professional guide', 'Safety equipment', 'Scenic routes', 'Photo stops'],
                'difficulty_level' => 'Moderate',
                'status' => 'active',
                'image_url' => '/images/events/jetski-tour.jpg'
            ],
            [
                'name' => 'Deep Sea Fishing',
                'description' => 'Join our experienced crew for a deep sea fishing adventure. All equipment provided.',
                'type' => 'activity',
                'location' => 'Deep Sea Dock',
                'price' => 120.00,
                'capacity' => 15,
                'available_spots' => 12,
                'start_time' => Carbon::now()->addDays(4)->setTime(6, 0),
                'end_time' => Carbon::now()->addDays(4)->setTime(14, 0),
                'duration' => '8 hours',
                'requirements' => 'No experience necessary. Seasickness medication recommended.',
                'features' => ['Experienced crew', 'All equipment', 'Lunch included', 'Fish cleaning service'],
                'difficulty_level' => 'Easy',
                'status' => 'active',
                'image_url' => '/images/events/deep-sea-fishing.jpg'
            ],

            // Adventure Activities
            [
                'name' => 'Island Hiking Adventure',
                'description' => 'Hike through tropical rainforest to hidden waterfalls. Moderate fitness level required.',
                'type' => 'activity',
                'location' => 'Rainforest Trail',
                'price' => 55.00,
                'capacity' => 25,
                'available_spots' => 20,
                'start_time' => Carbon::now()->addDays(3)->setTime(8, 0),
                'end_time' => Carbon::now()->addDays(3)->setTime(15, 0),
                'duration' => '7 hours',
                'requirements' => 'Good physical condition. Hiking boots recommended.',
                'features' => ['Expert guide', 'Lunch included', 'Water provided', 'Wildlife spotting'],
                'difficulty_level' => 'Challenging',
                'status' => 'active',
                'image_url' => '/images/events/hiking.jpg'
            ],
            [
                'name' => 'Kayaking Mangrove Tour',
                'description' => 'Paddle through peaceful mangrove channels and spot local wildlife.',
                'type' => 'activity',
                'location' => 'Mangrove Channels',
                'price' => 40.00,
                'capacity' => 16,
                'available_spots' => 14,
                'start_time' => Carbon::now()->addDays(5)->setTime(14, 0),
                'end_time' => Carbon::now()->addDays(5)->setTime(17, 0),
                'duration' => '3 hours',
                'requirements' => 'Basic swimming skills. Ages 10+.',
                'features' => ['Kayak included', 'Professional guide', 'Wildlife viewing', 'Photo opportunities'],
                'difficulty_level' => 'Easy',
                'status' => 'active',
                'image_url' => '/images/events/kayaking.jpg'
            ],

            // Entertainment Events
            [
                'name' => 'Cultural Fire Show',
                'description' => 'Experience traditional island culture with an authentic fire dancing performance.',
                'type' => 'entertainment',
                'location' => 'Cultural Center',
                'price' => 30.00,
                'capacity' => 80,
                'available_spots' => 75,
                'start_time' => Carbon::now()->addDays(6)->setTime(19, 0),
                'end_time' => Carbon::now()->addDays(6)->setTime(21, 0),
                'duration' => '2 hours',
                'requirements' => 'All ages welcome. Traditional dinner available.',
                'features' => ['Fire dancing', 'Traditional music', 'Cultural stories', 'Traditional dinner option'],
                'difficulty_level' => null,
                'status' => 'active',
                'image_url' => '/images/events/fire-show.jpg'
            ],
            [
                'name' => 'Island Music Festival',
                'description' => 'A day of tropical music featuring local bands and international artists.',
                'type' => 'entertainment',
                'location' => 'Festival Grounds',
                'price' => 65.00,
                'capacity' => 500,
                'available_spots' => 450,
                'start_time' => Carbon::now()->addDays(7)->setTime(12, 0),
                'end_time' => Carbon::now()->addDays(7)->setTime(23, 0),
                'duration' => '11 hours',
                'requirements' => 'All ages. Under 16 must be accompanied by adult.',
                'features' => ['Multiple stages', 'Food vendors', 'Local artists', 'International acts'],
                'difficulty_level' => null,
                'status' => 'active',
                'image_url' => '/images/events/music-festival.jpg'
            ]
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}
