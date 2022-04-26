<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $table = 'pets';

    public $timestamps = false;

    public static $gender = ['male', 'female'];

    protected $fillable = [
        'id',
        'name',
        'birthday',
        'image',
        'gender',
        'breed',
        'owner_id'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
