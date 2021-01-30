<?php

namespace App\Http\Controllers\Helpers;

use App\Models\DiscrodHooks;
use App\Models\Levels;
use App\Models\Server;
use Carbon\Carbon;

trait Generator
{

    protected $ww2_maps = [
        'carentan',
        'merville',
        'omaha_beach',
        'reichswald',
        'brecourtassault'
    ];

    protected $Vietnam_maps = [
        'charlies_point',
        'battle_of_ia_drang',
        'hill_488',
        'op_barracuda',
        'tad_sae'
    ];

    protected $size_names = [
        '16' => 'Infantry',
        '32' => 'Alternative',
        '64' => 'Standard',
        '128' => 'Large',
    ];

    public function prepareFilters(){
        $Maps = Levels::get();
        dd($Maps);
    }
}
