<?php

namespace App\Http\Livewire;

use App\EtcLocker;
use App\Models\Levels;
use App\Models\ServerHistory;
use App\Models\SetLocker;
use Carbon\Carbon;
use Hamcrest\Core\Set;
use Livewire\Component;
use Woeler\DiscordPhp\Message\DiscordEmbedMessage;
use Woeler\DiscordPhp\Webhook\DiscordWebhook;

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
    public $run_filters = true;

    public $players_sizes = [
        'low','medium','high'
    ];
    public $players_size = 'medium';

    public $notIn = [];

    public $totals = 0;

    public $players_avaliable;
    public $players_limitation = [];


    // locker
    public $lock_id = null;
    public $locked = false;
    public $locked_user = '';
    public $locked_expires = null;

    public $historyRotation = [];

    public function mount(){
        $this->latestMaps();
        $this->populateMode();
        $this->checkButton();
    }

    public function checkButton(){
        $locker = SetLocker::where('status','locked')->where('user_id','!=',session()->get('admin_id'))->count();
        if( $locker ){
            $this->locked = true;
            $userActive = SetLocker::where('status','locked')->where('user_id','!=',session()->get('admin_id'))->first();
            $this->locked_user = $userActive->user->nickname;
            $this->locked_expires = Carbon::parse($userActive->created_at)->diffForHumans();
            if(Carbon::parse($userActive->created_at)->isPast()){
                SetLocker::where('id',$userActive->id)->update([
                    'status' => 'expired'
                ]);
                $EtcLocker = new EtcLocker();
                $EtcLocker->discordAbandouVote($userActive);
            }
        }
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

    public function setPlayerSize($size){
        $this->players_size = $size;
        $this->populateMode();
    }

    public function generateVotemap( $tryAgain = false ){

        if(!session()->has('admin_logged')){
            if( !session()->has('master_logged')){
                return redirect('/login');
            }
        }

        $locker = new EtcLocker( session()->get('admin_id'));

        // Não está travado, ou é do proprio usuário
        if( $locker->checkHasLocked() == false ){
            $entityLock = $locker->indexLocker();
            $this->lock_id = $entityLock->id;

            if($entityLock->rotations_history && $tryAgain==false)
                foreach($entityLock->rotations_history as $rHistory){
                    $this->historyRotation[] = $rHistory;
                }

            \Log::info(session()->get('admin_username').' is generating ');

            $this->loader = true;
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
                $votemap_history = [];
                $sorteado = $this->getRandom( $limit );

                $this->sorteado = [];
                foreach($sorteado as $item){
                    $this->sorteado[] = $items[ $item ];
                    $votemap_text .= ' '.substr($items[ $item ]['Key'],0,9).' ';
                    $votemap_history[] = $items[ $item ]['Name'];
                }
                $this->timestamp = Carbon::now()->format('d/m/Y H:i:s');
                $this->votemap_text = $votemap_text;

            }

            $this->loader = false;

            $this->historyRotation[] = $votemap_history;

            SetLocker::where('id',$this->lock_id)->update([
                'rotations_history'=>$this->historyRotation,
            ]);

         #   dd($this->votemap_text,$votemap_history);
            #dd($SetLocker);
           # dd($index->expires_at->diffForHumans());
        }



    }

    public function confirmVotemap(){

        $Entity = SetLocker::where('id',$this->lock_id)->first();

        if(count($this->historyRotation)>=2){
            $votado = $this->historyRotation[ count($this->historyRotation)-1 ];
        }else{
            $votado = $this->historyRotation[0];
        }

        SetLocker::where('id',$this->lock_id)->update([
            'votemap' => $votado,
            'rotations_history'=>$this->historyRotation,
            'status'=>'complete'
        ]);

        $text_votado = implode(',  ',$votado);
        $nick = $Entity->user->nickname;

        $message = (new DiscordEmbedMessage())
            ->setAvatar(env('BOT_AVATAR'))
            ->setUsername(env('BOT_NAME') )
            ->setTitle(ucfirst($nick).' realizou um votemap!')
            ->setDescription( $text_votado)
            ->setColor( 3066993);

        if(count($this->historyRotation)==2){
            $message->addField('Tentativa anterior', implode(', ',$this->historyRotation[0]));
        }
        if(count($this->historyRotation)>=3){
            $copy = ($this->historyRotation);
            unset($copy[ count($copy) -1 ]);
            $i=1;
            foreach($copy as $line){
                $message->addField('Tentativa #'.$i, implode(', ',$line));
                $i++;
            }
        }

        $webhook = new DiscordWebhook( env('DSC_MAP') );
        $webhook->send($message);

        return redirect('/');   // logout

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
        $latest_maps = ServerHistory::whereBetween('timestamp', [Carbon::now()->startOfDay()->subDays(env('DAYS_HISTORY'))->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])->get();
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

        $this->totals = 0;

        if($this->index_mode == 'skirmish' or $this->index_mode == 'cnc' or $this->index_mode == 'vehicles' or $this->gamemap=="Vietnam" or $this->gamemap=="Ww2"){
            $this->run_filters = false;
        }else{
            $this->run_filters = true;
        }

        foreach($avaliable_maps as $map_item){

            if( isset($this->notIn[$this->index_mode][ $map_item['Image'] ])){
                $map_item['Avaliable'] = false;
                $map_item['LatestGame'] = $this->notIn[ $this->index_mode ][ $map_item['Image'] ]['timestamp'];
            }else{
                $map_item['Avaliable'] = true;
                $map_item['LatestGame'] = '';
            }

            if($this->run_filters == true){

                if( $this->players_size == 'medium') {
                    if($map_item['Size']<=1){
                        if( !isset( $map_item['Layouts'][$this->index_mode][32]) ) {
                            $map_item['Avaliable'] = false;
                            $map_item['motive'] = 'small map';
                        }
                    }

                    if($map_item['Size']>=3){
                        $map_item['Avaliable'] = false;
                        $map_item['motive'] = 'large map';
                    }
                }

                if( $this->players_size == 'high'){

                    if(!$map_item['Ww2']){

                        if($map_item['Size']<=1){
                            $map_item['Avaliable'] = false;
                            $map_item['motive'] = 'small map';
                        }
                        /*
                        if($map_item['Size']==2 && $this->index_mode!="insurgency"){
                              if( !isset( $map_item['Layouts'][$this->index_mode][32]) ) {
                                  $map_item['Avaliable'] = false;
                                  $map_item['motive'] = 'no have alt layout';
                              }
                          }
                        */
                        /*
                            if($map_item['Size']==2){
                                 if( !isset( $map_item['Layouts'][$this->index_mode][32]) ) {
                                     $map_item['Avaliable'] = false;
                                     $map_item['motive'] = 'no have alt layout';
                                 }
                             }
                        */

                    }
                }

                if( $this->players_size == 'low'){
                    /*
                        if( !isset( $map_item['Layouts'][$this->index_mode][16]) ){
                            if($map_item['Size']>=2) {
                                $map_item['Avaliable'] = false;
                                $map_item['motive'] = 'no have inf mod';
                            }
                        }
                    */

                    if($map_item['Size']>=3){
                        $map_item['Avaliable'] = false;
                        $map_item['motive'] = 'large map';
                    }
                }
            }

            if($this->gamemap=="Ww2"){
                if($map_item['Ww2']){

                    if($map_item['Avaliable']){
                        $this->totals++;
                    }
                    $result[] = $map_item;
                }
            }
            if($this->gamemap=="Vietnam"){
                if($map_item['Vietnam']){

                    if($map_item['Avaliable']){
                        $this->totals++;
                    }
                    $result[] = $map_item;
                }
            }
            if($this->gamemap=="All"){
                $result[] = $map_item;
                if($map_item['Avaliable']){
                    $this->totals++;
                }
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
