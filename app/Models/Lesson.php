<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'lessons';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'start',
        'end',
        'max',
        'service_id',
        'tutor_id'
    ];
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id', 'id');
    }
}

