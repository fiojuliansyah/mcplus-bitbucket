<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    protected $fillable = [
        'grade_id', 
        'subject_id', 
<<<<<<< HEAD
        'topic_id', 
        'user_id', 
=======
        'topic', 
>>>>>>> e9bf435 (Add Live Class management for tutor)
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

<<<<<<< HEAD
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject()
=======
    public function subjects()
>>>>>>> e9bf435 (Add Live Class management for tutor)
    {
        return $this->belongsTo(Subject::class);
    }

<<<<<<< HEAD
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
=======
    public function grades()
    {
        return $this->belongsTo(Grade::class);
>>>>>>> e9bf435 (Add Live Class management for tutor)
    }

    // public function topics()
    // {
    //     return $this->belongsTo(Topic::class);
    // }
}
