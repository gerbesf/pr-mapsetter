<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filters extends Model
{

    public $table = 'filters';

    protected $fillable = [
        'name','settings'
    ];

    protected $casts = [
        'settings'=>'array'
    ];

    public $timestamps = false;
}
