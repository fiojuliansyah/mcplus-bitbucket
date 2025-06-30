<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplayClass extends Model
{

    protected $fillable = ['grade_id', 'subject_id', 'topic_id', 'user_id', 'replay_url', 'replay_public_id', 'status'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
