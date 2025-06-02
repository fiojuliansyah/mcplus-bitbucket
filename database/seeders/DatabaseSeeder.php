<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Grade;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\GradesSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            PermissionsSeeder::class,
            GradesSeeder::class,
            SubjectsSeeder::class,
            PlanSeeder::class,
        ]);
    }
}
