<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerHistory extends Model
{

    public $table = 'server_history';

    protected $fillable = [
        'name', 'map_key', 'map_mode','map_size','timestamp'
    ];

    public $timestamps = false;
}
