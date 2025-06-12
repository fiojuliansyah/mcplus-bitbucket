<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topics extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'subject_id', 'status'];

        public function subjects()
        {
            return $this->belongsTo(Subject::class);
        }

        // This can be added for grading the topics for student/user
        

}
