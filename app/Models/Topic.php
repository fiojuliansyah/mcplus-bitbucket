<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'subject_id', 'grade_id', 'status'];

    public function subjects()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grades()
    {
        return $this->belongsTo(Grade::class);
    }

    //     public function liveClass()
    // {
    //     return $this->hasMany(LiveClass::class);
    // }

        // This can be added for grading the topics for student/user
        

}
