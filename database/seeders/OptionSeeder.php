<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;
use App\Models\RuleRegulation;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amenities = ['Ac', 'Gyser', 'Laundry', 'Wifi', 'Power Backup', 'Parking', 'CCTV', 'Meals'];
        foreach ($amenities as $amenity) {
            Amenity::firstOrCreate(['name' => $amenity]);
        }

        $rules = ['No Smoking', 'No Pets', 'Strict Curfew', 'Quiet Hours', 'No Visitors', 'Veg Only'];
        foreach ($rules as $rule) {
            RuleRegulation::firstOrCreate(['name' => $rule]);
        }
    }
}
