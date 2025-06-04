<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'grade_id', 'thumbnail', 'cover', 'trailer', 'status'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_subjects', 'subject_id', 'user_id');
    }
}
