<?php

namespace Database\Seeders;

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

        $themeparks = [
            [
                'name' => 'Paradise Adventure Park',
                'description' => 'Experience thrilling rides and attractions in a tropical paradise setting. From heart-pounding roller coasters to family-friendly water rides, Paradise Adventure Park offers excitement for all ages.',
                'rating' => 4.8,
                'status' => 'active',
                'featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1509048191080-d2dc8c95a88e?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Tropical Fun Zone',
                'description' => 'A family-friendly theme park featuring exciting games, gentle rides, and educational exhibits about tropical wildlife. Perfect for younger children and families.',
                'rating' => 4.5,
                'status' => 'active',
                'featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1522057384400-681b421cfebc?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Island Water World',
                'description' => 'Cool off in our massive water park with slides, lazy rivers, wave pools, and splash zones. The perfect way to beat the tropical heat while having endless fun.',
                'rating' => 4.6,
                'status' => 'active',
                'featured' => false,
                'image_url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Adventure Cove',
                'description' => 'Embark on an adventure through themed areas including pirate coves, jungle expeditions, and treasure hunts. Interactive experiences that bring stories to life.',
                'rating' => 4.4,
                'status' => 'active',
                'featured' => false,
                'image_url' => 'https://images.unsplash.com/photo-1570197788417-0e82375c9371?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Sunset Thrills Park',
                'description' => 'Open until late evening, experience the magic of theme park rides under the setting sun and twinkling lights. Features the islands tallest roller coaster.',
                'rating' => 4.7,
                'status' => 'active',
                'featured' => true,
                'image_url' => 'https://images.unsplash.com/photo-1596496050755-c923e73e42e1?w=800&h=600&fit=crop',
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
