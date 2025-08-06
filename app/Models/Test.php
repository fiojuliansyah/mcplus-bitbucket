<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'grade_id',
        'subject_id',
        'user_id', // Tutor ID
        'name',
        'slug',
        'start_time',
        'end_time',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function testQuestions()
    {
        return $this->hasMany(TestQuestion::class);
    }
}