<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'administrator',
                'display_name' => 'Administrator',
                'description' => 'Full system access and control'
            ],
            [
                'name' => 'hotel_manager',
                'display_name' => 'Hotel Manager',
                'description' => 'Manage hotels, rooms, and bookings'
            ],
            [
                'name' => 'hotel_staff',
                'display_name' => 'Hotel Staff',
                'description' => 'View bookings and basic hotel operations'
            ],
            [
                'name' => 'ferry_operator',
                'display_name' => 'Ferry Operator',
                'description' => 'Manage ferry schedules and tickets'
            ],
            [
                'name' => 'theme_park_manager',
                'display_name' => 'Theme Park Manager',
                'description' => 'Manage parks, activities, and bookings'
            ],
            [
                'name' => 'ticketing_staff',
                'display_name' => 'Ticketing Staff',
                'description' => 'Handle ticket sales and bookings'
            ],
            [
                'name' => 'customer',
                'display_name' => 'Customer',
                'description' => 'Book services and view bookings'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
