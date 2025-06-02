<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GradesSeeder extends Seeder
{
    public function run(): void
    {
        $grades = [
            [
                'name' => 'FORM 5',
                'slug' => Str::slug('FORM 5'),
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'FORM 4',
                'slug' => Str::slug('FORM 4'),
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'FORM 3',
                'slug' => Str::slug('FORM 3'),
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'FORM 2',
                'slug' => Str::slug('FORM 2'),
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'FORM 1',
                'slug' => Str::slug('FORM 1'),
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'YEAR 6',
                'slug' => Str::slug('YEAR 6'),
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'YEAR 5',
                'slug' => Str::slug('YEAR 5'),
                'created_at' => Carbon::now(),
            ]
        ];

        DB::table('grades')->insert($grades);
    }
}
