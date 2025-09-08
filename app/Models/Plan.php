<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'price', 'description', 'duration', 'duration_value', 'device_limit', 'profile_limit', 'status', 'is_weekly_live_classes', 'is_materials', 'is_quizzes', 'replay_day'];

    protected $casts = [
        'duration_value' => 'integer',
        'price' => 'float',
    ];
}
