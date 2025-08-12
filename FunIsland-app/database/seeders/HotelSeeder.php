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
        $hotels = [
            [
                'name' => 'Paradise Beach Resort',
                'description' => 'Luxury beachfront resort with world-class amenities and stunning ocean views. Perfect for romantic getaways and family vacations.',
                'location_id' => 1, // Paradise Beach
                'price_per_night' => 299.00,
                'amenities' => ['Pool', 'Spa', 'Beach Access', 'Restaurant', 'Bar', 'Gym', 'WiFi'],
                'contact_info' => ['phone' => '+1-555-0101', 'email' => 'info@paradisebeach.com'],
                'image_url' => '/images/hotels/paradise-beach-resort.jpg',
                'status' => 'active',
                'featured' => true,
                'rating' => '5'
            ],
            [
                'name' => 'Sunset Cove Hotel',
                'description' => 'Boutique hotel offering intimate accommodations with breathtaking sunset views and personalized service.',
                'location_id' => 2, // Sunset Cove
                'price_per_night' => 199.00,
                'amenities' => ['Pool', 'Restaurant', 'Bar', 'Beach Access', 'WiFi', 'Room Service'],
                'contact_info' => ['phone' => '+1-555-0102', 'email' => 'reservations@sunsetcove.com'],
                'image_url' => '/images/hotels/sunset-cove-hotel.jpg',
                'status' => 'active',
                'featured' => true,
                'rating' => '4'
            ],
            [
                'name' => 'Marina Bay Suites',
                'description' => 'Modern suites overlooking the marina with easy access to water activities and island tours.',
                'location_id' => 3, // Marina Bay
                'price_per_night' => 159.00,
                'amenities' => ['Pool', 'Marina Access', 'Restaurant', 'WiFi', 'Parking', 'Concierge'],
                'contact_info' => ['phone' => '+1-555-0103', 'email' => 'stay@marinabay.com'],
                'image_url' => '/images/hotels/marina-bay-suites.jpg',
                'status' => 'active',
                'featured' => false,
                'rating' => '4'
            ],
            [
                'name' => 'Coral Gardens Inn',
                'description' => 'Charming inn surrounded by beautiful coral gardens, perfect for snorkeling enthusiasts and nature lovers.',
                'location_id' => 4, // Coral Gardens
                'price_per_night' => 129.00,
                'amenities' => ['Garden View', 'Snorkel Gear', 'Restaurant', 'WiFi', 'Nature Tours'],
                'contact_info' => ['phone' => '+1-555-0104', 'email' => 'hello@coralgardens.com'],
                'image_url' => '/images/hotels/coral-gardens-inn.jpg',
                'status' => 'active',
                'featured' => false,
                'rating' => '3'
            ],
            [
                'name' => 'Tropical Village Resort',
                'description' => 'Family-friendly resort in the heart of the island with activities for all ages and authentic local cuisine.',
                'location_id' => 5, // Tropical Village
                'price_per_night' => 179.00,
                'amenities' => ['Kids Club', 'Pool', 'Multiple Restaurants', 'Beach Access', 'WiFi', 'Entertainment'],
                'contact_info' => ['phone' => '+1-555-0105', 'email' => 'info@tropicalvillage.com'],
                'image_url' => '/images/hotels/tropical-village-resort.jpg',
                'status' => 'active',
                'featured' => true,
                'rating' => '4'
            ],
            [
                'name' => 'Adventure Island Lodge',
                'description' => 'Eco-friendly lodge for adventure seekers with easy access to hiking trails and extreme sports.',
                'location_id' => 6, // Adventure Island
                'price_per_night' => 139.00,
                'amenities' => ['Adventure Center', 'Equipment Rental', 'Restaurant', 'WiFi', 'Hiking Trails'],
                'contact_info' => ['phone' => '+1-555-0106', 'email' => 'adventure@islandlodge.com'],
                'image_url' => '/images/hotels/adventure-island-lodge.jpg',
                'status' => 'active',
                'featured' => false,
                'rating' => '4'
            ],
            [
                'name' => 'Ocean Breeze Hotel',
                'description' => 'Comfortable mid-range hotel with excellent service and convenient location near all major attractions.',
                'location_id' => 1, // Paradise Beach
                'price_per_night' => 99.00,
                'amenities' => ['Pool', 'Restaurant', 'WiFi', 'Beach Access', 'Tour Desk'],
                'contact_info' => ['phone' => '+1-555-0107', 'email' => 'stay@oceanbreeze.com'],
                'image_url' => '/images/hotels/ocean-breeze-hotel.jpg',
                'status' => 'active',
                'featured' => false,
                'rating' => '3'
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
