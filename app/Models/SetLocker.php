<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetLocker extends Model
{
    public $table = 'set_locker';

    protected $fillable = [
        'user_id',
        'status',
        'rotations',
        'rotations_history'
    ];

    protected $hidden = [
        'password',
    ];

}
