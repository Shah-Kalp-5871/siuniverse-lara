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
        // 1. International Students Group
        Community::updateOrCreate(
            ['name' => 'International Students Community'],
            [
                'category' => 'International',
                'invite_link' => 'https://chat.whatsapp.com/intl-students',
                'status' => 'Active',
            ]
        );

        // 2. PG Community
        Community::updateOrCreate(
            ['name' => 'Lara PG Community'],
            [
                'category' => 'PG',
                'invite_link' => 'https://chat.whatsapp.com/lara-pg',
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
    }
}
