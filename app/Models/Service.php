<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'description',
        'cost',
        'image',
        'type_id'
    ];
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
}
