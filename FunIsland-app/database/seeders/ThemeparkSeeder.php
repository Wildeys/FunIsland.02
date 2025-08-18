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
                'admission_price' => 45.00,
                'capacity' => 200,
                'rating' => 4.2,
                'opening_time' => '08:00',
                'closing_time' => '18:00',
                'status' => 'active',
                'featured' => true,
                'features' => 'Water slides, Snorkeling pool, Beach volleyball, Kids play area',
                'image_url' => '/images/themeparks/maafushi-adventure-park.jpg',
            ],
            [
                'name' => 'Bikini Beach Activities Center',
                'description' => 'Beach-based adventure center offering water sports, volleyball courts, and beach games. Perfect for families and groups.',
                'admission_price' => 35.00,
                'capacity' => 150,
                'rating' => 4.0,
                'opening_time' => '09:00',
                'closing_time' => '17:00',
                'status' => 'active',
                'featured' => true,
                'features' => 'Beach volleyball, Water sports equipment, Changing rooms, Showers',
                'image_url' => '/images/themeparks/bikini-beach-activities.jpg',
            ],
            [
                'name' => 'Coral Discovery Center',
                'description' => 'Educational marine park featuring coral displays, snorkeling experiences, and underwater observation areas. Learn about Maldivian marine life.',
                'admission_price' => 55.00,
                'capacity' => 100,
                'rating' => 4.5,
                'opening_time' => '08:30',
                'closing_time' => '17:30',
                'status' => 'active',
                'featured' => false,
                'features' => 'Coral tanks, Underwater viewing, Guided tours, Educational programs',
                'image_url' => '/images/themeparks/coral-discovery-center.jpg',
            ],
            [
                'name' => 'Water Sports Adventure Zone',
                'description' => 'Action-packed water sports center with jet skiing, parasailing, windsurfing, and diving experiences. Adrenaline-filled Maldivian adventures.',
                'admission_price' => 75.00,
                'capacity' => 80,
                'rating' => 4.3,
                'opening_time' => '07:00',
                'closing_time' => '19:00',
                'status' => 'active',
                'featured' => false,
                'features' => 'Jet skis, Parasailing, Windsurfing, Diving equipment, Safety gear',
                'image_url' => '/images/themeparks/water-sports-adventure.jpg',
            ],
            [
                'name' => 'Maldivian Heritage Park',
                'description' => 'Cultural theme park showcasing traditional Maldivian life, local crafts, music, and dance performances. Experience authentic island culture.',
                'admission_price' => 25.00,
                'capacity' => 300,
                'rating' => 4.1,
                'opening_time' => '10:00',
                'closing_time' => '16:00',
                'status' => 'active',
                'featured' => true,
                'features' => 'Cultural shows, Traditional crafts, Local music, Dance performances',
                'image_url' => '/images/themeparks/maldivian-heritage-park.jpg',
            ],
        ];

        foreach ($themeparks as $parkData) {
            themepark::create([
                'location_id' => $locations->random()->id,
                'name' => $parkData['name'],
                'description' => $parkData['description'],
                'admission_price' => $parkData['admission_price'],
                'capacity' => $parkData['capacity'],
                'rating' => $parkData['rating'],
                'opening_time' => $parkData['opening_time'],
                'closing_time' => $parkData['closing_time'],
                'status' => $parkData['status'],
                'featured' => $parkData['featured'],
                'features' => $parkData['features'],
                'image_url' => $parkData['image_url'],
            ]);
        }

        $this->command->info('Theme parks seeded successfully!');
    }
}
