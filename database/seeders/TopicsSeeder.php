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
<<<<<<< HEAD
        $grades = DB::table('grades')->get();       // All grades
        $subjects = DB::table('subjects')->get();   // All subjects

        foreach ($grades as $grade) {
            foreach ($subjects as $subject) {
                $baseTopics = [
                    "{$subject->name} 1",
                    "{$subject->name} 2",
                    "{$subject->name} 3",
                ];
                foreach ($baseTopics as $topicName) {
                    DB::table('topics')->insert([
                        'subject_id' => $subject->id,
                        'grade_id' => $grade->id,
                        'name' => $topicName,
                        'slug' => Str::slug($topicName),
                        'status' => 'active',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
=======
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
>>>>>>> 33644b8 (add Topics)
            }
        }
    }
}
