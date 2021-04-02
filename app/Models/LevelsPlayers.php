<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelsPlayers extends Model
{

    public $table = 'levels_players';

    protected $fillable = [
        'map_key','size','game_mode','layout'
    ];

    protected $casts = [
       # 'Layouts'=>'array'
    ];

    public $timestamps = false;
}
