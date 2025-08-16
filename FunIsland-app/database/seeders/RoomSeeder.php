<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\hotel;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = hotel::all();

        foreach ($hotels as $hotel) {
            // Create 5-8 rooms per hotel
            $roomCount = rand(5, 8);
            
            for ($i = 1; $i <= $roomCount; $i++) {
                $roomTypes = ['standard', 'deluxe', 'suite', 'presidential'];
                $roomType = $roomTypes[array_rand($roomTypes)];
                
                // Set price based on room type
                $basePrices = [
                    'standard' => rand(80, 120),
                    'deluxe' => rand(150, 200),
                    'suite' => rand(250, 350),
                    'presidential' => rand(500, 800)
                ];

                Room::create([
                    'hotel_id' => $hotel->id,
                    'room_number' => str_pad($i, 3, '0', STR_PAD_LEFT),
                    'room_type' => $roomType,
                    'description' => $this->getRoomDescription($roomType),
                    'price_per_night' => $basePrices[$roomType],
                    'capacity' => $this->getRoomCapacity($roomType),
                    'amenities' => $this->getRoomAmenities($roomType),
                    'status' => rand(1, 10) > 8 ? 'maintenance' : 'available', // 20% chance of maintenance
                    'maintenance_notes' => rand(1, 10) > 8 ? 'Routine maintenance scheduled' : null,
                ]);
            }
        }
    }

    private function getRoomDescription($type): string
    {
        $descriptions = [
            'standard' => 'Comfortable room with modern amenities and beautiful island views. Perfect for couples or solo travelers.',
            'deluxe' => 'Spacious deluxe room featuring premium furnishings, private balcony, and enhanced ocean views.',
            'suite' => 'Luxurious suite with separate living area, premium amenities, and panoramic ocean views.',
            'presidential' => 'Ultra-luxurious presidential suite with exclusive amenities, private terrace, and premium services.'
        ];

        return $descriptions[$type];
    }

    private function getRoomCapacity($type): int
    {
        $capacities = [
            'standard' => 2,
            'deluxe' => 3,
            'suite' => 4,
            'presidential' => 6
        ];

        return $capacities[$type];
    }

    private function getRoomAmenities($type): array
    {
        $baseAmenities = ['Air Conditioning', 'Free WiFi', 'Flat-screen TV', 'Private Bathroom'];
        
        $typeAmenities = [
            'standard' => ['Mini Fridge', 'Coffee Maker'],
            'deluxe' => ['Mini Fridge', 'Coffee Maker', 'Balcony', 'Room Service'],
            'suite' => ['Mini Bar', 'Coffee Machine', 'Living Room', 'Balcony', 'Room Service', 'Bathrobe'],
            'presidential' => ['Mini Bar', 'Coffee Machine', 'Living Room', 'Private Terrace', 'Butler Service', 'Jacuzzi', 'Premium Toiletries']
        ];

        return array_merge($baseAmenities, $typeAmenities[$type]);
    }
}
