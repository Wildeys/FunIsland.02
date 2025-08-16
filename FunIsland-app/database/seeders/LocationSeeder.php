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
        // Maafushi Island and surrounding locations
        $locations = [
            [
                'location_name' => 'Maafushi Island',
                'latitude' => 3.94028,
                'longitude' => 73.48889
            ],
            [
                'location_name' => 'Bikini Beach',
                'latitude' => 3.94100,
                'longitude' => 73.48900
            ],
            [
                'location_name' => 'Water Sports Center',
                'latitude' => 3.93950,
                'longitude' => 73.48850
            ],
            [
                'location_name' => 'Maafushi Harbor',
                'latitude' => 3.93980,
                'longitude' => 73.48870
            ],
            [
                'location_name' => 'Coral Reef Point',
                'latitude' => 3.94150,
                'longitude' => 73.48950
            ],
            [
                'location_name' => 'Adventure Bay',
                'latitude' => 3.93900,
                'longitude' => 73.48800
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
