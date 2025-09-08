<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    protected $fillable = [
        'grade_id', 
        'subject_id', 
        'topic_id', 
        'user_id', 
        'agenda', 
        'type', 
        'duration', 
        'timezone', 
        'password', 
        'class_day',
        'start_time', 
        'settings', 
        'zoom_meeting_id', 
        'zoom_join_url', 
        'zoom_start_url',
        'status'
    ];

    protected $casts = [
        'settings' => 'array',
        'start_time' => 'datetime:H:i',
    ];

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
