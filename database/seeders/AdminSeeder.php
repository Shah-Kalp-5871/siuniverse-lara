<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Your Admin Account
        Admin::updateOrCreate(
            ['email' => 'shivansh2915@gmail.com'],
            ['password' => Hash::make('demo123')]
        );

        // Second Admin Account
        // Admin::updateOrCreate(
        //     ['email' => 'secondadmin@example.com'],
        //     ['password' => Hash::make('their-password-here')]
        // );
        
        // Add as many as you need...
    }

}
