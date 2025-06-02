<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => '3 Month Plan',
                'slug' => Str::slug('3 Month Plan'),
                'price' => '50', 
                'description' => 'This plan offers access to the service for 3 months.',
                'duration' => 'month',
                'duration_value' => '3',
                'device_limit' => '5',
                'profile_limit' => '3',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '6 Month Plan',
                'slug' => Str::slug('6 Month Plan'),
                'price' => '90',
                'description' => 'This plan offers access to the service for 6 months.',
                'duration' => 'month',
                'duration_value' => '6',
                'device_limit' => '10',
                'profile_limit' => '5',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '9 Month Plan',
                'slug' => Str::slug('9 Month Plan'),
                'price' => '120',
                'description' => 'This plan offers access to the service for 9 months.',
                'duration' => 'month',
                'duration_value' => '9',
                'device_limit' => '15',
                'profile_limit' => '7',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('plans')->insert($plans);
    }
}
