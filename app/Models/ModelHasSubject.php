<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHasSubject extends Model
{
    protected $table = 'model_has_subjects';

    protected $fillable = ['user_id', 'subject_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
