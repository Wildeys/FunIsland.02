<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\hotel;
use App\Models\Location;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Real Maafushi Island Hotels
        $hotels = [
            [
                'name' => 'Kaani Beach Hotel',
                'description' => 'A 3-star beachfront hotel with balconies, sea views, and activities like snorkeling and dolphin cruises.',
                'location_id' => 1, // Maafushi Island
                'price_per_night' => 85.00,
                'amenities' => ['Beach Access', 'Snorkeling', 'Dolphin Cruises', 'Sea View', 'Balcony', 'WiFi', 'Restaurant'],
                'contact_info' => ['phone' => '+960-664-5566', 'email' => 'info@kaanibeach.com'],
                'image_url' => '/images/hotels/kaani-beach-hotel.jpg',
                'status' => 'active',
                'featured' => true,
                'rating' => '3'
            ],
            [
                'name' => 'Arena Beach Hotel',
                'description' => 'Stylish hotel with modern rooms, rooftop pool, and stunning ocean views near Bikini Beach.',
                'location_id' => 2, // Bikini Beach
                'price_per_night' => 85.00,
                'amenities' => ['Rooftop Pool', 'Ocean Views', 'Modern Rooms', 'Beach Access', 'WiFi', 'Restaurant', 'Bar'],
                'contact_info' => ['phone' => '+960-664-7788', 'email' => 'reservations@arenabeach.mv'],
                'image_url' => '/images/hotels/arena-beach-hotel.jpg',
                'status' => 'active',
                'featured' => true,
                'rating' => '4'
            ],
            [
                'name' => 'Crystal Sands',
                'description' => 'Modern hotel with turquoise-themed rooms and a restaurant by Symphony Group, close to Bikini Beach.',
                'location_id' => 1, // Maafushi Island
                'price_per_night' => 80.00,
                'amenities' => ['Modern Rooms', 'Restaurant', 'Beach Access', 'WiFi', 'Turquoise Decor', 'Air Conditioning'],
                'contact_info' => ['phone' => '+960-664-9900', 'email' => 'stay@crystalsands.mv'],
                'image_url' => '/images/hotels/crystal-sands.jpg',
                'status' => 'active',
                'featured' => false,
                'rating' => '4'
            ],
            [
                'name' => 'Sunrise Beach',
                'description' => 'Budget-friendly inn with free Wi-Fi, bicycles, and a 24-hour front desk, 200m from Bikini Beach.',
                'location_id' => 2, // Bikini Beach
                'price_per_night' => 70.00,
                'amenities' => ['Free WiFi', 'Bicycle Rental', '24h Front Desk', 'Beach Access', 'Air Conditioning', 'Room Service'],
                'contact_info' => ['phone' => '+960-664-3344', 'email' => 'info@sunrisebeach.mv'],
                'image_url' => '/images/hotels/sunrise-beach.jpg',
                'status' => 'active',
                'featured' => false,
                'rating' => '3'
            ],
            [
                'name' => 'Maafushi Inn',
                'description' => 'Traditional Maldivian guesthouse offering authentic local experience with modern comfort and excellent diving access.',
                'location_id' => 4, // Maafushi Harbor
                'price_per_night' => 75.00,
                'amenities' => ['Diving Center', 'Local Cuisine', 'Harbor View', 'WiFi', 'Fishing Trips', 'Cultural Tours'],
                'contact_info' => ['phone' => '+960-664-1122', 'email' => 'stay@maafushiinn.mv'],
                'image_url' => '/images/hotels/maafushi-inn.jpg',
                'status' => 'active',
                'featured' => true,
                'rating' => '4'
            ],
            [
                'name' => 'Coral Reef Resort',
                'description' => 'Premium resort near coral reefs offering exceptional snorkeling and diving experiences with marine life.',
                'location_id' => 5, // Coral Reef Point
                'price_per_night' => 95.00,
                'amenities' => ['Diving Center', 'Snorkel Gear', 'Marine Tours', 'Restaurant', 'WiFi', 'Beach Access'],
                'contact_info' => ['phone' => '+960-664-5577', 'email' => 'info@coralreefresort.mv'],
                'image_url' => '/images/hotels/coral-reef-resort.jpg',
                'status' => 'active',
                'featured' => true,
                'rating' => '4'
            ],
            [
                'name' => 'Adventure Bay Lodge',
                'description' => 'Eco-friendly lodge perfect for water sports enthusiasts with direct access to adventure activities.',
                'location_id' => 6, // Adventure Bay
                'price_per_night' => 90.00,
                'amenities' => ['Water Sports', 'Kayak Rental', 'Fishing Trips', 'Restaurant', 'WiFi', 'Eco Tours'],
                'contact_info' => ['phone' => '+960-664-6688', 'email' => 'stay@adventurebay.mv'],
                'image_url' => '/images/hotels/adventure-bay-lodge.jpg',
                'status' => 'active',
                'featured' => false,
                'rating' => '4'
            ]
        ];

        foreach ($hotels as $hotel) {
            hotel::firstOrCreate(
                ['name' => $hotel['name'], 'location_id' => $hotel['location_id']], // Search criteria
                $hotel // Data to create if not found
            );
        }
    }
}
