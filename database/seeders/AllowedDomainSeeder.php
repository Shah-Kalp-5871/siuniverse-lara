<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AllowedDomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $domains = [
            'saii.siu.edu.in',
            'sibmpune.siu.edu.in',
            'sscanspune.siu.edu.in',
            'simcpune.siu.edu.in',
            'sidtmpune.siu.edu.in',
            'sitpune.siu.edu.in',
            'ssbfpune.siu.edu.in',
            'ssvappune.siu.edu.in',
            'sconpune.siu.edu.in',
            'schspune.siu.edu.in',
            'sssspune.siu.edu.in',
            'sihspune.siu.edu.in',
            'smcwpune.siu.edu.in',
            'ssodlpune.siu.edu.in',
            'stlrcpune.siu.edu.in',
            'scripune.siu.edu.in'
        ];

        foreach ($domains as $domain) {
            \App\Models\AllowedDomain::firstOrCreate(['domain' => $domain]);
        }
    }
}
