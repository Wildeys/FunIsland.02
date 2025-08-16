<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\themepark;
use App\Models\Location;

class ThemeparkSeeder extends Seeder
{
    public function run(): void
    {
        $locations = Location::all();

        if ($locations->isEmpty()) {
            $this->command->info('No locations found. Please run LocationSeeder first.');
            return;
        }

        // Maafushi-themed attractions and adventure parks
        $themeparks = [
            [
                'name' => 'Maafushi Adventure Park',
                'description' => 'A small adventure park with water-based attractions and family-friendly activities. Experience the best of Maldivian marine adventures.',
                'rating' => 4.2,
                'status' => 'active',
                'featured' => true,
                'image_url' => '/images/themeparks/maafushi-adventure-park.jpg',
            ],
            [
                'name' => 'Bikini Beach Activities Center',
                'description' => 'Beach-based adventure center offering water sports, volleyball courts, and beach games. Perfect for families and groups.',
                'rating' => 4.0,
                'status' => 'active',
                'featured' => true,
                'image_url' => '/images/themeparks/bikini-beach-activities.jpg',
            ],
            [
                'name' => 'Coral Discovery Center',
                'description' => 'Educational marine park featuring coral displays, snorkeling experiences, and underwater observation areas. Learn about Maldivian marine life.',
                'rating' => 4.5,
                'status' => 'active',
                'featured' => false,
                'image_url' => '/images/themeparks/coral-discovery-center.jpg',
            ],
            [
                'name' => 'Water Sports Adventure Zone',
                'description' => 'Action-packed water sports center with jet skiing, parasailing, windsurfing, and diving experiences. Adrenaline-filled Maldivian adventures.',
                'rating' => 4.3,
                'status' => 'active',
                'featured' => false,
                'image_url' => '/images/themeparks/water-sports-adventure.jpg',
            ],
            [
                'name' => 'Maldivian Heritage Park',
                'description' => 'Cultural theme park showcasing traditional Maldivian life, local crafts, music, and dance performances. Experience authentic island culture.',
                'rating' => 4.1,
                'status' => 'active',
                'featured' => true,
                'image_url' => '/images/themeparks/maldivian-heritage-park.jpg',
            ],
        ];

        foreach ($themeparks as $parkData) {
            themepark::create([
                'location_id' => $locations->random()->id,
                'name' => $parkData['name'],
                'description' => $parkData['description'],
                'rating' => $parkData['rating'],
                'status' => $parkData['status'],
                'featured' => $parkData['featured'],
                'image_url' => $parkData['image_url'],
            ]);
        }

        $this->command->info('Theme parks seeded successfully!');
    }
}
