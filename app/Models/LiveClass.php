<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    protected $fillable = [
        'grade_id', 
        'subject_id', 
        'topic', 
        'agenda', 
        'type', 
        'duration', 
        'timezone', 
        'password', 
        'start_time', 
        'settings', 
        'zoom_meeting_id', 
        'zoom_join_url', 
        'status'
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function subjects()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grades()
    {
        return $this->belongsTo(Grade::class);
    }

    // public function topics()
    // {
    //     return $this->belongsTo(Topic::class);
    // }
}
