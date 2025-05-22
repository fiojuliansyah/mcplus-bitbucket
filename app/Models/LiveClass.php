<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveClass extends Model
{
    protected $fillable = [
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
}
