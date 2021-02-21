<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetLocker extends Model
{
    public $table = 'set_locker';

    protected $fillable = [
        'user_id',
        'status',
        'votemap',
        'rotations_history',
    ];

    protected $casts = [
        'rotations_history' => 'array',
        'votemap' => 'array',
    ];

    protected $hidden = [
        'password',
    ];

    public function user(){
        return $this->hasOne('App\Models\Admin','id','user_id');
    }

}
