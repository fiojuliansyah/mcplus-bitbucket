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
<<<<<<< HEAD

        public function liveClass()
        {
            return $this->hasMany(LiveClass::class);
        }

        public function replayClass()
        {
            return $this->hasMany(ReplayClass::class);
        }

        public function quizz()
        {
            return $this->hasMany(Quizz::class);
        }
        public function tests()
        {
            return $this->hasMany(Test::class);
        }
=======
>>>>>>> 27cb97e (Add Subject Detail Page to show the topics)

        public function liveClass()
        {
            return $this->hasMany(LiveClass::class);
        }

        public function replayClass()
        {
            return $this->hasMany(ReplayClass::class);
        }

}
