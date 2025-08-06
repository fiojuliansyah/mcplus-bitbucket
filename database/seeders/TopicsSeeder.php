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
            }
        }
    }
}
