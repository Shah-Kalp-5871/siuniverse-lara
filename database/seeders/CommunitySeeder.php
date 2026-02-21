<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Community;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. International Students Group (General)
        Community::updateOrCreate(
            ['name' => 'International Students Community'],
            [
                'category' => 'General',
                'invite_link' => 'https://chat.whatsapp.com/intl-students',
                'status' => 'Active',
                'origin' => 'International',
            ]
        );

        // 2. PG/Flats Community
        Community::updateOrCreate(
            ['name' => 'Lara PG/Flats Community'],
            [
                'category' => 'PG/Flats',
                'invite_link' => 'https://chat.whatsapp.com/lara-pg-flats',
                'status' => 'Active',
            ]
        );

        // 3. Day Scholars Community
        Community::updateOrCreate(
            ['name' => 'SIT Day Scholars Community'],
            [
                'category' => 'Day Scholars',
                'invite_link' => 'https://chat.whatsapp.com/sit-day-scholars',
                'status' => 'Active',
            ]
        );

        // 4. Hostel General Community
        Community::updateOrCreate(
            ['name' => 'Hostel General Group'],
            [
                'category' => 'Hostel',
                'invite_link' => 'https://chat.whatsapp.com/hostel-general',
                'status' => 'Active',
                'mess' => null,
                'gym' => null,
            ]
        );

        // 5. Mess Communities
        $messes = ['Viola Mess', 'SIT Mess', 'Petunia Mess', 'Medical Mess', 'Hilltop Mess'];
        foreach ($messes as $mess) {
            Community::updateOrCreate(
                ['name' => "$mess Community"],
                [
                    'category' => 'Hostel',
                    'invite_link' => 'https://chat.whatsapp.com/mess-' . strtolower(str_replace(' ', '-', $mess)),
                    'status' => 'Active',
                    'mess' => $mess,
                ]
            );
        }

        // 6. Gym Communities
        $gyms = ['SIT Gym', 'Viola Gym', 'Medical Gym', 'Hill Top Gym'];
        foreach ($gyms as $gym) {
            Community::updateOrCreate(
                ['name' => "$gym Community"],
                [
                    'category' => 'Hostel',
                    'invite_link' => 'https://chat.whatsapp.com/gym-' . strtolower(str_replace(' ', '-', $gym)),
                    'status' => 'Active',
                    'gym' => $gym,
                ]
            );
        }
    }
}
