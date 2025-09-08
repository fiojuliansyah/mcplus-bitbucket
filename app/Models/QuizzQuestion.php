<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizzQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quizz_id',
        'question_text',
        'answer_type',
        'options',
        'correct_answer',
        'score',
        'media_url',
        'media_type',
    ];

    protected $casts = [
        'options' => 'array',
        'correct_answer' => 'array',
    ];

    public function quizz()
    {
        return $this->belongsTo(Quizz::class);
    }
}
