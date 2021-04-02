<?php

namespace App\Http\Livewire\Admin;

use App\Models\LevelsPlayers;
use Livewire\Component;

class MapCheckbox extends Component
{

    public  $map_key,
            $size,
            $game_mode,
            $layout;

    public $iai;

    //  'map_key','code','game_mode','layout'
    public function mount( $map_key , $size, $game_mode ){
        $this->map_key = $map_key;
        $this->size = $size;
        $this->game_mode = $game_mode;

        //  'map_key','size','game_mode','layout'
        if( LevelsPlayers::where('map_key',$this->map_key)->where('size',$this->size)->where('game_mode',$this->game_mode)->count() == 1){
            $this->iai=true;
        }

    }

    public function updatedIai( $value ){

        if($value){
            LevelsPlayers::firstOrCreate([
                'map_key' => $this->map_key,
                'size' => $this->size,
                'game_mode' => $this->game_mode,
            ]);
        }else{
            LevelsPlayers::where('map_key',$this->map_key)->where('size',$this->size)->where('game_mode',$this->game_mode)->delete();
        }
    }

    public function render()
    {
        return view('livewire.admin.map-checkbox');
    }
}
