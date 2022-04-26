<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'types';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name'
    ];

    public function services() {
        return $this->hasMany(Service::class, 'type_id', 'id');
    }
}
