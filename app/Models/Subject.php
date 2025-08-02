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
<<<<<<< HEAD
<<<<<<< HEAD
        return $this->hasMany(Topic::class);
    }

    public function liveClass()
    {
        return $this->hasMany(LiveClass::class);
=======
        return $this->hasMany(Topics::class);
>>>>>>> 33644b8 (add Topics)
=======
        return $this->hasMany(Topic::class);
>>>>>>> 27cb97e (Add Subject Detail Page to show the topics)
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_subjects', 'subject_id', 'user_id');
    }

    public function replayClass()
    {
        return $this->hasMany(ReplayClass::class);
    }

    public function quizz()
    {
        return $this->hasMany(Quizz::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class);
    }
}
