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

    public function liveClass()
    {
        return $this->hasMany(LiveClass::class);
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
