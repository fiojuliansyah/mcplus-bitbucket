<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';
    
        protected $fillable = [
        'grade_id',
        'subject_id',
        'topic_id',
        'user_id',
        'start_date',
        'end_date',
        'max_score',
        'attempts_time',
        'estimate_time',
        'total_question',
        'auto_mark',
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

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizzQuestion::class, 'quizz_id');
    }
}