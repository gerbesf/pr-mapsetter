<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Levels extends Model
{

    public $table = 'levels';

    protected $fillable = [
        'Name','Key', 'Resolution', 'Size', 'Color', 'Image', 'Layouts',
        'Ww2','Aas','Vehicle','Insurgency','Skirmish','Cnc','Vietnam','Slug','Status'
    ];

    protected $casts = [
        'Layouts'=>'array'
    ];

    public $timestamps = false;
}
