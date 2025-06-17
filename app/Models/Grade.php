<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image'];

        public function subjects()
        {
            return $this->hasMany(Subject::class);
        }

        public function topics()
        {
            return $this->hasMany(Topic::class);
        }

        public function liveClass()
        {
            return $this->hasMany(LiveClass::class);
        }

}
