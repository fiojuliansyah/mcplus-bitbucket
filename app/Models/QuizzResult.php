<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizzResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'score',
        'total_questions',
        'correct_answers',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizzAnswer::class); 
    }
}
