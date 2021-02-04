<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\Generator;
use App\Http\Controllers\Helpers\Prspy;
use App\Models\Administrators;
use App\Models\Levels;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MaplistController extends Controller
{
    use Prspy;
    use Generator;



    public function __construct()
    {

    }

    public function index( Request $request ){

        #$Maps = Levels::whereJsonContains('Layouts', ['Key' => 'gpm_skirmish','Value'=> 16]) ->get();
        $Maps = Levels::get();

        return view('admin.maplist',[
            'menu'=>'actions',
            'maps'=>$Maps
        ]);
    }

    public function update(){

        $lista = json_decode(file_get_contents('https://www.realitymod.com/mapgallery/json/levels.json'));
        foreach($lista as $item){
            print_r($item);
            $array_object = collect($item)->toArray();

            $attritutes = $this->getMapAttributes($array_object['Key'], $array_object['Layouts'] );
            $array_object = array_merge($array_object,$attritutes);

            if(  count(explode(' - ',$array_object['Name'])) == 2){
                $array_object['Image']=str_replace(' ','',strtolower($array_object['Name']));
            }else{
                $array_object['Image']=str_replace('-','',\Illuminate\Support\Str::slug($array_object['Name']));
            }
            $array_object['Slug'] = str_replace(['-','_'],'',$array_object['Image']);
            $check = Levels::where('Name',$array_object['Name'])->count();

            $datas = $this->configureSizes( $attritutes['Layouts']);
            #dd($datas);

            if($check==0){
                Levels::create( $array_object );
            }else{
                Levels::where('Name',$array_object['Name'])->update( $array_object );
            }
        }

        return redirect('/admin');
    }


    // 0_40|41_60|61_80|81_100
    // inf |
    public function configureSizes( $Layouts ){

     #   $qnt_players = explode('|','0_40|41_60|61_80|81_100');
        $qnt_players = [];

        foreach ($Layouts as $mode=>$sizes){

            if( !in_array('Large',$sizes)){
             #   dd('achei');
            }
                #dd($mode,$sizes);
                foreach ( $sizes as $key=>$item){
                    if($key==16){
                        $qnt_players[$mode]['0_40'][]= $this->size_names [ $key ];
                    }
                    if($key==32){
                        $qnt_players[$mode]['41_60'][]= $this->size_names [ $key ];
                        $qnt_players[$mode]['61_80'][]= $this->size_names [ $key ];
                        $qnt_players[$mode]['81_100'][]= $this->size_names [ $key ];
                    }
                    if($key==64){
                        $qnt_players[$mode]['0_40'][]= $this->size_names [ $key ];
                        $qnt_players[$mode]['41_60'][]= $this->size_names [ $key ];
                        $qnt_players[$mode]['61_80'][]= $this->size_names [ $key ];
                        $qnt_players[$mode]['81_100'][]= $this->size_names [ $key ];
                    }
                    if($key==128){
                        $qnt_players[$mode]['61_80'][]= $this->size_names [ $key ];
                        $qnt_players[$mode]['81_100'][]= $this->size_names [ $key ];
                    }
                }
        }
        #dd($Layouts,$qnt_players);
       # dd($Layouts,$filas);
    }

    public function getMapAttributes( $map_key, $layouts ){

        $ww2 = false;
        $aas = false;
        $Vietnam = false;
        $insurgency = false;
        $vehicle = false;
        $skirmish = false;
        $cnc = false;

        $layoutss = [];

        foreach($layouts as $layout){
            $key_to_match = str_replace('gpm_','',$layout->Key);

            if($key_to_match=='cq'){
                $aas = true;
                $layoutss[ $key_to_match ][ $layout->Value ] = $this->size_names [ $layout->Value ] ;
            }
            if($key_to_match=='insurgency'){
                $insurgency = true;
                $layoutss[ $key_to_match ][ $layout->Value ] = $this->size_names [ $layout->Value ] ;
            }
            if($key_to_match=='skirmish'){
                $skirmish = true;
                $layoutss[ $key_to_match ][ $layout->Value ] = $this->size_names [ $layout->Value ] ;
            }
            if($key_to_match=='vehicles'){
                $vehicle = true;
                $layoutss[ $key_to_match ][ $layout->Value ] = $this->size_names [ $layout->Value ] ;
            }
            if($key_to_match=='cnc'){
                $cnc = true;
                $layoutss[ $key_to_match ][ $layout->Value ] = $this->size_names [ $layout->Value ] ;
            }

            // WW2
            if(in_array($map_key, $this->ww2_maps)){
                $ww2 = true;
            }

            // Vietinan
            if(in_array($map_key, $this->Vietnam_maps)){
                $Vietnam = true;
            }

        }
        return [
            'Ww2' => $ww2,
            'Aas' => $aas,
            'Vehicle' => $vehicle,
            'Insurgency' => $insurgency,
            'Skirmish' => $skirmish,
            'Cnc' => $cnc,
            'Vietnam' => $Vietnam,
            'Layouts' => $layoutss
        ];
    }

}
