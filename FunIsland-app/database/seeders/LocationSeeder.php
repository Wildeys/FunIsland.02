<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'location_name' => 'Paradise Beach',
                'latitude' => 25.7617,
                'longitude' => -80.1918
            ],
            [
                'location_name' => 'Sunset Cove',
                'latitude' => 25.7748,
                'longitude' => -80.1977
            ],
            [
                'location_name' => 'Marina Bay',
                'latitude' => 25.7589,
                'longitude' => -80.1889
            ],
            [
                'location_name' => 'Coral Gardens',
                'latitude' => 25.7701,
                'longitude' => -80.1950
            ],
            [
                'location_name' => 'Tropical Village',
                'latitude' => 25.7655,
                'longitude' => -80.1925
            ],
            [
                'location_name' => 'Adventure Island',
                'latitude' => 25.7800,
                'longitude' => -80.2000
            ]
        ];

        foreach ($locations as $location) {
            Location::firstOrCreate(
                ['location_name' => $location['location_name']], // Search criteria
                $location // Data to create if not found
            );
        }
    }
}
