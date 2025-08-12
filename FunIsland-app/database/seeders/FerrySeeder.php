<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ferry;
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
        // Create ferries
        $ferries = [
            [
                'name' => 'Island Explorer',
                'location_id' => 1, // Paradise Beach
                'capacity' => 150,
            ],
            [
                'name' => 'Sunset Cruiser',
                'location_id' => 2, // Sunset Cove
                'capacity' => 200,
            ],
            [
                'name' => 'Marina Express',
                'location_id' => 3, // Marina Bay
                'capacity' => 100,
            ],
            [
                'name' => 'Coral Navigator',
                'location_id' => 4, // Coral Gardens
                'capacity' => 120,
            ],
            [
                'name' => 'Adventure Seeker',
                'location_id' => 6, // Adventure Island
                'capacity' => 180,
            ]
        ];

        foreach ($ferries as $ferryData) {
            $ferry = ferry::firstOrCreate(
                ['name' => $ferryData['name'], 'location_id' => $ferryData['location_id']], // Search criteria
                $ferryData // Data to create if not found
            );
            
            // Only create schedules if ferry was just created or has no schedules
            if ($ferry->schedules()->count() == 0) {
                $this->createFerrySchedules($ferry);
            }
        }

        $this->command->info('seeded successfully!');
    }

    private function createFerrySchedules($ferry)
    {
        $locations = Location::all();
        $locationNames = $locations->pluck('location_name', 'id')->toArray();
        
        // Create schedules for the next 30 days
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->addDays($i);
            
            // Create 3-4 trips per day
            $tripCount = rand(3, 4);
            $times = ['08:00', '12:00', '16:00', '20:00'];
            
            for ($j = 0; $j < $tripCount; $j++) {
                // Get different departure and arrival locations
                $departureLocationId = $ferry->location_id;
                $arrivalLocationIds = $locations->where('id', '!=', $departureLocationId)->pluck('id')->toArray();
                $arrivalLocationId = $arrivalLocationIds[array_rand($arrivalLocationIds)];
                
                $basePrice = $this->calculatePrice($departureLocationId, $arrivalLocationId);
                
                DB::table('ferry_schedule')->insert([
                    'ferry_id' => $ferry->id,
                    'date' => $date->format('Y-m-d'),
                    'departure_time' => $times[$j],
                    'departure_location' => $locationNames[$departureLocationId],
                    'arrival_location' => $locationNames[$arrivalLocationId],
                    'price' => $basePrice,
                    'remaining_seats' => rand(50, $ferry->capacity),
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