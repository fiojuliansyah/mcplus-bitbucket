<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'grade_id', 'thumbnail', 'cover', 'trailer', 'status'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_subjects', 'subject_id', 'user_id');
    }

    public function tutors()
    {
        return $this->belongsToMany(User::class, 'model_has_subjects', 'subject_id', 'user_id')
                    ->where('account_type', 'tutor');
    }

    public function getTutorAttribute()
    {
        return $this->tutors->first();
    }

    public function notes()
    {
        return $this->hasManyThrough(Note::class, Topic::class);
    }

    public function quizzes()
    {
        return $this->hasManyThrough(Quizz::class, Topic::class);
    }

    public function replayClasses()
    {
        return $this->hasManyThrough(ReplayClass::class, Topic::class);
    }
    
    public function liveClasses()
    {
        return $this->hasManyThrough(LiveClass::class, Topic::class);
    }

    public function latestTopic()
    {
        return $this->hasOne(Topic::class)->latestOfMany();
    }

    public function latestNote()
    {
        return $this->hasOneThrough(Note::class, Topic::class)->latestOfMany();
    }

    public function latestReplay()
    {
        return $this->hasOneThrough(ReplayClass::class, Topic::class)->latestOfMany();
    }
    
    public function latestQuizz()
    {
        return $this->hasOneThrough(Quizz::class, Topic::class)->latestOfMany();
    }

    public function latestLiveClass()
    {
        return $this->hasOneThrough(LiveClass::class, Topic::class)->latest('start_time');
    }
}