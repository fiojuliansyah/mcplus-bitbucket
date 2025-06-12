<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicsSeeder extends Seeder
{
    public function run(): void
    {
        $baseTopics = [
            'Bahasa Melayu',
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

        $topics = [];

        foreach ($baseTopics as $topic) {
            for ($i = 1; $i <= 3; $i++) {
                $topics[] = "$topic $i";
            }
        }


        $subjects = DB::table('subjects')->get();

        foreach ($subjects as $subject) {
            foreach ($topics as $topic) {
                DB::table('topics')->insert([
                    'subject_id' => $subject->id,
                    'name' => $topic,
                    'slug' => Str::slug($topic),
                    'status' => 'active',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
