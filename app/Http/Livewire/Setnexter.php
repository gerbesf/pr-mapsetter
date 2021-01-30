<?php

namespace App\Http\Livewire;

use App\Models\Levels;
use App\Models\ServerHistory;
use Carbon\Carbon;
use Livewire\Component;

class Setnexter extends Component
{

    public $gamemode = "Aas";
    public $gamemap = 'All';
    public $loader = true;
    public $index_mode;
    public $sorteado;
    public $gamemodeAvaliable = [
        'Aas' => 'cq',
        'Insurgency' => 'insurgency',
        'Cnc' => 'cnc',
        'Skirmish' => 'skirmish',
        'Vehicle' => 'vehicles',
    ];
    public $avaliable_maps = [];
    public $latest_maps = [];
    public $timestamp;

    public $unavaliable = false;
    public $votemap_text = '';
    public $mapsize = 8;

    public $notIn = [];

    public function mount(){
        $this->latestMaps();
        $this->populateMode();
    }

    public function setMode( $mode , $sync = true ){
        $this->loader = true;
        $this->gamemode = $mode;
        $this->gamemap = 'All';
     #   $this->avaliable_maps = [];
        $this->sorteado = [];
        if($sync){
            $this->populateMode();
        }
    }

    public function setMapMode( $mode ){
        $this->loader = true;
        $this->gamemap = $mode;
        $this->sorteado = [];
        $this->populateMode();
    }

    public function setMapSize($size){
        $this->loader = true;
        $this->mapsize = $size;
        $this->populateMode();
    }

    public function generateVotemap(){

        $this->loader = true;

        sleep(1);
        $items = array_values(collect($this->avaliable_maps)->filter(function ($item){
            if($item['Avaliable']==true){
                return $item;
            }
        })->toArray());

        $limit = count($items)-1;

        if($limit<=1){

            $this->unavaliable = true;

        }else{

            $this->unavaliable = false;
            $votemap_text = 'votemap ';
            $sorteado = $this->getRandom( $limit );

            # dd($items,$sorteado,$limit);
            $this->sorteado = [];
            foreach($sorteado as $item){
                $this->sorteado[] = $items[ $item ];
                $votemap_text .= ' '.substr($items[ $item ]['Key'],0,9).' ';
            }
            $this->timestamp = Carbon::now()->format('d/m/Y H:i:s');
            $this->votemap_text = $votemap_text;

        }

        $this->loader = false;
    }

    public function getRandom( $limit ){
        $numbers = array();
        while ( count($numbers) <= 2 ) {
            $x = mt_rand(0,$limit);
            if ( !in_array($x,$numbers) ) {
                $numbers[] = $x;
            }
        }

        return $numbers;
    }


    public function latestMaps(){
        $latest_maps = ServerHistory::whereBetween('timestamp', [Carbon::now()->startOfDay()->subDays(2)->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])->get();
        foreach($latest_maps as $itemm){
            $this->notIn[ $itemm->map_mode][$itemm->map_key] =  [
                'key'=>$itemm->map_key,
                'timestamp'=>Carbon::parse($itemm->timestamp)->diffForHumans(),
            ];
        }
    }

    public function populateMode(){
        $this->loader = true;
        $avaliable_maps = Levels::where($this->gamemode,true)->where('Size','<=',$this->mapsize)->get()->toArray();
        $result = [];
        $this->index_mode = $this->gamemodeAvaliable [ $this->gamemode ];
        foreach($avaliable_maps as $map_item){
            if( isset($this->notIn[$this->index_mode][ $map_item['Image'] ])){
                $map_item['Avaliable'] = false;
                $map_item['LatestGame'] = $this->notIn[ $this->index_mode ][ $map_item['Image'] ]['timestamp'];
            }else{
                $map_item['Avaliable'] = true;
                $map_item['LatestGame'] = '';
            }
            if($this->gamemap=="Ww2"){
                if($map_item['Ww2'])
                    $result[] = $map_item;
            }
            if($this->gamemap=="Vietnam"){
                if($map_item['Vietnam'])
                    $result[] = $map_item;
            }
            if($this->gamemap=="All"){
                $result[] = $map_item;
            }
        }

        $this->avaliable_maps = $result;

        $this->loader = false;

    }

    public function render()
    {
        return view('livewire.setnexter');
    }
}
