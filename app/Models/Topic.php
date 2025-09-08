<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'subject_id', 'grade_id', 'status'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function liveClasses()
    {
        return $this->hasMany(LiveClass::class);
    }

    public function replayClasses()
    {
        return $this->hasMany(ReplayClass::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quizz::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'topic_id');
    }

    public function quiz_results()
    {
        return $this->hasMany(QuizzResult::class);
    }

    public function latestReplayClass()
    {
        return $this->hasOne(ReplayClass::class)->latestOfMany();
    }


    public function latestNote()
    {
        return $this->hasOne(Note::class)->latestOfMany();
    }


    public function latestQuizz()
    {
        return $this->hasOne(Quizz::class)->latestOfMany();
    }

    public function latestLiveClass()
    {
        return $this->hasOne(LiveClass::class)->latest('start_time');
    }
}