<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ferry;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FerrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Real Maafushi Island Ferries
        $ferries = [
            [
                'name' => 'Maafushi Public Ferry',
                'location_id' => 4, // Maafushi Harbor
                'capacity' => 50,
            ],
            [
                'name' => 'iCom Tours Speedboat',
                'location_id' => 3, // Water Sports Center
                'capacity' => 30,
            ],
            [
                'name' => 'MaafushiTours Speedboat',
                'location_id' => 3, // Water Sports Center
                'capacity' => 25,
            ],
            [
                'name' => 'Maafushi Express',
                'location_id' => 4, // Maafushi Harbor
                'capacity' => 40,
            ],
            [
                'name' => 'Adventure Island Ferry',
                'location_id' => 6, // Adventure Bay
                'capacity' => 35,
            ],
            [
                'name' => 'Coral Reef Explorer',
                'location_id' => 5, // Coral Reef Point
                'capacity' => 28,
            ]
        ];

        foreach ($ferries as $ferryData) {
            $ferry = Ferry::firstOrCreate(
                ['name' => $ferryData['name'], 'location_id' => $ferryData['location_id']],
                $ferryData
            );

            // Only create schedules if ferry was just created or has no schedules
            if ($ferry->schedules()->count() == 0) {
                $this->createFerrySchedules($ferry);
            }
        }

        $this->command->info('Ferry schedules seeded successfully!');
    }

    private function createFerrySchedules(Ferry $ferry)
    {
        $locations = Location::all();
        if ($locations->isEmpty()) {
            $this->command->error('No locations found. Please seed the locations table first.');
            return;
        }

        $locationNames = $locations->pluck('location_name', 'id')->toArray();

        // Create schedules for the next 30 days
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->addDays($i);

            // Create 3-4 trips per day
            $tripCount = rand(3, 4);
            $times = ['08:00:00', '12:00:00', '16:00:00', '20:00:00'];

            for ($j = 0; $j < $tripCount; $j++) {
                // Get different departure and arrival locations
                $departureLocationId = $ferry->location_id;
                $arrivalLocationIds = $locations->where('id', '!=', $departureLocationId)->pluck('id')->toArray();
                
                if (empty($arrivalLocationIds)) {
                    $this->command->warn("No valid arrival locations for ferry {$ferry->name}. Skipping schedule.");
                    continue;
                }

                $arrivalLocationId = $arrivalLocationIds[array_rand($arrivalLocationIds)];

                $basePrice = $this->calculatePrice($departureLocationId, $arrivalLocationId);

                DB::table('ferry_schedule')->insert([
                    'ferry_id' => $ferry->id,
                    'date' => $date->format('Y-m-d'),
                    'departure_time' => $times[$j],
                    'departure_location' => $locationNames[$departureLocationId],
                    'arrival_location' => $locationNames[$arrivalLocationId],
                    'departure_location_id' => $departureLocationId,
                    'arrival_location_id' => $arrivalLocationId,
                    'price' => $basePrice,
                    'remaining_seats' => rand(10, $ferry->capacity), // Adjusted to avoid negative/excessive seats
                    'is_available' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function calculatePrice($departureId, $arrivalId)
    {
        // Base prices for different route types
        $basePrices = [
            'short' => rand(25, 45),    // Same area routes
            'medium' => rand(50, 75),   // Cross-island routes
            'long' => rand(80, 120),    // Adventure island routes
        ];

        // Determine route distance/type based on location IDs
        if (abs($departureId - $arrivalId) == 1) {
            return $basePrices['short'];
        } elseif (in_array($departureId, [6]) || in_array($arrivalId, [6])) { // Adventure Island
            return $basePrices['long'];
        } else {
            return $basePrices['medium'];
        }
    }
}