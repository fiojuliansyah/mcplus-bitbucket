<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'phone_verified',
        'status',
        'profile_id',
        'account_type'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'model_has_subjects', 'user_id', 'subject_id');
    }

    public function liveClasses()
    {
        return $this->belongsToMany(LiveClass::class, 'user_id');
    }

<<<<<<< HEAD
    public function replayClass()
    {
        return $this->hasMany(ReplayClass::class);
    }

=======
>>>>>>> 7b4de55 (add Create live class, update live class table, add dynamic dropdown)
    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function quizz()
    {
        return $this->hasMany(Quizz::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function current_profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }
}
