<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            'bahasa melayu',
            'English',
            'Mathematics',
            'Science',
            'Sejarah',
            'Physics',
            'Chemistry',
            'Biology',
            'Add Math',
            'Accounts',
            'Ekonomi',
            'Perniagaan',
            'Geografi',
        ];

        $grades = DB::table('grades')->get();

        foreach ($grades as $grade) {
            foreach ($subjects as $subject) {
                DB::table('subjects')->insert([
                    'grade_id' => $grade->id,
                    'name' => $subject,
                    'slug' => Str::slug($subject),
                    'thumbnail' => Str::slug($subject) . '.png',
                    'status' => 'active',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
