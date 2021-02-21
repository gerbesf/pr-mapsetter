<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $table = 'admins';

    protected $fillable = [
        'nickname',
        'username',
        'password',
        'level',
        'hash'
    ];

    protected $hidden = [
        'password',
    ];
}
