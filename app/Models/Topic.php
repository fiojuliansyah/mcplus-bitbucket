<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'subject_id', 'grade_id', 'status'];

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function liveClasses()
    {
        return $this->hasMany(LiveClass::class);
    }
<<<<<<< HEAD

    public function replayClass()
    {
        return $this->hasMany(ReplayClass::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quizz::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class);
    }
<<<<<<< HEAD
=======
        public function subjects()
        {
            return $this->belongsTo(Subject::class);
        }
=======
    public function subjects()
=======
    public function subject()
>>>>>>> 304dd22 (Add Datatable & CRUD for Topics)
    {
        return $this->belongsTo(Subject::class);
    }
>>>>>>> e9bf435 (Add Live Class management for tutor)

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    //     public function liveClass()
    // {
    //     return $this->hasMany(LiveClass::class);
    // }
=======
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)

    public function replayClass()
    {
        return $this->hasMany(ReplayClass::class);
    }

<<<<<<< HEAD
        // This can be added for grading the topics for student/user
        

>>>>>>> 27cb97e (Add Subject Detail Page to show the topics)
=======
    public function quizz()
    {
        return $this->hasMany(Quizz::class);
    }
>>>>>>> af32276 (Add CRUD for Quizz for Admin Perspective)
=======
>>>>>>> parent of ad55921 (update some bug)
}
