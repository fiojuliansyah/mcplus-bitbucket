<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Grade;
use App\Models\Plan;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\GradesSeeder;
use Database\Seeders\TopicsSeeder;

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
<<<<<<< HEAD
            // TopicsSeeder::class,
=======
            TopicsSeeder::class,
>>>>>>> 33644b8 (add Topics)
        ]);
    }
}
