<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'name',
        'description',
        'file_url',
        'file_public_id',
        'key_url',
        'key_public_id',
        'status',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }
}
