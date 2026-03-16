<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stays = [
            [
                'name' => 'Elite Luxury Living',
                'type' => 'PG',
                'rent' => 25000,
                'broker_number' => '9876543210',
                'broker_name' => 'John Doe',
                'rules' => ['No smoking', 'Gate closes at 11 PM'],
                'amenities' => ['AC', 'WiFi', 'Gym', 'Laundry'],
                'distance' => 1.5,
                'is_luxury' => true,
                'luxury_order' => 1,
                'area' => 'Baner',
                'gender' => 'Co-living'
            ],
            [
                'name' => 'Royal Palms Luxury',
                'type' => 'PG',
                'rent' => 30000,
                'broker_number' => '9876543211',
                'broker_name' => 'Jane Smith',
                'rules' => ['Visitors allowed until 8 PM'],
                'amenities' => ['AC', 'WiFi', 'Swimming Pool'],
                'distance' => 2.0,
                'is_luxury' => true,
                'luxury_order' => 2,
                'area' => 'Sus',
                'gender' => 'Girls'
            ],
            [
                'name' => 'Comfort PG',
                'type' => 'PG',
                'rent' => 12000,
                'broker_number' => '9876543212',
                'broker_name' => 'Mike Ross',
                'rules' => ['No pets'],
                'amenities' => ['WiFi', 'Lunch/Dinner'],
                'distance' => 3.0,
                'is_luxury' => false,
                'area' => 'Baner',
                'gender' => 'Boys'
            ],
            [
                'name' => 'Student Haven',
                'type' => 'PG',
                'rent' => 8000,
                'broker_number' => '9876543213',
                'broker_name' => 'Harvey Specter',
                'rules' => ['Strict silence after 10 PM'],
                'amenities' => ['WiFi', 'Water Purifier'],
                'distance' => 5.5,
                'is_luxury' => false,
                'area' => 'Sus',
                'gender' => 'Boys'
            ],
            [
                'name' => 'Green Valley PG',
                'type' => 'PG',
                'rent' => 15000,
                'broker_number' => '9876543214',
                'broker_name' => 'Donna Paulsen',
                'rules' => ['Electric appliances extra'],
                'amenities' => ['WiFi', 'Attached Washroom'],
                'distance' => 4.2,
                'is_luxury' => false,
                'area' => 'Hinjewadi',
                'gender' => 'Girls'
            ],
        ];

        foreach ($stays as $stay) {
            \App\Models\Stay::create($stay);
        }
    }
}
