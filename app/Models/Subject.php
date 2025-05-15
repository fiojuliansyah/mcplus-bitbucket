<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'grade_id', 'image', 'trailer', 'status'];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'model_has_subjects');
    }
}
