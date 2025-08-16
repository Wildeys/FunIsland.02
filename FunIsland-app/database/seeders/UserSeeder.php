<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all roles
        $adminRole = Role::where('name', 'administrator')->first();
        $hotelManagerRole = Role::where('name', 'hotel_manager')->first();
        $hotelStaffRole = Role::where('name', 'hotel_staff')->first();
        $ferryOperatorRole = Role::where('name', 'ferry_operator')->first();
        $themeParkManagerRole = Role::where('name', 'theme_park_manager')->first();
        $ticketingStaffRole = Role::where('name', 'ticketing_staff')->first();
        $customerRole = Role::where('name', 'customer')->first();

        $users = [
            // Administrator
            [
                'name' => 'Admin User',
                'email' => 'admin@funisland.com',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
                'email_verified_at' => now(),
            ],
            
            // Hotel Manager
            [
                'name' => 'Hotel Manager',
                'email' => 'hotel.manager@funisland.com',
                'password' => Hash::make('hotel123'),
                'role_id' => $hotelManagerRole->id,
                'email_verified_at' => now(),
            ],
            
            // Hotel Staff
            [
                'name' => 'Hotel Staff',
                'email' => 'hotel.staff@funisland.com',
                'password' => Hash::make('staff123'),
                'role_id' => $hotelStaffRole->id,
                'email_verified_at' => now(),
            ],
            
            // Ferry Operator
            [
                'name' => 'Ferry Captain',
                'email' => 'ferry.operator@funisland.com',
                'password' => Hash::make('ferry123'),
                'role_id' => $ferryOperatorRole->id,
                'email_verified_at' => now(),
            ],
            
            // Theme Park Manager
            [
                'name' => 'Park Manager',
                'email' => 'park.manager@funisland.com',
                'password' => Hash::make('park123'),
                'role_id' => $themeParkManagerRole->id,
                'email_verified_at' => now(),
            ],
            
            // Ticketing Staff
            [
                'name' => 'Ticket Agent',
                'email' => 'tickets@funisland.com',
                'password' => Hash::make('ticket123'),
                'role_id' => $ticketingStaffRole->id,
                'email_verified_at' => now(),
            ],
            
            // Customers
            [
                'name' => 'John Customer',
                'email' => 'john@example.com',
                'password' => Hash::make('customer123'),
                'role_id' => $customerRole->id,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sarah Smith',
                'email' => 'sarah@example.com',
                'password' => Hash::make('customer123'),
                'role_id' => $customerRole->id,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => Hash::make('customer123'),
                'role_id' => $customerRole->id,
                'email_verified_at' => now(),
            ],
            
            // Additional specialized users
            [
                'name' => 'Resort Manager',
                'email' => 'resort.manager@funisland.com',
                'password' => Hash::make('resort123'),
                'role_id' => $hotelManagerRole->id,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Adventure Guide',
                'email' => 'guide@funisland.com',
                'password' => Hash::make('guide123'),
                'role_id' => $themeParkManagerRole->id,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Guest Services',
                'email' => 'guest.services@funisland.com',
                'password' => Hash::make('service123'),
                'role_id' => $ticketingStaffRole->id,
                'email_verified_at' => now(),
            ]
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']], // Search criteria
                $userData // Data to create if not found
            );
        }
    }
}
