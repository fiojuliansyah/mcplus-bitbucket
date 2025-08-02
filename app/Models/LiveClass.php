<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    protected $fillable = [
        'grade_id', 
        'subject_id', 
<<<<<<< HEAD
<<<<<<< HEAD
        'topic_id', 
        'user_id', 
=======
        'topic', 
>>>>>>> e9bf435 (Add Live Class management for tutor)
=======
        'topic_id', 
        'user_id', 
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
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
<<<<<<< HEAD
=======
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject()
<<<<<<< HEAD
=======
    public function subjects()
>>>>>>> e9bf435 (Add Live Class management for tutor)
=======
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
    {
        return $this->belongsTo(Subject::class);
    }

<<<<<<< HEAD
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
=======
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
    }

    // public function topics()
    // {
    //     return $this->belongsTo(Topic::class);
    // }
}
